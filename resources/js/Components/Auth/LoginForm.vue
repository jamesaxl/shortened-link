<template>
    <div class="mt-5">
        <b-card
            class="mt-3"
            :header="$t('form.login')"
            header-bg-variant="primary"
            header-text-variant="white"
        >
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
import {mapGetters, mapMutations} from "vuex";

export default {
    name: "LoginForm",
    mixins: [
        CheckInputMixin,
    ],
    data() {
        return {
            showAlertError: false,
            errors: [],
            form: {
                email: '',
                password: ''
            }
        };
    },
    computed: {
        showErrors() {
            return this.errors.length > 0;
        },
    },
    methods: {
        ...mapMutations('auth',
            [
                'setData',
            ]
        ),
        onCheck: function() {
            this.clearAlert();

            if (false === this.checkRequired(this.form.email)) {
                this.errors.push('email.required');
            }

            if (!this.checkLengthMax(this.form.email, 255)) {
                this.errors.push('email.max');
            }

            if (!this.checkEmail(this.form.email)) {
                this.errors.push('email.email');
            }

            if (!this.checkRequired(this.form.password)) {
                this.errors.push('password.required');
            }

            if (!this.checkLengthMax(this.form.password, 255)) {
                this.errors.push('password.max');
            }
        },
        onSubmit: function(event) {
            event.preventDefault();
            this.onCheck();
            this.showAlertError = this.showErrors;

            if (this.showAlertError) {
                return;
            }

            this.$axios.retry.post(this.$routing.generate('login', this.$i18n.locale), this.form)
                .then((response) => {
                    const data = {user: response.data.data.user, token: response.data.data.token};
                    this.setData(data);
                    localStorage.setItem('data', JSON.stringify(data));
                    this.$router.push({name: 'dashboard', params: { locale: this.$i18n.locale, page: '1' }})

                }).catch((err) => {
                    this.errors.push(err.response.data.message);
                    this.showAlertError = true;
                }
            );
        },
        onReset: function() {
            this.form = {
                email: '',
                password: ''
            }
        },
        clearAlert() {
            this.errors = [];
            this.showAlertError = false;
        },
    },
}
</script>

