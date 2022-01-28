<template>
    <div class="mt-2">
        <show-links
            ref="links"
        ></show-links>
        <add-link
            @on-add-link="onAddLink"
        ></add-link>
    </div>
</template>

<script>
import AddLink from '../Components/Link/AddLink';
import ShowLinks from '../Components/Link/ShowLinks';

export default {
    name: 'DashBoard',
    components: {
        AddLink,
        ShowLinks,
    },
    methods: {
        onAddLink: function() {
            this.$refs.links.getLinks();
        },
    },
}
</script>

<style scoped>

</style>
