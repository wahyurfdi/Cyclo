<template>
    <container>
        <bottom-navigation :menu-actived="2"></bottom-navigation>
    </container>
</template>

<script>
    import Container from './../components/Container.vue'
    import BottomNavigation from './../components/BottomNavigation.vue'

    export default {
        name: 'App',
        components: {
            'container': Container,
            'bottom-navigation': BottomNavigation
        }
    }
</script>