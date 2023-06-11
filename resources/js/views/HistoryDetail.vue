<template>
    <container>
        <div class="h-full w-full py-8 px-6">
            <div class="flex" @click="$router.push('/web-app/history')">
                <i class="fa fa-chevron-left text-yellow text-base my-auto mx-2"></i>
                <span class="font-bold text-green-dark text-base">{{ $route.params.code }}</span>
            </div>

            <div class="mt-8">
                <div class="mb-2">
                    <span class="text-xs font-medium">Alamat Penjemputan</span>
                </div>
                <div class="mb-5">
                    <div class="rounded-[10px] shadow-md px-3 py-4">
                        <div class="flex">
                            <span class="text-md font-medium my-auto">{{ historyDetail.pickup_name ?? '-' }}</span>
                            <span class="mx-2 text-gray my-auto">|</span>
                            <span class="text-xs text-gray-dark my-auto">{{ historyDetail.pickup_telp ?? '-' }}</span>
                        </div>
                        <div class="mt-1">
                            <span class="text-xs text-gray-dark my-auto">
                                {{ historyDetail.pickup_address ?? '-' }} {{ historyDetail.pickup_location_detail !== null ? `(${historyDetail.pickup_location_detail})` : '' }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="mb-2">
                    <span class="text-xs font-medium">Daftar Sampah</span>
                </div>
                <div class="grid gap-5">
                    <div class="grid-cols-12" v-for="(trash, i) in historyDetail.trash_list ?? []" :key="i">
                        <trash-type-item
                            :image="trash.image"
                            :title="trash.name"
                            :description="trash.description"
                            :coin="trash.coin"
                        >
                            <span class="text-xs font-medium">{{ trash.qty }} Item, {{ trash.weight }} Kg</span>
                        </trash-type-item>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-navigation fixed bottom-0 mx-auto px-6 pt-5 pb-[26px] w-full max-w-[512px]">
            <div class="flex">
                <div class="w-6/12 flex flex-col">
                    <span class="text-sm font-bold mb-2">{{ historyDetail.total_qty }} Item, {{ historyDetail.total_weight }} Kg</span>
                    <div class="flex">
                        <span class="text-sm font-normal text-gray-dark my-auto">Dapat Koin</span>
                        <div class="my-auto ml-1">
                            <i class="fa fa-circle text-xs text-yellow"></i>
                            <span class="text-sm font-medium ml-1">{{ historyDetail.total_coin }}</span>
                        </div>
                    </div>
                </div>
                <div class="w-6/12">
                    <button v-if="historyDetail !== '' && historyDetail.status_code === 'PENDING'" class="mb-auto py-3 px-4 rounded-[10px] bg-red text-left flex w-full" @click="cancelTransaction()">
                        <span class="font-semibold text-white text-base">Batalkan</span>
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
    import Container from './../components/Container.vue'
    import TrashTypeItem from './../components/TrashTypeItem.vue'
    import LoadingScreen from './../components/LoadingScreen.vue'

    export default {
        name: 'App',
        components: {
            'container': Container,
            'trash-type-item': TrashTypeItem,
            'loading-screen': LoadingScreen
        },
        data: function() {
            return {
                historyDetail: '',
                loading: {
                    screen: false
                }
            }
        },
        computed: {
            ...mapState(['trashTypes']),
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
        mounted() {
            this.loadHistoryDetail()
        },
        methods: {
            ...mapActions(['updateTrashQty', 'showToast']),
            loadHistoryDetail() {
                this.loading.screen = true

                this.$http.get('/api/trash/transaction/detail', {
                        params: {
                            trash_transaction_code: this.$route.params.code
                        }
                    }, { headers: {'Authorization' : `Bearer ${this.token}`} })
                    .then((result) => {
                        this.loading.screen = false
                        if(result.data.status == 'OK') {
                            this.historyDetail = result.data.result.trash_transaction
                        }
                    })
                    .catch((error) => {
                        this.loading.screen = false
                    })
            },
            cancelTransaction() {
                this.loading.screen = true
                
                this.$http.post('/api/trash/transaction/cancel', {
                        trash_transaction_code: this.$route.params.code
                    }, { headers: {'Authorization' : `Bearer ${this.token}`} })
                    .then((result) => {
                        this.loading.screen = false
                        if(result.data.status == 'OK') {
                            this.loadHistoryDetail()
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