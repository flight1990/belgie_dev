<script setup>
import DefaultModal from '@/Components/DefaultModal.vue';
import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    server: Object,
});

const form = useForm({
    name: props.server?.name ?? null,
    active: props.server?.active ?? false,
});

function closeModal(close) {
    form.clearErrors();
    form.reset();
    close();
}

function save(close) {
    props.server
        ? form.patch(`/administration/servers/${props.server.id}`, {
            onSuccess: () => {
                close();
            },
        })
        : form.post('/administration/servers', {
            onSuccess: () => {
                closeModal(close);
            },
        });
}

</script>

<template>
    <default-modal>
        <template #open="{ open }">
            <v-btn fab icon variant="text" @click="open" v-if="server">
                <v-icon>mdi-square-edit-outline</v-icon>
            </v-btn>

            <v-btn color="success" @click="open" v-else>
                Создать запись
            </v-btn>
        </template>

        <template #title>
            {{ server ? 'Редактировать' : 'Создать' }} запись
        </template>

        <template #content>
            <v-text-field
                label="Название"
                v-model="form.name"
                :error-messages="form.errors.name"
            />

            <v-switch
                :label="form.active ? 'Активный' : 'Неактивный'"
                v-model="form.active"
                :error-messages="form.errors.active"
            />
        </template>

        <template #close="{ close }">
            <v-btn color="grey-darken-4" @click="closeModal(close)">
                Отмена
            </v-btn>
        </template>

        <template #actions="{ close }">
            <v-btn color="success" @click="save(close)" :loading="form.processing">
                {{ server ? 'Сохранить' : 'Создать' }}
            </v-btn>
        </template>
    </default-modal>
</template>
