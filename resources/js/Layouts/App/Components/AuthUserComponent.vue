<script setup>
    import {router} from "@inertiajs/vue3";

    function logout() {
        router.post('/logout');
    }
</script>

<template>
    <v-list>
        <v-list-item
            :title="$page.props.authUser?.name"
            :subtitle="$page.props.authUser?.email"
        >
            <template v-slot:append>
                <div>
                    <v-btn
                        variant="text"
                        color="grey"
                        fab
                        icon
                        @click.prevent="logout"
                    >
                        <v-icon>mdi-logout</v-icon>

                        <v-tooltip
                            activator="parent"
                            location="bottom"
                            text="Выход из программы"
                        />
                    </v-btn>
                </div>
            </template>
        </v-list-item>
    </v-list>
</template>
