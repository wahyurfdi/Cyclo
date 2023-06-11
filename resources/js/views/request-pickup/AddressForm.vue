<template>
    <container>
        <div class="h-full w-full py-8 px-6">
            <div class="flex" @click="$router.push('/web-app/request-pickup/trash-form')">
                <i class="fa fa-chevron-left text-yellow text-base my-auto mx-2"></i>
                <span class="font-bold text-green-dark text-base">Tentukan Alamat</span>
            </div>

            <div class="mt-8">
                <div class="flex flex-col mb-4">
                    <label class="text-sm text-gray-dark mb-2">Nama</label>
                    <input type="text" class="bg-gray-light text-base py-2 px-3 rounded-lg" v-model="form.nama" placeholder="Masukan nama">
                </div>
                <div class="flex flex-col mb-4">
                    <label class="text-sm text-gray-dark mb-2">Telepon</label>
                    <input type="telp" class="bg-gray-light text-base py-2 px-3 rounded-lg" v-model="form.telepon" placeholder="Masukan telepon">
                </div>
                <div class="flex flex-col mb-4">
                    <label class="text-sm text-gray-dark mb-2">Alamat</label>
                    <textarea class="bg-gray-light text-base py-2 px-3 rounded-lg" v-model="form.alamat" placeholder="Masukan alamat"></textarea>
                </div>
                <div class="flex flex-col mb-4">
                    <label class="text-sm text-gray-dark mb-2">Detail Lokasi</label>
                    <textarea class="bg-gray-light text-base py-2 px-3 rounded-lg" v-model="form.detailLokasi" placeholder="Masukan detail lokasi"></textarea>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-navigation fixed bottom-0 mx-auto px-6 pt-5 pb-[26px] w-full max-w-[512px]">
            <div class="flex">
                <div class="w-6/12 flex flex-col">
                    <span class="text-sm font-bold mb-2">{{ totalQty }} Item, {{ totalWeight }} Kg</span>
                    <div class="flex">
                        <span class="text-sm font-normal text-gray-dark my-auto">Dapat Koin</span>
                        <div class="my-auto ml-1">
                            <i class="fa fa-circle text-xs text-yellow"></i>
                            <span class="text-sm font-medium ml-1">{{ totalCoin }}</span>
                        </div>
                    </div>
                </div>
                <div class="w-6/12">
                    <button class="mb-auto py-3 px-4 rounded-[10px] bg-green text-left flex w-full" @click="sendTransaction()">
                        <span class="font-semibold text-white text-base">Request Pickup</span>
                        <i class="fa fa-chevron-right text-yellow text-sm ml-auto my-auto"></i>
                    </button>
                </div>
            </div>
        </div>

        <loading-screen :is-show="loading.screen"></loading-screen>
    </container>
</template>

<script>
    import { mapActions, mapState } from 'vuex'
    import Container from './../../components/Container.vue'
    import LoadingScreen from './../../components/LoadingScreen.vue'

    export default {
        name: 'App',
        components: {
            'container': Container,
            'loading-screen': LoadingScreen
        },
        data: function() {
            return {
                form: {
                    nama: '',
                    telepon: '',
                    alamat: '',
                    detailLokasi: ''
                },
                loading: {
                    screen: false
                }
            }
        },
        computed: {
            ...mapState(['trashTypes', 'toast', 'token']),
            totalQty() {
                let qty = 0
                this.trashTypes.forEach((trashType) => {
                    qty += trashType.qty
                })

                return qty
            },
            totalWeight() {
                let weight = 0
                this.trashTypes.forEach((trashType) => {
                    weight += trashType.qty*trashType.weightPerQty
                })

                return Number(weight).toFixed(2)
            },
            totalCoin() {
                let coin = 0
                this.trashTypes.forEach((trashType) => {
                    coin += trashType.qty*trashType.coinPerQty
                })

                return Number(coin).toFixed(0)
            }
        },
        mounted() {},
        methods: {
            ...mapActions(['updateTrashQty', 'showToast']),
            sendTransaction() {
                if(this.form.nama == '') {
                    return this.showToast('Harap mengisi nama')
                } else if(this.form.telepon == '') {
                    return this.showToast('Harap mengisi nomor telepon')
                } else if(this.form.alamat == '') {
                    return this.showToast('Harap mengisi alamat')
                }
                
                let trashList = []
                this.trashTypes.forEach((trash) => {
                    if(trash.qty > 0) {
                        trashList.push({
                            trash_type_id: trash.id,
                            qty: trash.qty
                        })
                    }
                })

                this.loading.screen = true

                this.$http.post('/api/trash/transaction/create', {
                        pickup_name: this.form.nama,
                        pickup_telp: this.form.telepon,
                        pickup_address: this.form.alamat,
                        pickup_location_detail: this.form.detailLokasi,
                        trash_list: trashList
                    }, { headers: {'Authorization' : `Bearer ${this.token}`} })
                    .then((result) => {
                        this.loading.screen = false
                        
                        if(result.data.status == 'OK') {
                            this.$router.push('/web-app/request-pickup/result')
                        } else {
                            this.showToast(result.data.message)
                        }
                    })
                    .catch((error) => {
                        this.loading.screen = false
                    })
            }
        }
    }
</script>

<style scoped>
    .shadow-navigation {
        box-shadow: 0px 0px 4px rgba(0, 0, 0, 0.15);
    }
</style>