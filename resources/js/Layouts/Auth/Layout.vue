<template>
    <div class="d-flex align-center justify-center h-screen bg-grey-lighten-4">
        <v-sheet width="400" class="mx-auto" color="grey-lighten-4">
            <slot></slot>
        </v-sheet>
    </div>
</template>

<script>
export default {
    name: "AuthLayout"
}
</script>
