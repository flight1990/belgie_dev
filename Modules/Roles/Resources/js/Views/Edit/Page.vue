<script setup>
import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    role: Object,
    permissions: Object,
    users: Object,
    rolePermissions: Array,
    roleUsers: Array
});

const form = useForm({
    name: props.role?.name ?? '',
    permissions: props.rolePermissions ?? [],
    users: props.roleUsers ?? []
});

function save() {
    props.role ? form.patch(`/roles/${props.role.id}`) : form.post('/roles');
}

</script>

<template>
    <h1>{{ role ? 'Редактирование' : 'Создание' }}</h1>

    <form class="my-5">
        <v-text-field
            label="Название роли"
            v-model="form.name"
            :error-messages="form.errors.name"
        />

        <div v-if="users.data?.length">
            <v-combobox
                label="Пользователи"
                :return-object="false"
                :items="users.data"
                item-value="id"
                item-title="name"
                multiple
                v-model="form.users"
            />
        </div>

        <v-row>
            <v-col cols="12" lg="3" v-for="(permissions, module) in permissions" :key="module">
                <h4>{{ module }}</h4>

                <v-checkbox
                    density="compact"
                    hide-details
                    v-for="(permission, index) in permissions"
                    :key="index"
                    :value="permission.id"
                    :label="permission.description"
                    v-model="form.permissions"
                />
            </v-col>
        </v-row>


    </form>

    <div class="d-flex align-center justify-center justify-md-end">
        <v-btn color="success" @click.prevent="save">Сохранить</v-btn>
    </div>

</template>
