<script setup>
import DefaultModal from '@/Components/DefaultModal.vue';
import {useForm} from "@inertiajs/vue3";

const form = useForm({
    file: null,
    truncate: false
});

function closeModal(close) {
    form.clearErrors();
    form.reset();
    close();
}

function importData(close) {
    form.post('/administration/towers/import', {
        onSuccess: () => {
            closeModal(close);
        },
    })
}

</script>

<template>
    <default-modal>
        <template #open="{ open }">
            <v-btn color="success" @click="open">
                Импорт данных из CSV
            </v-btn>
        </template>

        <template #title>
            Импорт данных из CSV
        </template>

        <template #content>
            <v-file-input
                @input="form.file = $event.target.files[0]"
                label="Файл"
                clearable
                color="success"
                density="compact"
                variant="underlined"
                prepend-icon="mdi-file"
                :error-messages="form.errors.file"
                accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
            />

            <v-switch
                label="Очистить данные перед импортом?"
                v-model="form.truncate"
            />
        </template>

        <template #close="{ close }">
            <v-btn color="grey-darken-4" @click="closeModal(close)">
                Отмена
            </v-btn>
        </template>

        <template #actions="{ close }">
            <v-btn color="success" @click="importData(close)" :loading="form.processing">
                Импортировать
            </v-btn>
        </template>
    </default-modal>
</template>
