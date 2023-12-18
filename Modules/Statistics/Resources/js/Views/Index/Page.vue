<script setup>
import {computed, onMounted, ref, watch} from "vue";
import {router} from "@inertiajs/vue3";
import {debounce} from "lodash";

const props = defineProps({
    statistics: Object,
    operators: Object,
    dateRange: Object
});

const groupBy = ref([
    {
        key: 'group',
        order: 'desc',
    },
]);

const computedHeaders = computed(() => {
    const headers = [
        {key: 'name', title: '', sortable: false, searchable: false, width: '50%'},
        {key: 'desription', title: '', sortable: false, searchable: false, width: '15%'},
    ];

    props.operators.data.forEach(operator => {
        headers.push({
            key: operator.name,
            title: operator.name,
        });
    });

    return headers;
});

const groupReferences = ref({
    qualityParameters: 'Объем тестирования параметров качества',
    qualityIndicators: 'Нормируемые показатели качества услуг передачи данных'
});

const dataReferences = ref({
    count_user: {
        name: 'Количество пользователей',
        description: ''
    },
    count_full_tests: {
        name: 'Количество полных тестов',
        description: ''
    },
    count_dl: {
        name: 'Общее количество измерений скорости данных DL',
        description: ''
    },
    count_ul: {
        name: 'Общее количество измерений скорости данных UL',
        description: ''
    },
    count_ip_paket: {
        name: 'Общее количество измерений задержки передачи IP-пакетов',
        description: ''
    },
    count_web: {
        name: 'Общее количество измерений Web',
        description: ''
    },
    count_video: {
        name: 'Общее количество измерений видео',
        description: ''
    },
    share_dl: {
        name: 'Доля соединений для технологии UMTS/ LTE/ IMT-2020\n' +
            'со скоростью передачи данных менее 1 Мбит/с по направлению к абоненту',
        description: 'не более 10 %'
    },
    share_ul: {
        name: 'Доля соединений для технологии UMTS/ LTE/ IMT-2020\n' +
            'со скоростью передачи данных менее 1 Мбит/с по направлению от абонента',
        description: 'не более 10 % \t'
    },
    avg_dl: {
        name: 'Средняя скорость передачи данных по направлению к абоненту, Мбит/с',
        description: '-'
    },
    avg_ul: {
        name: 'Средняя скорость передачи данных по направлению от абонента, Мбит/с',
        description: '-'
    },
    share_ip_paket: {
        name: 'Доля соединений, не удовлетворяющих нормативу по времени задержки передачи IP-пакетов, не более 400 мс',
        description: 'не более 10 %'
    },
    coefficient_loss: {
        name: 'Коэффициент потери IP-пакетов',
        description: 'не более 3 %'
    },
    avg_time_web: {
        name: 'Среднее время загрузки WEB-страниц',
        description: 'не более 6 с'
    },
    share_time_web: {
        name: 'Доля сеансов, не удовлетворяющих нормативам по времени загрузки WEB-страниц более 6 с',
        description: 'не более 25 %'
    },
    avg_time_video: {
        name: 'Среднее время начала воспроизведения видео',
        description: 'не более 10 с'
    },
    share_time_video: {
        name: 'Доля сеансов, не удовлетворяющих нормативам по времени начала воспроизведения видео более 10 с',
        description: 'не более 10 %'
    }
});

const headers = ref(computedHeaders);
const search = ref(null);

const items = ref([]);
const loading = ref(false);

const isRoomFilterItems = ref([
    { name: 'Все', value: null },
    { name: 'Внутри помещения', value: true },
    { name: 'Снаружи помещения', value: false }
]);

const params = ref({
    filters: {
        created_at: [null, null],
        is_room: null
    }
});

function getItems() {

    router.get('/statistics', params.value, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
        only: ['statistics'],
        onBefore: () => {
            loading.value = true;
        },
        onSuccess: () => {
            items.value = props.statistics;
            loading.value = false;
        }
    });
}

watch(params, debounce(() => getItems(), 300), {deep: true});
onMounted(() => getItems());

</script>

<template>
    <h1>Статистика</h1>

    <v-card>
        <v-card-title>
            <v-row class="mt-2">
                <v-col cols="12" md="3">
                    <v-text-field
                        clearable
                        type="date"
                        label="Дата с"
                        :max="params.filters.created_at[1]"
                        v-model="params.filters.created_at[0]"
                    />
                </v-col>
                    <v-col cols="12" md="3">
                    <v-text-field
                        clearable
                        type="date"
                        label="Дата по"
                        :min="params.filters.created_at[0]"
                        v-model="params.filters.created_at[1]"
                    />
                </v-col>
                <v-col cols="12" md="2">
                    <v-select
                        label="Место"
                        :items="isRoomFilterItems"
                        v-model="params.filters.is_room"
                        item-title="name"
                        item-value="value"
                    />
                </v-col>
                <v-col cols="12" md="4">
                    <v-text-field
                        clearable
                        label="Поиск"
                        v-model="search"
                    />
                </v-col>
            </v-row>
        </v-card-title>
        <v-card-item>
            <v-data-table
                :search="search"
                :group-by="groupBy"
                :headers="headers"
                :items="items"
                :items-per-page="-1"
                :items-length="0"
                item-key="name"
                :loading="loading"
                no-data-text="Нет данных"
                loading-text="Загрузка данных с сервера..."
            >
                <template v-slot:loader>
                    <v-progress-linear indeterminate color="success" :loading="loading"/>
                </template>

                <template v-slot:group-header="{ item, columns, toggleGroup, isGroupOpen, openGroup }">
                    <tr>
                        <td :colspan="columns.length" class="bg-green-lighten-5">
                            <v-btn
                                variant="text"
                                :icon="isGroupOpen(item) ? '$expand' : '$next'"
                                @click="toggleGroup(item)"
                            />
                            <b>{{ groupReferences[item.value] ?? item.value }}</b>
                        </td>
                    </tr>
                </template>

                <template v-slot:item.name="{ item }">
                    <p class="my-2">{{ dataReferences[item.name]?.name ?? item.name }}</p>
                </template>

                <template v-slot:item.desription="{ item }">
                    {{ dataReferences[item.name]?.description ?? item.description }}
                </template>

                <template v-slot:bottom></template>
            </v-data-table>
        </v-card-item>
    </v-card>
</template>
