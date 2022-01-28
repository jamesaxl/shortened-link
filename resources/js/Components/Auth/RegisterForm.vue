<template>
    <div class="mt-5">
        <b-card
            class="mt-3"
            :header="$t('form.register')"
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
                        {{ error }}
                    </li>
                </ul>
            </b-alert>
            <b-form @submit="onSubmit" @reset="onReset">
                <b-form-group
                    id="input-group-email"
                    :label="$t('form.email')"
                    label-for="input-1"
                >
                    <b-form-input
                        id="input-email"
                        v-model="form.email"
                        type="text"
                        :placeholder="$t('form.enterEmail')"
                    ></b-form-input>
                </b-form-group>

                <b-form-group
                    id="input-group-password"
                    :label="$t('form.password')"
                    label-for="input-2"
                >
                    <b-form-input
                        id="input-password"
                        type="password"
                        v-model="form.password"
                        :placeholder="$t('form.enterPassword')"
                    ></b-form-input>
                </b-form-group>

                <b-form-group
                    id="input-group-password"
                    :label="$t('form.rePassword')"
                    label-for="input-2"
                >
                    <b-form-input
                        id="input-re-password"
                        type="password"
                        v-model="form.rePassword"
                        :placeholder="$t('form.enterRePassword')"
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
import {CheckInputMixin} from "../../mixins";

export default {
    name: "RegisterForm",
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
                email: '',
                password: '',
                rePassword: '',
            }
        };
    },
    computed: {
        showErrors() {
            return this.errors.length > 0;
        }
    },
    methods: {
        onCheck: function() {
            this.clearAlert();

            if (false === this.checkRequired(this.form.email)) {
                this.errors.push(this.$t('email.required'));
            }

            if (!this.checkLengthMax(this.form.email, 255)) {
                this.errors.push(this.$t('email.max'));
            }

            if (!this.checkEmail(this.form.email)) {
                this.errors.push(this.$t('email.email'));
            }

            if (!this.checkRequired(this.form.password)) {
                this.errors.push(this.$t('password.required'));
            }

            if (!this.checkLengthMin(this.form.password, 8)) {
                this.errors.push(this.$t('password.min'));
            }

            if (!this.checkLengthMax(this.form.password, 255)) {
                this.errors.push(this.$t('password.max'));
            }

            if (!this.checkMatch(this.form.password, this.form.rePassword)) {
                this.errors.push(this.$t('password.confirmation'));
            }
        },
        onSubmit: function(event) {
            event.preventDefault();
            this.onCheck();
            this.showAlertError = this.showErrors;

            if (this.showAlertError) {
                return;
            }

            this.$axios.retry.post(this.$routing.generate('register', this.$i18n.locale), {
                email: this.form.email,
                password: this.form.password,
                password_confirmation: this.form.rePassword,
            })
                .then((response) => {
                    this.showAlertSuccess = true;
                    this.successMessage = response.data.message;
                    this.form = {
                        email: '',
                        password: '',
                        rePassword: '',
                    }
                }).catch((err) => {
                    this.errors.push(err.response.data.message);
                    this.showAlertError = true;
                }
            );
        },
        onReset: function() {
            this.form = {
                email: '',
                password: '',
                rePassword: ''
            }
        },
        clearAlert() {
            this.errors = [];
            this.showAlertError = false;
            this.showAlertSuccess = false;
            this.successMessage = ''
        },
    },
}
</script>

<style scoped>

</style>
