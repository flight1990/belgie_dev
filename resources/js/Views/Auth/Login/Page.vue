<template>
    <h1>{{ $page.props.appName }} ++ </h1>

    <v-form fast-fail @submit.prevent="login">
        <v-text-field
            color="success"
            label="Login"
            variant="underlined"
            v-model="form.login"
            :error-messages="form.errors.login"
        />
        <v-text-field
            type="password"
            color="success"
            label="Пароль"
            variant="underlined"
            v-model="form.password"
            :error-messages="form.errors.password"
        />

        <v-checkbox
            label="Запомни меня"
            color="success"
            hide-details
            v-model="form.remember"
        />

        <v-btn
            type="submit"
            color="success"
            block
            class="mt-10"
            elevation="0"
            :loading="form.processing"
            :disabled="form.processing"
        >
            Авторизоваться
        </v-btn>
    </v-form>
</template>

<script>
import {useForm} from "@inertiajs/vue3";
import AuthLayout from "@/Layouts/Auth/Layout.vue";

export default {
    name: "Page",
    layout: AuthLayout,
    data() {
        return {
            form: useForm({
                login: "",
                password: "",
                remember: false,
            })
        }
    },
    methods: {
        login() {
            this.form.post("/login");
        }
    }
}
</script>
