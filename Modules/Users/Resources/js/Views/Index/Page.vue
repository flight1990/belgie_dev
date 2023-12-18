<script setup>
import {router, usePage} from "@inertiajs/vue3";
import {onMounted, ref, watch} from "vue";
import DeleteConfirmationModal from "@/Components/DeleteConfirmationModal.vue";
import ModifyModal from "./Components/ModifyModal.vue";
import {debounce} from "lodash";

const props = defineProps({
    users: Object
});

const headers = [
    {key: 'id', title: 'ID'},
    {key: 'name', title: 'Ф.И.О'},
    {key: 'email', title: 'Email'},
    {key: 'login', title: 'Login'},
    {key: 'hash', title: 'Hash'},
    {key: 'created_at', title: 'Дата создания'},
    {key: 'updated_at', title: 'Дата обновления'},
    {key: 'actions', title: '', sortable: false, searchable: false},
];

const page = usePage();

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
        name: null,
        email: null,
        login: null,
        hash: null
    }
});

function getItems() {

    router.get('/administration/users', params.value, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
        only: ['users', 'errors'],
        onStart: () => {
            loading.value = true;
        },
        onSuccess: () => {
            items.value = props.users.data;
            itemsLength.value = props.users.meta.total;

            loading.value = false;
        }
    });
}

watch(params, debounce(() => getItems(), 300),{deep: true});
onMounted(() => getItems());

</script>

<template>
    <h1 class="d-flex align-center justify-space-between">
        <span>Пользователи</span>

        <modify-modal
            v-if="page.props.authUser.permissions.includes('users.create')"
            @save="getItems"
        />
    </h1>

    <v-card>
        <v-card-item>
            <v-row>
                <v-col cols="12" md="3">
                    <v-text-field
                        label="Ф.И.О"
                        clearable
                        v-model="params.filters['name']"
                    />
                </v-col>
                <v-col cols="12" md="3">
                    <v-text-field
                        label="Email"
                        clearable
                        v-model="params.filters['email']"
                    />
                </v-col>
                <v-col cols="12" md="3">
                    <v-text-field
                        label="Login"
                        clearable
                        v-model="params.filters['login']"
                    />
                </v-col>
                <v-col cols="12" md="3">
                    <v-text-field
                        label="Hash"
                        clearable
                        v-model="params.filters['hash']"
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
                            :user="item"
                            v-if="page.props.authUser.permissions.includes('users.edit')"
                            @update="getItems"
                        />

                        <delete-confirmation-modal
                            v-if="page.props.authUser.permissions.includes('users.destroy') && item.tests_count === 0"
                            :url="`/administration/users/${item.id}`"
                        />
                    </div>
                </template>

            </v-data-table-server>
        </v-card-item>
    </v-card>

</template>

