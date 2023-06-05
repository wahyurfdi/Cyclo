<template>
    <container>
        <div class="h-full w-full py-8 px-6">
            <div class="flex" @click="$router.push('/web-app/home')">
                <i class="fa fa-chevron-left text-yellow text-base my-auto mx-2"></i>
                <span class="font-bold text-green-dark text-base">Pilih Sampah</span>
            </div>

            <div class="grid gap-5 mt-8">
                <div class="grid-cols-12" v-for="(trashType, i) in trashTypes" :key="i">
                    <trash-type-item
                        :image="trashType.image"
                        :title="trashType.title"
                        :description="trashType.description"
                        :coin="trashType.coinPerQty"
                    >
                        <div class="w-full h-full flex">
                            <button v-show="trashType.qty > 0" class="bg-yellow px-2 rounded-[4px]" @click="updateTrashQty({ type: 'MINUS', idx: i })">
                                <i class="fa fa-minus text-xs text-green-dark"></i>
                            </button>
                            <span v-show="trashType.qty > 0" class="font-bold text-sm mx-3 my-auto">{{ trashType.qty }}</span>
                            <button class="bg-yellow px-2 rounded-[4px]" @click="updateTrashQty({ type: 'ADD', idx: i })">
                                <i class="fa fa-plus text-xs text-green-dark"></i>
                            </button>
                        </div>
                    </trash-type-item>
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
                        <button class="mb-auto py-4 px-4 rounded-[10px] bg-green text-left flex w-full" @click="$router.push('/web-app/request-pickup/address-form')">
                            <span class="font-semibold text-white text-sm">Lanjutkan</span>
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