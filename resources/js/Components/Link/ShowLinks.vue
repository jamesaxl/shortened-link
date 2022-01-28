<template>
    <div class="overflow-auto">
        <b-alert v-model="showAlertSuccess" variant="success" dismissible>
            {{ this.successMessage }}
        </b-alert>
        <b-alert v-model="showAlertError" variant="danger" dismissible>
            {{ this.errorMessage }}
        </b-alert>
        <div  class="mt-5">
            <b-pagination
                v-if="0 < items.length"
                v-model="page"
                :total-rows="total"
                :per-page="maxRow"
                @input="linkGen(page)"
                aria-controls="projects-table"
            ></b-pagination>
            <b-table
                v-if="0 < generateItems.length"
                id="projects-table"
                class="mt-1"
                sticky-header
                striped bordered
                fixed
                :data="generateItems"
                :fields="fields"
                :items="generateItems"
                table-variant="info"
                :current-page="page"
            >
                <template v-slot:cell(shortAddress)="{ item }">
                    <a :href="item.shortAddress" target="_blank">
                        {{ item.shortAddress }}
                    </a>
                </template>
                <template v-slot:cell(createdAt)="{ item }">
                    {{ item.createdAt | dateTime }}
                </template>
                <template v-slot:cell(action)="{ item }">
                    <b-button variant="danger" @click="deleteAddress(item.id)">
                        <b>X</b>
                    </b-button>
                </template>
            </b-table>
            <b-alert
                v-else
                class="mt-5"
                show
                variant="info"
            >
                No links.
            </b-alert>
        </div>
    </div>
</template>

<script>
import {DateMixin} from '../../mixins';
import {mapGetters, mapMutations} from 'vuex';
import {HTTP} from '../../utils/constants';

export default {
    name: "ShowLinks",
    mixins: [
        DateMixin,
    ],
    data() {
        return {
            showAlertSuccess: false,
            successMessage: '',
            showAlertError: false,
            errorMessage: '',
            fields: [
                {
                    key: 'address',
                    label: this.$t('links.address'),
                },
                {
                    key: 'shortAddress',
                    label: this.$t('links.shortAddress'),
                },
                {
                    key: 'createdAt',
                    label: this.$t('links.createdAt'),
                },
                {
                    key: 'action',
                    label: this.$t('links.action'),
                }],
            items: [],
            page: this.$route.params.page || 1,
            total: 0,
            maxRow: process.env.MIX_PAGINATE,
        }
    },
    computed: {
        ...mapGetters('auth',
            [
                'getData',
            ]
        ),
        generateItems() {
            return this.items.map((item) => {
                return {
                    id: item.id,
                    address: item.address,
                    shortAddress: process.env.MIX_SHORT_BASE_URL + '/' + item.token,
                    createdAt: item.created_at,
                }
            });
        }
    },
    methods: {
        ...mapMutations('auth',
            [
                'setData',
            ]
        ),
        getLinks: function() {
            this.$axios.retry.get(this.$routing.generate('links', this.$i18n.locale) + '?page=' + this.page,
                {
                    headers: {
                        'Authorization' : 'Bearer ' + this.getData.token,
                        'Accept' : 'application/json',
                    },
                })
                .then((response) => {
                    this.items = response.data.data.data;
                    this.page = response.data.data.current_page;
                    this.total = response.data.data.total;
                }).catch((err) => {
                    this.showAlertError = true;
                    this.errorMessage = err.response.data.message;

                    if (HTTP.UNAUTHORIZED === err.response.status) {
                        this.onUnauthorized();
                    }
            });
        },
        deleteAddress: function(id) {
            this.$axios.retry.delete(this.$routing.generate('links', this.$i18n.locale) + '/' +  id,
                {
                    headers: {
                        'Authorization' : 'Bearer ' + this.getData.token,
                        'Accept' : 'application/json',
                    },
                })
                .then((response) => {
                    this.showAlertSuccess = true;
                    this.successMessage = response.data.message;
                    this.getLinks();
                })
                .catch((err) => {
                    this.showAlertError = true;
                    this.errorMessage = err.response.data.message;

                    if (HTTP.UNAUTHORIZED === err.response.status) {
                        this.onUnauthorized();
                    }
            });
        },
        linkGen: function(page) {
            this.page = page;
            this.getLinks();
        },
        clearAlert: function() {
            this.showAlertError = false;
            this.showAlertSuccess = false;
            this.successMessage = '';
            this.errorMessage = '';
        },
        onUnauthorized: function()
        {
            localStorage.removeItem('data');
            this.setData(null);
            this.$router.push({name: 'login', params: {locale: this.$i18n.locale}});
        }
    },
    mounted() {
        this.getLinks();
    },
}
</script>

