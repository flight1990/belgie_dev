<script setup>
import {usePage} from "@inertiajs/vue3";
import {ref} from "vue";
import DeleteConfirmationModal from "@/Components/DeleteConfirmationModal.vue";

const headers = [
    {key: 'name', title: 'Ф.И.О'},
    {key: 'email', title: 'Email'},
    {key: 'login', title: 'Login'},
    {key: 'created_at', title: 'Дата создания'},
    {key: 'updated_at', title: 'Дата обновления'},
    {key: 'actions', title: '', sortable: false},
];

const search = ref(null);
const page = usePage();

defineProps({
    admins: Object
});


</script>

<template>
    <h1 class="d-flex align-center justify-space-between">
        <span>Администраторы</span>

        <inertia-link
            href="/admin-users/create"
            v-if="page.props.authUser.permissions.includes('admin-users.create')"
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
            :items="admins.data"
            :search="search"
            :items-per-page="-1"
            hide-default-footer
            no-data-text="Нет данных"
        >
            <template v-slot:item.actions="{ item }">

                <inertia-link
                    :href="`/admin-users/${item.id}/edit`"
                    v-if="page.props.authUser.permissions.includes('admin-users.edit')"
                >
                    <v-btn variant="text" fab icon>
                        <v-icon>mdi-square-edit-outline</v-icon>
                    </v-btn>
                </inertia-link>

                <delete-confirmation-modal
                    v-if="page.props.authUser.permissions.includes('admin-users.destroy')"
                    :url="`/admin-users/${item.id}`"
                />
            </template>

            <template v-slot:bottom></template>
        </v-data-table>
    </v-card>

</template>

