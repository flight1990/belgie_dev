<script setup>
import DefaultModal from '@/Components/DefaultModal.vue';
import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    tower: Object,
    standards: {
        type: Object,
        required: true
    },
    operators: {
        type: Object,
        required: true
    },
});

function closeModal(close) {
    form.clearErrors();
    form.reset();
    close();
}

const emits = defineEmits(['save', 'update']);

const form = useForm({
    operator_id: props.tower?.operator_id ?? null,
    standard_id: props.tower?.standard_id ?? null,
    bsn: props.tower?.bsn ?? null,
    lac: props.tower?.lac ?? null,
    cell_id: props.tower?.cell_id ?? null,
    mnc: props.tower?.mnc ?? null,
    x: props.tower?.x ?? null,
    y: props.tower?.y ?? null,
    band: props.tower?.band ?? null,
    sector: props.tower?.sector ?? null,
});

function save(close) {
    props.tower
        ? form.patch(`/administration/towers/${props.tower.id}`, {
            onSuccess: () => {
                emits('update');
                close();
            },
        })
        : form.post('/administration/towers', {
            onSuccess: () => {
                emits('save');
                closeModal(close);
            },
        });
}

</script>

<template>
    <default-modal>
        <template #open="{ open }">
            <v-btn fab icon variant="text" @click="open" v-if="tower">
                <v-icon>mdi-square-edit-outline</v-icon>
            </v-btn>

            <v-btn color="success" @click="open" v-else>
                Создать запись
            </v-btn>
        </template>

        <template #title>
            {{ tower ? 'Редактировать' : 'Создать' }} запись
        </template>

        <template #content>
            <v-select
                label="Стандарт"
                :items="standards.data"
                item-title="name"
                item-value="id"
                v-model="form.standard_id"
                :error-messages="form.errors.standard_id"
            />

            <v-select
                label="Оператор"
                :items="operators.data"
                item-title="name"
                item-value="id"
                v-model="form.operator_id"
                :error-messages="form.errors.operator_id"
            />

            <v-row>
                <v-col cols="12" md="6">
                    <v-text-field
                        type="number"
                        label="BSN"
                        v-model="form.bsn"
                        :error-messages="form.errors.bsn"
                    />
                </v-col>
                <v-col cols="12" md="6">
                    <v-text-field
                        type="number"
                        label="Lac"
                        v-model="form.lac"
                        :error-messages="form.errors.lac"
                    />
                </v-col>
            </v-row>

            <v-row>
                <v-col cols="12" md="6">
                    <v-text-field
                        type="number"
                        label="Cell ID"
                        v-model="form.cell_id"
                        :error-messages="form.errors.cell_id"
                    />
                </v-col>
                <v-col cols="12" md="6">
                    <v-text-field
                        type="number"
                        label="MNC"
                        v-model="form.mnc"
                        :error-messages="form.errors.mnc"
                    />
                </v-col>
            </v-row>

            <v-row>
                <v-col cols="12" md="6">
                    <v-text-field
                        label="Долгота"
                        v-model="form.x"
                        :error-messages="form.errors.x"
                    />
                </v-col>
                <v-col cols="12" md="6">
                    <v-text-field
                        label="Широта"
                        v-model="form.y"
                        :error-messages="form.errors.y"
                    />
                </v-col>
            </v-row>

            <v-row>
                <v-col cols="12" md="6">
                    <v-text-field
                        type="number"
                        label="Band"
                        v-model="form.band"
                        :error-messages="form.errors.band"
                    />
                </v-col>
                <v-col cols="12" md="6">
                    <v-text-field
                        type="number"
                        label="Sector"
                        v-model="form.sector"
                        :error-messages="form.errors.sector"
                    />
                </v-col>
            </v-row>
        </template>

        <template #close="{ close }">
            <v-btn color="grey-darken-4" @click="closeModal(close)">
                Отмена
            </v-btn>
        </template>

        <template #actions="{ close }">
            <v-btn color="success" @click="save(close)" :loading="form.processing">
                {{ tower ? 'Сохранить' : 'Создать' }}
            </v-btn>
        </template>
    </default-modal>
</template>
