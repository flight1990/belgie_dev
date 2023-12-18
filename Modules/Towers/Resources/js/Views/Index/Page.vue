<script setup>
import {onMounted, ref, watch} from "vue";
import {router, usePage} from "@inertiajs/vue3";
import ModifyModal from "./Components/ModifyModal.vue";
import ImportModal from "./Components/ImportModal.vue";
import DeleteConfirmationModal from "@/Components/DeleteConfirmationModal.vue";
import {debounce} from "lodash";

const props = defineProps({
    towers: Object,
    operators: Object,
    standards: Object
});

const page = usePage();

const headers = ref([
    {key: 'id', title: 'ID'},
    {key: 'standards.name', title: 'Стандарт'},
    {key: 'bsn', title: 'BSN'},
    {key: 'lac', title: 'LAC'},
    {key: 'cell_id', title: 'Cell ID'},
    {key: 'operators.name', title: 'Оператор'},
    {key: 'mnc', title: 'MNC'},
    {key: 'x', title: 'Долгота'},
    {key: 'y', title: 'Широта'},
    {key: 'band', title: 'Band'},
    {key: 'sector', title: 'Sector'},
    {key: 'created_at', title: 'Дата добавления'},
    {key: 'tests_count', title: 'Кол-во тестов'},
    {key: 'actions', title: '', sortable: false},
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
        operator_id: null,
        standard_id: null,
        'towers.bsn': null,
        'towers.lac': null,
        'towers.cell_id': null,
        'towers.mnc': null,
        'towers.band': null,
        'towers.sector': null,
    }
});

function getItems() {

    router.get('/administration/towers', params.value, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
        only: ['towers', 'errors'],
        onStart: () => {
            loading.value = true;
        },
        onSuccess: () => {
            items.value = props.towers.data;
            itemsLength.value = props.towers.meta.total;

            loading.value = false;
        }
    });
}

watch(params, debounce(() => getItems(), 300),{deep: true});
onMounted(() => getItems());

</script>

<template>
    <h1 class="d-flex align-center justify-space-between">
        <span>Вышки</span>
        <div>
            <import-modal
                v-if="page.props.authUser.permissions.includes('towers.create')"
            />

            <modify-modal
                :operators="operators"
                :standards="standards"
                v-if="page.props.authUser.permissions.includes('towers.create')"
                @save="getItems"
            />
        </div>
    </h1>

    <v-card>
        <v-card-item>
            <v-row class="mt-2">
                <v-col cols="12" md="6">
                    <v-select
                        label="Наименование сети"
                        :items="props.operators.data"
                        item-title="name"
                        item-value="id"
                        clearable
                        v-model="params.filters.operator_id"
                    />
                </v-col>
                <v-col cols="12" md="6">
                    <v-select
                        label="Стандарт"
                        :items="props.standards.data"
                        item-title="name"
                        item-value="id"
                        clearable
                        v-model="params.filters.standard_id"
                    />
                </v-col>
            </v-row>

            <v-row>
                <v-col cols="12" md="2">
                    <v-text-field
                        label="BSN"
                        clearable
                        v-model="params.filters['towers.bsn']"
                    />
                </v-col>
                <v-col cols="12" md="2">
                    <v-text-field
                        label="LAC"
                        clearable
                        v-model="params.filters['towers.lac']"
                    />
                </v-col>
                <v-col cols="12" md="2">
                    <v-text-field
                        label="Cell ID"
                        clearable
                        v-model="params.filters['towers.cell_id']"
                    />
                </v-col>
                <v-col cols="12" md="2">
                    <v-text-field
                        label="MNC"
                        clearable
                        v-model="params.filters['towers.mnc']"
                    />
                </v-col>
                <v-col cols="12" md="2">
                    <v-text-field
                        label="Band"
                        clearable
                        v-model="params.filters['towers.band']"
                    />
                </v-col>
                <v-col cols="12" md="2">
                    <v-text-field
                        label="Sector"
                        clearable
                        v-model="params.filters['towers.sector']"
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

                <template v-slot:item.actions="{ item }">
                    <div class="d-flex align-center justify-space-between">
                        <modify-modal
                            :operators="operators"
                            :standards="standards"
                            :tower="item"
                            v-if="page.props.authUser.permissions.includes('towers.edit')"
                            @update="getItems"
                        />

                        <delete-confirmation-modal
                            v-if="page.props.authUser.permissions.includes('towers.destroy')"
                            :url="`/administration/towers/${item.id}`"
                        />
                    </div>
                </template>

            </v-data-table-server>
        </v-card-item>
    </v-card>
</template>
