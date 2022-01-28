<template>
    <div class="app">
        <nav-bar
            v-show="isAuthenticated"
        ></nav-bar>
        <b-container>
            <router-view></router-view>
        </b-container>
    </div>
</template>

<script>
import NavBar from './Components/NavBar';

export default {
    name: 'app',
    components:{
        NavBar,
    },
    data() {
        return {
            isAuthenticated: true,
        };
    },
    mounted() {
        this.$i18n.locale = this.$route.params.locale;
    }
}
</script>
