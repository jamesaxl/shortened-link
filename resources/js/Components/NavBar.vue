<template>
    <b-navbar toggleable="lg" type="dark" variant="primary">
        <b-navbar-brand
            :to="{ name: 'dashboard', params: {locale: $i18n.locale, page: 1}}"
        >
            Shortened Link</b-navbar-brand>
        <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>
        <b-collapse id="nav-collapse" is-nav>
            <b-navbar-nav class="ml-auto">
                <b-nav-item
                    v-show="!isAuthenticate"
                    :to="{ name: 'login', params: {locale: $i18n.locale}}"
                    :class="{active: $route.name==='login'}"
                >
                    {{ $t('menu.login') }}
                </b-nav-item>
                <b-nav-item
                    v-show="!isAuthenticate"
                    :to="{ name: 'register'}"
                    :class="{active: $route.name==='register'}"
                >
                    {{ $t('menu.register') }}
                </b-nav-item>
                <b-nav-item-dropdown :text="$t('menu.lang')" right>
                    <b-dropdown-item
                        @click="onLocaleChange('en')"
                    >
                        EN
                    </b-dropdown-item>
                    <b-dropdown-item
                        @click="onLocaleChange('ru')"
                    >
                        RU
                    </b-dropdown-item>
                </b-nav-item-dropdown>
                <b-nav-item-dropdown
                    v-show="isAuthenticate"
                    right
                >
                    <template #button-content>
                        <em>{{ $t('menu.action') }}</em>
                    </template>
                    <b-dropdown-item
                        @click="onLogout"
                    >
                        {{ $t('menu.logout') }}
                    </b-dropdown-item>
                </b-nav-item-dropdown>
            </b-navbar-nav>
        </b-collapse>
    </b-navbar>
</template>

<script>
import {mapGetters, mapMutations} from "vuex";

export default {
    name: 'NavBar',
    computed: {
        ...mapGetters(
            'auth',
            [
                'getData'
            ],
        ),
        isAuthenticate() {
            return this.getData;
        }
    },
    methods: {
        ...mapMutations(
            'auth',
            [
                'setData',
            ]
        ),
        onLogout: function() {
            this.$axios.retry.post(this.$routing.generate('logout', this.$i18n.locale), {},
                {
                    headers: {
                        'Authorization' : 'Bearer ' + this.getData.token,
                        'Accept' : 'application/json',
                    },
                })
                .catch((err) => {
                    // normally we should put it on the log - It is just for production
                    // обычно мы должны записать это в Log  - Это только для производства
                    console.error(err);
                });

            localStorage.removeItem('data');
            this.setData(null);
            this.$router.push({name: 'login', params: { locale: this.$i18n.locale }});
        },
        onLocaleChange: function(locale) {
            if (locale === this.$i18n.locale) {
                return;
            }

            this.$i18n.locale = locale;
            this.$router.push({ params: {locale} });
        },
    },
    mounted() {
        this.$i18n.locale = this.$route.params.locale
    }
}
</script>
