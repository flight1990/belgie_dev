<template>
    <h1>Профиль пользователя</h1>

    <form class="my-5">
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

        <div class="d-md-flex align-center justify-end">
            <v-btn color="success" @click.prevent="save">Сохранить</v-btn>
        </div>
    </form>

</template>

<script>

import {useForm} from "@inertiajs/vue3";

export default {
    name: "Page",
    props: {
        user: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            form: useForm({
                name: this.user?.name ?? '',
                email: this.user?.email ?? '',
                password: '',
                password_confirmation: '',
            })
        }
    },
    methods: {
        save() {
            this.form.patch('/profile');
        }
    }
}
</script>
