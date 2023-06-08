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
                            <span class="text-md font-medium my-auto">Wahyu Rifaldi</span>
                            <span class="mx-2 text-gray my-auto">|</span>
                            <span class="text-xs text-gray-dark my-auto">082128415485</span>
                        </div>
                        <div class="mt-1">
                            <span class="text-xs text-gray-dark my-auto">
                                Cibeureum, Kec. Cimahi Sel., Kota Cimahi, Jawa Barat 40535
                            </span>
                        </div>
                    </div>
                </div>
                <div class="mb-2">
                    <span class="text-xs font-medium">Daftar Sampah</span>
                </div>
                <div class="grid gap-5">
                    <div class="grid-cols-12" v-for="i in 3" :key="i">
                        <trash-type-item
                            :image="'/img/trash-type/trash-02.jpg'"
                            :title="'Sampah'"
                            :description="'Sampah sampah sampah'"
                            :coin="100"
                        >
                            <span class="text-xs font-medium">1 Item, 10 Kg</span>
                        </trash-type-item>
                    </div>
                </div>
            </div>

            <div class="shadow-navigation absolute bottom-0 left-0 px-6 pt-5 pb-[26px] w-full">
                <div class="flex">
                    <div class="w-6/12 flex flex-col">
                        <span class="text-sm font-bold mb-2">1 Item, 1 Kg</span>
                        <div class="flex">
                            <span class="text-sm font-normal text-gray-dark my-auto">Dapat Koin</span>
                            <div class="my-auto ml-1">
                                <i class="fa fa-circle text-xs text-yellow"></i>
                                <span class="text-sm font-medium ml-1">100</span>
                            </div>
                        </div>
                    </div>
                    <div class="w-6/12">
                        <button class="mb-auto py-3 px-4 rounded-[10px] bg-red text-left flex w-full" @click="$router.push('/web-app/request-pickup/result')">
                            <span class="font-semibold text-white text-sm">Batalkan</span>
                            <i class="fa fa-chevron-right text-yellow text-base ml-auto my-auto"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </container>
</template>

<script>
    import { mapActions, mapState } from 'vuex'
    import Container from './../components/Container.vue'
    import TrashTypeItem from './../components/TrashTypeItem.vue'

    export default {
        name: 'App',
        components: {
            'container': Container,
            'trash-type-item': TrashTypeItem
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
        methods: {
            ...mapActions(['updateTrashQty'])
        }
    }
</script>

<style scoped>
    .shadow-navigation {
        box-shadow: 0px 0px 4px rgba(0, 0, 0, 0.15);
    }
</style>