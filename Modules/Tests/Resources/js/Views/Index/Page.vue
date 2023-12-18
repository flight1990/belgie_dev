<script setup>
import {onMounted, ref, watch} from "vue";
import {router} from "@inertiajs/vue3";
import {debounce} from "lodash";

const props = defineProps({
    tests: Object,
    servers: Object,
    operators: Object,
    standards: Object,
    connectionTypes: Object,
});

const headers = ref([
    {key: 'id', title: 'ID'},
    {key: 'x', title: 'Долгота'},
    {key: 'y', title: 'Широта'},
    {key: 'band', title: 'Band'},
    {key: 'sector', title: 'Sector'},
    {key: 'created_at', title: 'Дата и время создания'},
    {key: 'model_phone', title: 'Модель телефона'},
    {key: 'version_os', title: 'Версия ОС'},
    {key: 'level_signal', title: 'Уровень принимаемого сигнала, дБм'},
    {key: 'distance', title: 'Расстояние до базовой стаанции, км'},
    {key: 'max_speed_download', title: 'Максимальная скорость передачи данных (download), Мб/с'},
    {key: 'medium_speed_download', title: 'Средняя скорость передачи данных (download), Мб/с'},
    {key: 'max_speed_upload', title: 'Максимальная скорость передачи данных (upload), Мб/с'},
    {key: 'min_speed_upload', title: 'Средняя скорость передачи данных (upload), Мб/с'},
    {key: 'max_ping', title: 'Максимальное время задержки передачи IP-пакетов (ping)'},
    {key: 'medium_ping', title: 'Среднее время задержки передачи IP-пакетов (ping)'},
    {key: 'loss_ping', title: 'Кол-во потяряных IP-пакетов (ping)'},
    {key: 'address_site_1', title: 'Адрес сайта №1'},
    {key: 'time_download_web_1', title: 'Время загрузки сайта №1'},
    {key: 'load_web_1', title: 'Размер сайта №1, кб'},
    {key: 'address_site_2', title: 'Адрес сайта №2'},
    {key: 'time_download_web_2', title: 'Время загрузки сайта №2'},
    {key: 'load_web_2', title: 'Размер сайта №2, кб'},
    {key: 'address_site_3', title: 'Адрес сайта №3'},
    {key: 'time_download_web_3', title: 'Время загрузки сайта №3'},
    {key: 'load_web_3', title: 'Размер сайта №3, кб'},
    {key: 'address_youtube', title: 'Адрес youtube'},
    {key: 'screen_resolution', title: 'Разрешение экрана (360p-8k)'},
    {key: 'data_used', title: 'Использовано данных, Кб'},
    {key: 'time_start', title: 'Время начала воспроизвдения, с'},
    {key: 'complaint', title: 'Отправка результата на улучшение качества сети'},
    {key: 'is_room', title: 'Тест проведен в помещении?'},
    {key: 'operators.name', title: 'Название сети'},
    {key: 'standards.name', title: 'Стандарт'},
    {key: 'connection_types.name', title: 'Технология'},
    {key: 'servers.name', title: 'Сервер'},
    {key: 'towers.cell_id', title: 'Cell ID'},
]);

const items = ref([]);
const itemsLength = ref(0);
const loading = ref(false);

const itemsPerPageOptions = ref([
    {value: 10, title: '10'},
    {value: 25, title: '25'},
    {value: 50, title: '50'},
    {value: 100, title: '100'},
]);

const params = ref({
    page: 1,
    limit: 10,
    sort: [
        {
            key: 'id',
            order: 'desc'
        }
    ],
    filters: {
        'tests.operator_id': null,
        'tests.standard_id': null,
        'tests.server_id': null,
        'tests.connection_type_id': null,
        'tests.is_room': false,
        'tests.complaint': false,
        'tests.mobile_phone': null,
        'tests.created_at': [null, null],
    }
});

function getItems() {

    router.get('/tests', params.value, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
        only: ['tests'],
        onBefore: () => {
            loading.value = true;
        },
        onSuccess: () => {
            items.value = props.tests.data;
            itemsLength.value = props.tests.meta.total;

            loading.value = false;
        }
    });
}

watch(params, debounce(() => getItems(), 300), {deep: true});
onMounted(() => getItems());

</script>

<template>
    <h1>Тесты</h1>

    <v-card>
        <v-card-item>
            <v-row class="mt-2">
                <v-col cols="12" md="3">
                    <v-select
                        label="Наименование сети"
                        :items="props.operators.data"
                        item-title="name"
                        item-value="id"
                        clearable
                        v-model="params.filters['tests.operator_id']"
                    />
                </v-col>
                <v-col cols="12" md="3">
                    <v-select
                        label="Стандарт"
                        :items="props.standards.data"
                        item-title="name"
                        item-value="id"
                        clearable
                        v-model="params.filters['tests.standard_id']"
                    />
                </v-col>
                <v-col cols="12" md="3">
                    <v-select
                        label="Наименование сервера"
                        :items="props.servers.data"
                        item-title="name"
                        item-value="id"
                        clearable
                        v-model="params.filters['tests.server_id']"
                    />
                </v-col>
                <v-col cols="12" md="3">
                    <v-select
                        label="Технология"
                        :items="props.connectionTypes.data"
                        item-title="name"
                        item-value="id"
                        clearable
                        v-model="params.filters['tests.connection_type_id']"
                    />
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" md="4">
                    <v-text-field
                        label="Модель мобильного телефона"
                        clearable
                        v-model="params.filters['tests.mobile_phone']"
                    />
                </v-col>
                <v-col cols="12" md="4">
                    <v-text-field
                        type="date"
                        label="Дата создания с"
                        :max="params.filters['tests.created_at'][1]"
                        clearable
                        v-model="params.filters['tests.created_at'][0]"
                    />
                </v-col>
                <v-col cols="12" md="4">
                    <v-text-field
                        type="date"
                        label="Дата создания по"
                        :min="params.filters['tests.created_at'][0]"
                        clearable
                        v-model="params.filters['tests.created_at'][1]"
                    />
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <v-checkbox
                        label="Тест проведен в помещении?"
                        v-model="params.filters['tests.is_room']"
                    />
                    <v-checkbox
                        label="Отправка результата на улучшение качества сети?"
                        v-model="params.filters['tests.complaint']"
                    />
                </v-col>
            </v-row>
        </v-card-item>
        <v-card-item>
            <v-data-table-server
                :headers="headers"
                :items="items"
                :items-length="itemsLength"
                :loading="loading"
                :items-per-page-options="itemsPerPageOptions"
                :sort-by="params.sort"
                no-data-text="Нет данных"
                loading-text="Загрузка данных с сервера..."
                page-text="c {0} по {1} из {2}"
                items-per-page-text="Записей на странице"
                @update:page="params.page = $event"
                @update:items-per-page="params.limit = $event"
                @update:sortBy="params.sort = $event"
            >
                <template v-slot:loader>
                    <v-progress-linear indeterminate color="success" :loading="loading"/>
                </template>

                <template v-slot:item.is_room="{ item }">
                    <v-chip :color="item.is_room ? 'success' : 'error'">
                        {{ item.is_room ? 'Да' : 'Нет' }}
                    </v-chip>
                </template>

                <template v-slot:item.complaint="{ item }">
                    <v-chip :color="item.complaint ? 'success' : 'error'">
                        {{ item.complaint ? 'Да' : 'Нет' }}
                    </v-chip>
                </template>

            </v-data-table-server>
        </v-card-item>
    </v-card>
</template>
