<template>
    <div class="text-center">

        <v-snackbar
            v-if="$page.props.flash.message"
            v-model="snackbar"
            multi-line
            :color="$page.props.flash.message.type"
            location="bottom right"
            :timeout="2000"
            variant="flat"
            class="mb-10 mr-10"
            timer="info"
        >
            <p>{{ $page.props.flash.message.message }}</p>

            <template v-slot:actions>
                <v-btn icon fab size="small"
                       @click="snackbar = false"
                >
                    <v-icon color="white">mdi-close</v-icon>
                </v-btn>
            </template>
        </v-snackbar>
    </div>
</template>

<script>
export default {
    name: "FlashMessagesComponent",
    data() {
        return {
            snackbar: false,
        }
    },
    watch: {
        toast() {
            this.snackbar = !!this.toast
        }
    },
    computed: {
        toast() {
            return this.$page.props.flash.message
        },
    }
}
</script>
