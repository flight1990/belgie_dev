<script setup>
import {ref} from "vue";

const dialog = ref(false);
const emits = defineEmits(['close', 'open']);

const props = defineProps({
    modalWidth: {
        type: String,
        default: '500',
    }
});

function open() {
    emits('open');
    dialog.value = true;
}

function close() {
    emits('close');
    dialog.value = false;
}

</script>

<template>
    <slot name="open" :open="open">
        <v-btn
            color="primary"
            @click="open"
        >
            Open Dialog
        </v-btn>
    </slot>

    <v-dialog
        v-model="dialog"
        :width="modalWidth"
    >
        <v-card class="pa-4">
            <v-card-title>
                <slot name="title">
                    Default modal title
                </slot>
            </v-card-title>
            <v-card-text>
                <slot name="content">
                    Default modal content
                </slot>
            </v-card-text>
            <v-card-actions>

                <v-spacer></v-spacer>

                <slot name="close" :close="close">
                    <v-btn color="grey-darken-4"  @click="close">
                        Отмена
                    </v-btn>
                </slot>

                <slot name="actions" :close="close">

                </slot>

            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
