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
            ...mapState(['toast', 'token'])
        },
        created() {
            if(this.$route.name != 'login' && this.$route.name != 'signup') {
                let token = localStorage.getItem('token')
                this.setToken(token)
                this.loadProfile()
            }
        },
        methods: {
            ...mapActions(['checkRequestError', 'setToken', 'setProfile']),
            loadProfile() {
                this.$http.get('/api/profile', { headers: {'Authorization' : `Bearer ${this.token}`} })
                    .then((result) => {
                        this.setProfile(result.data.result)
                    })
                    .catch((error) => {
                        this.checkRequestError(error)
                    })
            }
        }
    }
</script>