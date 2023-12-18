<script setup>
import ModifyModal from "./Components/ModifyModal.vue";
import DeleteConfirmationModal from "@/Components/DeleteConfirmationModal.vue";

import {usePage} from "@inertiajs/vue3";
import {ref} from "vue";

const headers = [
    {key: 'name', title: 'Название'},
    {key: 'actions', title: '', sortable: false, searchable: false},
];

defineProps({standards: Object});

const page = usePage();
const search = ref(null);

</script>

<template>
    <h1 class="d-flex align-center justify-space-between">
        <span>Стандарты</span>

        <modify-modal
            v-if="page.props.authUser.permissions.includes('standards.create')"
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
            :items="standards.data"
            :search="search"
            :items-per-page="-1"
            hide-default-footer
            no-data-text="Нет данных"
        >
            <template v-slot:item.actions="{ item }">
                <modify-modal
                    v-if="page.props.authUser.permissions.includes('standards.edit')"
                    :standard="item"
                />

                <delete-confirmation-modal
                    v-if="page.props.authUser.permissions.includes('standards.destroy')"
                    :url="`/administration/standards/${item.id}`"
                />
            </template>

            <template v-slot:bottom></template>
        </v-data-table>
    </v-card>

</template>
