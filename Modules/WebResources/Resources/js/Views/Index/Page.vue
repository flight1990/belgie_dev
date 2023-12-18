<script setup>
import ModifyModal from "./Components/ModifyModal.vue";
import DeleteConfirmationModal from "@/Components/DeleteConfirmationModal.vue";
import {usePage} from "@inertiajs/vue3";
import {ref} from "vue";

const headers = [
    {key: 'address_site_1', title: 'Cсылка на сайт 1'},
    {key: 'address_site_2', title: 'Cсылка на сайт 2'},
    {key: 'address_site_3', title: 'Cсылка на сайт 3'},
    {key: 'address_video', title: 'Cсылка на видео'},
    {key: 'active', title: 'Состояние', sortable: false, searchable: false},
    {key: 'actions', title: '', sortable: false, searchable: false},
];

defineProps({webResources: Object});

const page = usePage();
const search = ref(null);

</script>

<template>
    <h1 class="d-flex align-center justify-space-between">
        <span>Web ресурсы</span>

        <modify-modal
            v-if="page.props.authUser.permissions.includes('web-resources.create')"
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
            :items="webResources.data"
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
                    v-if="page.props.authUser.permissions.includes('web-resources.edit')"
                    :web-resource="item"
                />

                <delete-confirmation-modal
                    v-if="page.props.authUser.permissions.includes('web-resources.destroy')"
                    :url="`/administration/web-resources/${item.id}`"
                />
            </template>

            <template v-slot:bottom></template>
        </v-data-table>
    </v-card>
</template>

