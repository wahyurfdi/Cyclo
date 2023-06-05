<template>
    <container>
        <div class="h-full w-full py-8 px-6">
            <div class="flex" @click="$router.push('/web-app/home')">
                <i class="fa fa-chevron-left text-yellow text-base my-auto mx-2"></i>
                <span class="font-bold text-green-dark text-base">Beranda</span>
            </div>

            <div class="w-full h-full flex">
                <div class="text-center m-auto flex flex-col">
                    <i class="fa fa-check-circle text-8xl text-green mb-6 animate-bounce"></i>
                    <span class="text-xl font-bold mb-3">Yayy! Request Dibuat</span>
                    <span class="text-sm font-medium text-gray-dark">
                        Driver akan menjemput sampah daur <br> ulang ke alamat mu segera
                    </span>
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