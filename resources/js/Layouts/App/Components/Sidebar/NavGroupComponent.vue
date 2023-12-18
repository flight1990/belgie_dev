<script setup>
    import NavItem from "./NavItemComponent.vue";

    const props = defineProps({
        item: Object
    });
</script>

<template>
    <v-list-group
        no-action
        :active="item.isActive"
        :value="item.nickname"
        color="success"
    >
        <template v-slot:activator="{ props }">
            <v-list-item
                color="success"
                :prepend-icon="item.icon"
                v-bind="props"
                :title="item.name"
                :active="item.isActive"
            ></v-list-item>
        </template>

        <NavItem
            v-for="item in item.children"
            :key="item.id"
            :item="item"
        />
    </v-list-group>
</template>

