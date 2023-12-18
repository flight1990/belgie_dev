<script setup>
    import {usePage} from "@inertiajs/vue3";

    const page = usePage();
</script>

<template>
    <v-app-bar class="px-7 bg-grey-lighten-4" elevation="0" v-if="page.props.crumbs.data.filter((item) => item.url !== $page.props.navigation.currentUrl).length > 0">
        <template
            v-for="crumb in $page.props.crumbs.data"
            :key="crumb.id"
        >
            <template v-if="!crumb.url">

            <span class="text-grey-darken-1">
                <small>{{ crumb.name }}</small>
                <v-icon size="small">mdi-chevron-right</v-icon>
            </span>

            </template>
            <template v-else>
                <inertia-link
                    :href="crumb.url"
                    v-if="crumb.url !== $page.props.navigation.currentUrl"
                    class="text-grey-darken-1 text-decoration-none"
                >
                    <small>{{ crumb.name }}</small>
                    <v-icon size="small">mdi-chevron-right</v-icon>
                </inertia-link>
            </template>
        </template>
    </v-app-bar>
</template>
