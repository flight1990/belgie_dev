<script setup>
import ModifyModal from "./Components/ModifyModal.vue";
import DeleteConfirmationModal from "@/Components/DeleteConfirmationModal.vue";
import {usePage} from "@inertiajs/vue3";
import {ref} from "vue";

const headers = [
    {key: 'name', title: 'Название'},
    {key: 'actions', title: '', sortable: false, searchable: false},
];

const page = usePage();
const search = ref(null);

defineProps({connectionTypes: Object});

</script>

<template>
    <h1 class="d-flex align-center justify-space-between">
        <span>Технологии</span>

        <modify-modal
            v-if="page.props.authUser.permissions.includes('connection-types.create')"
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
            :items="connectionTypes.data"
            :search="search"
            :items-per-page="-1"
            hide-default-footer
            no-data-text="Нет данных"
        >
            <template v-slot:item.actions="{ item }">
                <modify-modal
                    v-if="page.props.authUser.permissions.includes('connection-types.edit')"
                    :connection-type="item"
                />

                <delete-confirmation-modal
                    v-if="page.props.authUser.permissions.includes('connection-types.destroy')"
                    :url="`/administration/connection-types/${item.id}`"
                />
            </template>

            <template v-slot:bottom></template>
        </v-data-table>
    </v-card>

</template>
