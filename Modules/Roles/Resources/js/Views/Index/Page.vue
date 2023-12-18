<script setup>
import {usePage} from "@inertiajs/vue3";
import {ref} from "vue";
import DeleteConfirmationModal from "@/Components/DeleteConfirmationModal.vue";

const headers = [
    {key: 'name', title: 'Название'},
    {key: 'actions', title: '', sortable: false, searchable: false},
];

const search = ref(null);
const page = usePage();

defineProps({roles: Object});

</script>

<template>
    <h1 class="d-flex align-center justify-space-between">
        <span>Роли</span>

        <inertia-link
            href="/roles/create"
            v-if="page.props.authUser.permissions.includes('roles.create')"
        >
            <v-btn color="success">Создать</v-btn>
        </inertia-link>
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
            :items="roles.data"
            :search="search"
            :items-per-page="-1"
            hide-default-footer
            no-data-text="Нет данных"
        >
            <template v-slot:item.actions="{ item }">

                <inertia-link
                    :href="`/roles/${item.id}/edit`"
                    v-if="page.props.authUser.permissions.includes('roles.edit')"
                >
                    <v-btn variant="text" fab icon>
                        <v-icon>mdi-square-edit-outline</v-icon>
                    </v-btn>
                </inertia-link>

                <delete-confirmation-modal
                    v-if="page.props.authUser.permissions.includes('roles.destroy')"
                    :url="`/roles/${item.id}`"
                />
            </template>

            <template v-slot:bottom></template>
        </v-data-table>
    </v-card>
</template>
