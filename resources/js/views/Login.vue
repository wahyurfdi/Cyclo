<template>
    <container>
        <div class="h-full w-full py-8 px-6 flex flex-col">
            <img src="/img/logo.png" class="w-[124px] mt-auto mb-11 mx-auto">
            <input type="text" class="bg-gray-light rounded-[10px] py-3 px-[14px] text-sm w-full mb-3" v-model="form.username" placeholder="Masukan username">
            <input type="password" class="bg-gray-light rounded-[10px] py-3 px-[14px] text-sm w-full mb-7" v-model="form.password" placeholder="Masukan password">
            <div class="mb-auto flex flex-col">
                <div class="w-12/12">
                    <button class="w-full py-3 px-4 rounded-[10px] bg-[#609966] flex" @click="login()">
                        <span class="font-semibold text-white text-base mx-auto">Login</span>
                        <!-- <i class="fa fa-chevron-right text-yellow text-base ml-auto my-auto"></i> -->
                    </button>
                </div>
                <div class="w-12/12 flex mt-5" @click="$router.push('/web-app/signup')">
                    <span class="mx-auto text-gray-dark text-sm">Belum Punya Akun?</span>
                </div>
            </div>
        </div>

        <loading-screen :is-show="loading.screen"></loading-screen>
    </container>
</template>

<script>
    import Container from './../components/Container.vue'
    import LoadingScreen from './../components/LoadingScreen.vue'
    import { mapActions, mapState } from 'vuex'

    export default {
        name: 'App',
        components: {
            'container': Container,
            'loading-screen': LoadingScreen
        },
        data: function() {
            return {
                form: {
                    username: '',
                    password: ''
                },
                loading: {
                    screen: false
                }
            }
        },
        computed: {},
        methods: {
            ...mapActions(['checkRequestError', 'showToast']),
            login() {
                this.loading.screen = true

                this.$http.post('/api/login', {
                        username: this.form.username,
                        password: this.form.password
                    })
                    .then((result) => {
                        this.loading.screen = false
                        
                        if(result.data.status == 'OK') {
                            localStorage.setItem('token', result.data.result.token)

                            // this.$router.push('/web-app/home')
                            location.href = '/web-app/home'
                        } else {
                            this.showToast(result.data.message)
                        }
                    })
                    .catch((error) => {
                        this.loading.screen = false

                        this.checkRequestError(error)
                    })
            }
        }
    }
</script>