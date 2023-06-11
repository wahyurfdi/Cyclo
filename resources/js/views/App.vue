<template>
    <div class="flex flex-col">
        <router-view></router-view>
        <div class="w-full max-w-[512px] mx-auto">
            <toast :is-show="toast.isShow" :message="toast.message"></toast>
        </div>
    </div>
</template>

<script>
    import Toast from './../components/Toast.vue'
    import { mapActions, mapState } from 'vuex'

    export default {
        components: {
            'toast': Toast
        },
        computed: {
            ...mapState(['toast'])
        },
        created() {
            let token = localStorage.getItem('token')
            this.setToken(token)
        },
        methods: {
            ...mapActions(['setToken'])
        }
    }
</script>