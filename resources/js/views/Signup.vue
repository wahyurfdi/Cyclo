<template>
    <container>
        <div class="h-full w-full py-8 px-6">
            <div class="flex" @click="$router.push('/web-app/login')">
                <i class="fa fa-chevron-left text-yellow text-base my-auto mx-2"></i>
                <span class="font-bold text-green-dark text-base">Daftar Akun</span>
            </div>

            <div class="mt-8">
                <div class="flex flex-col mb-4">
                    <label class="text-sm text-gray-dark mb-2">Username</label>
                    <input type="text" class="bg-gray-light text-base py-2 px-3 rounded-lg" v-model="form.username" placeholder="Masukan username">
                </div>
                <div class="flex flex-col mb-4">
                    <label class="text-sm text-gray-dark mb-2">Password</label>
                    <input type="password" class="bg-gray-light text-base py-2 px-3 rounded-lg" v-model="form.password" placeholder="Masukan password">
                </div>
            </div>
            <div class="mb-4 border-b-[1px] border-b-gray">
                <span class="text-sm font-medium">Informasi Pribadi</span>
            </div>
            <div>
                <div class="flex flex-col mb-4">
                    <label class="text-sm text-gray-dark mb-2">Nama</label>
                    <input type="text" class="bg-gray-light text-base py-2 px-3 rounded-lg" v-model="form.name" placeholder="Masukan nama">
                </div>
                <div class="flex flex-col mb-4">
                    <label class="text-sm text-gray-dark mb-2">Telepon</label>
                    <input type="telp" class="bg-gray-light text-base py-2 px-3 rounded-lg" v-model="form.phone" placeholder="Masukan telepon">
                </div>
                <div class="flex flex-col mb-4">
                    <label class="text-sm text-gray-dark mb-2">Alamat</label>
                    <textarea class="bg-gray-light text-base py-2 px-3 rounded-lg" v-model="form.address" placeholder="Masukan alamat"></textarea>
                </div>
                <div class="flex flex-col mb-4">
                    <label class="text-sm text-gray-dark mb-2">Detail Lokasi</label>
                    <textarea class="bg-gray-light text-base py-2 px-3 rounded-lg" v-model="form.locationDetail" placeholder="Masukan detail lokasi"></textarea>
                </div>
            </div>
        </div>

        <div class="fixed bottom-0 mx-auto px-6 pt-5 pb-[26px] w-full max-w-[512px]">
            <button class="mb-auto py-3 px-4 rounded-[10px] text-left flex w-full" :class="[isFormFilled ? 'bg-green' : 'bg-gray-dark']" @click="signup()">
                <span class="font-semibold text-white text-base">Sign Up</span>
                <i class="fa fa-chevron-right text-yellow text-sm ml-auto my-auto"></i>
            </button>
        </div>

        <loading-screen :is-show="loading.screen"></loading-screen>
    </container>
</template>

<script>
    import Container from './../components/Container.vue'
    import LoadingScreen from './../components/LoadingScreen.vue'
    import { mapActions } from 'vuex'

    export default {
        data: function() {
            return {
                form: {
                    username: '',
                    password: '',
                    name: '',
                    phone: '',
                    address: '',
                    locationDetail: ''
                },
                loading: {
                    screen: false
                }
            }
        },
        computed: {
            isFormFilled() {
                if(
                    this.form.username != ''
                    && this.form.password != ''
                    && this.form.name != ''
                    && this.form.phone != ''
                    && this.form.address != ''
                ) {
                    return true
                }

                return false
            }
        },
        components: {
            'container': Container,
            'loading-screen': LoadingScreen
        },
        methods: {
            ...mapActions(['showToast', 'checkRequestError']),
            signup() {
                if(this.form.username == '') {
                    return this.showToast('Harap mengisi username')
                } else if(this.form.password == '') {
                    return this.showToast('Harap mengisi password')
                } else if(this.form.name == '') {
                    return this.showToast('Harap mengisi nama')
                } else if(this.form.phone == '') {
                    return this.showToast('Harap mengisi telepon')
                } else if(this.form.address == '') {
                    return this.showToast('Harap mengisi alamat')
                }

                this.loading.screen = true

                this.$http.post('/api/signup', {
                        name: this.form.name,
                        phone: this.form.phone,
                        address: this.form.address,
                        location_detail: this.form.locationDetail,
                        username: this.form.username,
                        password: this.form.password
                    })
                    .then((result) => {
                        this.loading.screen = false
                        
                        if(result.data.status == 'OK') {
                            this.$router.push('/web-app/login')
                        }

                        this.showToast(result.data.message)
                    })
                    .catch((error) => {
                        this.loading.screen = false

                        this.checkRequestError(error)
                    })
            }
        }
    }
</script>