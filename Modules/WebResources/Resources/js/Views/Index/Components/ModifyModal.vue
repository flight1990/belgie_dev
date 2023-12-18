<script setup>
import DefaultModal from '@/Components/DefaultModal.vue';
import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    webResource: Object,
});

const form = useForm({
    address_site_1: props.webResource?.address_site_1 ?? null,
    address_site_2: props.webResource?.address_site_2 ?? null,
    address_site_3: props.webResource?.address_site_3 ?? null,
    address_video: props.webResource?.address_video ?? null,
    active: props.webResource?.active ?? false
});

function closeModal(close) {
    form.clearErrors();
    form.reset();
    close();
}

function save(close) {
    props.webResource
        ? form.patch(`/administration/web-resources/${props.webResource.id}`, {
            onSuccess: () => {
                close();
            },
        })
        : form.post('/administration/web-resources', {
            onSuccess: () => {
                closeModal(close);
            },
        });
}
</script>

<template>
    <default-modal>
        <template #open="{ open }">
            <v-btn fab icon variant="text" @click="open" v-if="webResource">
                <v-icon>mdi-square-edit-outline</v-icon>
            </v-btn>

            <v-btn color="success" @click="open" v-else>
                Создать запись
            </v-btn>
        </template>

        <template #title>
            {{ webResource ? 'Редактировать' : 'Создать' }} запись
        </template>

        <template #content>
            <v-text-field
                label="Cсылка на сайт 1"
                v-model="form.address_site_1"
                :error-messages="form.errors.address_site_1"
            />

            <v-text-field
                label="Cсылка на сайт 2"
                v-model="form.address_site_2"
                :error-messages="form.errors.address_site_2"
            />

            <v-text-field
                label="Cсылка на сайт 3"
                v-model="form.address_site_3"
                :error-messages="form.errors.address_site_3"
            />

            <v-text-field
                label="Cсылка на видео"
                v-model="form.address_video"
                :error-messages="form.errors.address_video"
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
                {{ webResource ? 'Сохранить' : 'Создать' }}
            </v-btn>
        </template>
    </default-modal>
</template>
