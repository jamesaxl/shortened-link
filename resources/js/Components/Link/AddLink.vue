<template>
    <div class="mt-5">
        <b-card
            class="mt-3"
            header-bg-variant="primary"
            header-text-variant="white"
        >
            <b-alert v-model="showAlertSuccess" variant="success" dismissible>
                {{ this.successMessage }}
            </b-alert>
            <b-alert v-model="showAlertError" variant="danger" dismissible>
                <ul>
                    <li
                        v-for="error in errors"
                    >
                        {{ $t(error) }}
                    </li>
                </ul>
            </b-alert>
            <b-form @submit="onSubmit" @reset="onReset">
                <b-form-group
                    id="input-group-address"
                    :label="$t('form.address')"
                    label-for="input-address"
                >
                    <b-form-input
                        id="input-address"
                        v-model="form.address"
                        type="text"
                        :placeholder="$t('form.enterAddress')"
                    ></b-form-input>
                </b-form-group>
                <b-button class="mr-2" type="submit" variant="primary">
                    {{ $t('form.submit') }}
                </b-button>
                <b-button type="reset" variant="danger">
                    {{ $t('form.reset') }}
                </b-button>
            </b-form>
        </b-card>
    </div>
</template>

<script>

import {CheckInputMixin} from '../../mixins';
import {mapGetters} from "vuex";
import {HTTP} from "../../utils/constants";

export default {
    name: 'AddLink',
    mixins: [
        CheckInputMixin,
    ],
    data() {
        return {
            successMessage: '',
            showAlertSuccess: false,
            showAlertError: false,
            errors: [],
            form: {
                address: '',
            }
        };
    },
    computed: {
        ...mapGetters({
            getData: 'auth/getData',
        }),
        showErrors() {
            return this.errors.length > 0;
        },
    },
    methods: {
        onCheck: function() {
            this.clearAlert();

            if (!this.checkRequired(this.form.address)) {
                this.errors.push('address.required');
            }

            if (!this.checkUrl(this.form.address)) {
                this.errors.push('address.url');
            }
        },
        onSubmit: function(event) {
            event.preventDefault();
            this.onCheck();
            this.showAlertError = this.showErrors;

            if (this.showAlertError) {
                return;
            }

            this.$axios.retry.post(this.$routing.generate('links', this.$i18n.locale), this.form, {
                headers: {
                    'Authorization' : 'Bearer ' + this.getData.token,
                    'Accept' : 'application/json',
                }
            })
                .then((response) => {
                    this.showAlertSuccess = true;
                    this.successMessage = response.data.message;
                    this.showAlertSuccess = true;
                    this.form.address = '';
                    this.$emit('on-add-link');
                })
                .catch((err) => {
                    this.showAlertError = true;
                    this.errors.push(err.response.data.message);

                    if (HTTP.UNAUTHORIZED === err.response.status) {
                        this.onUnauthorized();
                    }
                }
            );
        },
        onReset: function(event) {
            event.preventDefault();
            this.form.address = '';
        },
        clearAlert() {
            this.showAlertError = false;
            this.showAlertSuccess = false;
            this.errors = [];
            this.successMessage = '';
        },
        onUnauthorized: function()
        {
            localStorage.removeItem('data');
            this.setData(null);
            this.$router.push({name: 'login', params: {locale: this.$i18n.locale}});
        }
    },
}
</script>

<style scoped>

</style>
