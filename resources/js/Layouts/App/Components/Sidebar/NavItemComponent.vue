<script setup>
    const props = defineProps({
        item: Object
    });


</script>

<template>
    <inertia-link
        :key="item.id"
        :href="item.url"
        as="v-btn"
    >
        <v-list-item
            color="success"
            :prepend-icon="item.icon"
            :value="item.id"
            :active="item.isActive"
        >
            {{ item.name }}
        </v-list-item>
    </inertia-link>
</template>

