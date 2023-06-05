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
                    <input type="text" class="bg-gray-light text-base py-2 px-3 rounded-lg" placeholder="Masukan nama">
                </div>
                <div class="flex flex-col mb-4">
                    <label class="text-sm text-gray-dark mb-2">Telepon</label>
                    <input type="telp" class="bg-gray-light text-base py-2 px-3 rounded-lg" placeholder="Masukan telepon">
                </div>
                <div class="flex flex-col mb-4">
                    <label class="text-sm text-gray-dark mb-2">Alamat</label>
                    <textarea class="bg-gray-light text-base py-2 px-3 rounded-lg" placeholder="Masukan alamat"></textarea>
                </div>
                <div class="flex flex-col mb-4">
                    <label class="text-sm text-gray-dark mb-2">Detail Lokasi</label>
                    <textarea class="bg-gray-light text-base py-2 px-3 rounded-lg" placeholder="Masukan detail lokasi"></textarea>
                </div>
            </div>

            <div class="shadow-navigation absolute bottom-0 left-0 px-6 pt-5 pb-[26px] w-full">
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
                        <button class="mb-auto py-4 px-4 rounded-[10px] bg-green text-left flex w-full" @click="$router.push('/web-app/request-pickup/result')">
                            <span class="font-semibold text-white text-sm">Request Pickup</span>
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
    import Container from './../../components/Container.vue'
    import TrashTypeItem from './../../components/TrashTypeItem.vue'

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