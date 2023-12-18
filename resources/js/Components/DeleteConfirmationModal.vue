<script setup>
import DefaultModal from "@/Components/DefaultModal.vue";

const props = defineProps({
    url: {
        type: String,
        required: true,
    },
});

</script>

<template>
    <default-modal>

        <template #open="{ open }">
            <v-btn color="error" fab icon variant="text" @click="open">
                <v-icon @click="open">mdi-trash-can-outline</v-icon>
            </v-btn>
        </template>

        <template #title>
            Внимание!
        </template>

        <template #content>
            Вы уверены, что хотите удалить запись из базы данных?
        </template>

        <template #actions="{ close }">
            <inertia-link :href="url" method="DELETE" as="button" :preserve-state="false">
                <v-btn color="error">
                    Удалить
                </v-btn>
            </inertia-link>
        </template>

    </default-modal>
</template>
