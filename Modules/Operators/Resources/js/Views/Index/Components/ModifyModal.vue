<script setup>
import DefaultModal from '@/Components/DefaultModal.vue';
import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    operator: Object,
});

const form = useForm({
    name: props.operator?.name ?? null,
    provider: props.operator?.provider ?? null,
    mnc: props.operator?.mnc ?? null,
});

function closeModal(close) {
    form.clearErrors();
    form.reset();
    close();
}

function save(close) {
    props.operator
        ? form.patch(`/administration/operators/${props.operator.id}`, {
            onSuccess: () => {
                close();
            },
        })
        : form.post('/administration/operators', {
            onSuccess: () => {
                closeModal(close);
            },
        });
}

</script>

<template>
    <default-modal>
        <template #open="{ open }">
            <v-btn fab icon variant="text" @click="open" v-if="operator">
                <v-icon>mdi-square-edit-outline</v-icon>
            </v-btn>

            <v-btn color="success" @click="open" v-else>
                Создать запись
            </v-btn>
        </template>

        <template #title>
            {{ operator ? 'Редактировать' : 'Создать' }} запись
        </template>

        <template #content>
            <v-text-field
                label="Название"
                v-model="form.name"
                :error-messages="form.errors.name"
            />

            <v-text-field
                label="Провайдер"
                v-model="form.provider"
                :error-messages="form.errors.provider"
            />

            <v-text-field
                type="number"
                label="MNC"
                v-model="form.mnc"
                :error-messages="form.errors.mnc"
            />
        </template>

        <template #close="{ close }">
            <v-btn color="grey-darken-4" @click="closeModal(close)">
                Отмена
            </v-btn>
        </template>

        <template #actions="{ close }">
            <v-btn color="success" @click="save(close)" :loading="form.processing">
                {{ operator ? 'Сохранить' : 'Создать' }}
            </v-btn>
        </template>
    </default-modal>
</template>
