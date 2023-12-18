<script setup>
import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    admin: Object,
    roles: Object,
    adminRoles: Array,
});

const form = useForm({
    name: props.admin?.name ?? '',
    email: props.admin?.email ?? '',
    login: props.admin?.login ?? '',
    password: '',
    password_confirmation: '',
    roles: props.adminRoles ?? [],
});

function save() {
    props.admin ? form.patch(`/admin-users/${props.admin.id}`) : form.post('/admin-users');
}

</script>

<template>
    <h1>{{ admin ? 'Редактирование' : 'Создание' }}</h1>

    <form class="my-5">
        <v-text-field
            label="Ф.И.О"
            v-model="form.name"
            :error-messages="form.errors.name"
        />

        <v-text-field
            label="Login"
            v-model="form.login"
            :error-messages="form.errors.login"
        />

        <v-text-field
            label="Email"
            v-model="form.email"
            :error-messages="form.errors.email"
        />

        <v-text-field
            type="password"
            label="Пароль"
            v-model="form.password"
            :error-messages="form.errors.password"
        />

        <v-text-field
            type="password"
            label="Подтверждение пароля"
            v-model="form.password_confirmation"
            :error-messages="form.errors.password_confirmation"
        />

        <div v-if="roles.data?.length">
            <v-combobox
                label="Роли"
                :return-object="false"
                :items="roles.data"
                item-value="id"
                item-title="name"
                multiple
                v-model="form.roles"
            />
        </div>
    </form>

    <div class="d-flex align-center justify-center justify-md-end">
        <v-btn color="success" @click.prevent="save">Сохранить</v-btn>
    </div>
</template>

