<template>
    <container>
        <div class="w-full h-full flex">
            <div class="m-auto flex flex-col text-center">
                <i class="fas fa-circle-user text-[116px] text-green"></i>
                <span class="text-base font-bold mt-6 uppercase">{{ profile.name ?? '-' }}</span>
                <span class="text-base text-gray-dark">@{{ profile.username ?? '-' }}</span>
                <button class="mb-auto py-3 px-4 rounded-[10px] bg-yellow text-left flex text-green-dark mt-16" @click="logout()">
                    <span class="font-semibold text-base">Logout</span>
                    <i class="fa fa-right-from-bracket text-sm ml-auto my-auto"></i>
                </button>
            </div>
        </div>

        <bottom-navigation :menu-actived="3"></bottom-navigation>
    </container>
</template>

<script>
    import Container from './../components/Container.vue'
    import BottomNavigation from './../components/BottomNavigation.vue'
    import { mapState } from 'vuex'

    export default {
        name: 'App',
        components: {
            'container': Container,
            'bottom-navigation': BottomNavigation
        },
        computed: {
            ...mapState(['profile'])
        },
        methods: {
            logout() {
                localStorage.removeItem('token')

                this.$router.push('/web-app/login')
            }
        }
    }
</script>