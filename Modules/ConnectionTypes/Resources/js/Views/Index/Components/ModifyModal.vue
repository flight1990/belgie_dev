<script setup>
import DefaultModal from '@/Components/DefaultModal.vue';
import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    connectionType: Object,
});

const form = useForm({
    name: props.connectionType?.name ?? null,
});

function closeModal(close) {
    form.clearErrors();
    form.reset();
    close();
}

function save(close) {
    props.connectionType
        ? form.patch(`/administration/connection-types/${props.connectionType.id}`, {
            onSuccess: () => {
                close();
            },
        })
        : form.post('/administration/connection-types', {
            onSuccess: () => {
                closeModal(close);
            },
        });
}

</script>

<template>
    <default-modal>
        <template #open="{ open }">
            <v-btn fab icon variant="text" @click="open" v-if="connectionType">
                <v-icon>mdi-square-edit-outline</v-icon>
            </v-btn>

            <v-btn color="success" @click="open" v-else>
                Создать запись
            </v-btn>
        </template>

        <template #title>
            {{ connectionType ? 'Редактировать' : 'Создать' }} запись
        </template>

        <template #content>
            <v-text-field
                label="Название"
                v-model="form.name"
                :error-messages="form.errors.name"
            />
        </template>

        <template #close="{ close }">
            <v-btn color="grey-darken-4" @click="closeModal(close)">
                Отмена
            </v-btn>
        </template>

        <template #actions="{ close }">
            <v-btn color="success" @click="save(close)" :loading="form.processing">
                {{  connectionType ? 'Сохранить' : 'Создать' }}
            </v-btn>
        </template>
    </default-modal>
</template>
