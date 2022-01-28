<template>
    <b-alert
        class="mt-5"
        v-model="showAlertError"
        variant="danger"
        dismissible
    >
        {{ errorMessage }}
    </b-alert>
</template>

<script>
export default {
    name: "Redirect",
    data() {
        return {
            locale: this.$i18n.locale,
            errorMessage: '',
            showAlertError: false,
        };
    },
    methods: {
        getUrl: function() {
            this.clearError();
            const token = this.$route.params.token;

            this.$axios.retry.get(this.$routing.generate('links', this.locale) + '/' + token)
                .then((response) => {
                    window.location.replace(response.data.data.address);
                }).catch((err) => {
                    this.errorMessage = err.response.data.message;
                    this.showAlertError = true;
                }
            );
        },
        clearError: function() {
            this.errorMessage = '';
            this.showAlertError = false;
        },
    },
    beforeMount() {
        this.getUrl();
    },
}
</script>

<style scoped>
</style>
