<script setup>
import DefaultModal from '@/Components/DefaultModal.vue';
import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    user: Object,
});

function closeModal(close) {
    form.clearErrors();
    form.reset();
    close();
}

const emits = defineEmits(['save', 'update']);

const form = useForm({
    name: props.user?.name,
    email: props.user?.email,
    login: props.user?.login,
    hash: props.user?.hash,
    password: null,
    password_confirmation: null,
});

function save(close) {
    props.user
        ? form.patch(`/administration/users/${props.user.id}`, {
            onSuccess: () => {
                emits('update');
                close();
            },
        })
        : form.post('/administration/users', {
            onSuccess: () => {
                emits('save');
                closeModal(close);
            },
        });
}

</script>

<template>
    <default-modal>
        <template #open="{ open }">
            <v-btn fab icon variant="text" @click="open" v-if="user">
                <v-icon>mdi-square-edit-outline</v-icon>
            </v-btn>

            <v-btn color="success" @click="open" v-else>
                Создать запись
            </v-btn>
        </template>

        <template #title>
            {{ user ? 'Редактировать' : 'Создать' }} запись
        </template>

        <template #content>

            <v-text-field
                label="Ф.И.О"
                v-model="form.name"
                :error-messages="form.errors.name"
            />

            <v-text-field
                label="Email"
                v-model="form.email"
                :error-messages="form.errors.email"
            />

            <v-text-field
                label="Login"
                v-model="form.login"
                :error-messages="form.errors.login"
            />

            <v-text-field
                label="Hash"
                v-model="form.hash"
                :error-messages="form.errors.hash"
            />

            <v-text-field
                label="Пароль"
                v-model="form.password"
                :error-messages="form.errors.password"
            />

            <v-text-field
                label="Подтверждение пароля"
                v-model="form.password_confirmation"
                :error-messages="form.errors.password_confirmation"
            />
        </template>

        <template #close="{ close }">
            <v-btn color="grey-darken-4" @click="closeModal(close)">
                Отмена
            </v-btn>
        </template>

        <template #actions="{ close }">
            <v-btn color="success" @click="save(close)" :loading="form.processing">
                {{ user ? 'Сохранить' : 'Создать' }}
            </v-btn>
        </template>
    </default-modal>
</template>
