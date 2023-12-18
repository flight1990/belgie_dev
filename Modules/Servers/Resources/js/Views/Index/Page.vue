<script setup>
import ModifyModal from "./Components/ModifyModal.vue";
import DeleteConfirmationModal from "@/Components/DeleteConfirmationModal.vue";
import {usePage} from "@inertiajs/vue3";
import {ref} from "vue";

const headers = [
    {key: 'name', title: 'Название'},
    {key: 'active', title: 'Состояние', sortable: false, searchable: false},
    {key: 'actions', title: '', sortable: false, searchable: false},
];

defineProps({servers: Object});

const page = usePage();
const search = ref(null);

</script>

<template>
    <h1 class="d-flex align-center justify-space-between">
        <span>Серверы</span>

        <modify-modal
            v-if="page.props.authUser.permissions.includes('servers.create')"
        />
    </h1>

    <v-card>
        <v-card-title>
            <v-text-field
                class="mb-5"
                v-model="search"
                append-icon="mdi-magnify"
                label="Поиск"
                single-line
                hide-details
            ></v-text-field>
        </v-card-title>

        <v-data-table
            :headers="headers"
            :items="servers.data"
            :search="search"
            :items-per-page="-1"
            hide-default-footer
            no-data-text="Нет данных"
        >
            <template v-slot:item.active="{ item }">
                <v-chip
                    :color="item.active ? 'success' : 'error'"
                >
                    {{ item.active ? 'Активный' : 'Не активный' }}
                </v-chip>
            </template>

            <template v-slot:item.actions="{ item }">
                <modify-modal
                    v-if="page.props.authUser.permissions.includes('servers.edit')"
                    :server="item"
                />

                <delete-confirmation-modal
                    v-if="page.props.authUser.permissions.includes('servers.destroy')"
                    :url="`/administration/servers/${item.id}`"
                />
            </template>

            <template v-slot:bottom></template>
        </v-data-table>
    </v-card>

</template>

