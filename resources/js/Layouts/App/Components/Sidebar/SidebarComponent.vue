<script setup>
    import {usePage} from "@inertiajs/vue3";
    import {ref} from "vue";

    import NavItem from "./NavItemComponent.vue";
    import NavGroup from "./NavGroupComponent.vue";

    const page = usePage();
    const open = ref(page.props.menu.data.filter((item) => item.isActive).map((item) => item.nickname));
</script>

<template>
    <v-list open-strategy="single" dense v-model:opened="open">
        <template v-for="item in $page.props.menu.data">
            <NavGroup
                v-if="item.children.length && item.disableActivationByURL"
                :item="item"
            />
            <NavItem
                v-if="!item.children.length && !item.disableActivationByURL"
                :item="item"
            />
        </template>
    </v-list>
</template>
