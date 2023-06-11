<template>
    <container>
        <div class="h-full w-full py-8 px-6">
            <div>
                <span class="font-bold text-green-dark text-base">Riwayat Pengumpulan</span>
            </div>
            <div class="mt-8">
                <div v-for="(history, i) in historyList" :key="i" class="mb-3">
                    <div class="rounded-[10px] shadow-md" @click="$router.push('/web-app/history/'+history.code)">
                        <div class="flex p-3">
                            <span class="text-sm font-bold my-auto">{{ history.code }}</span>
                            <span class="text-xs text-gray-dark my-auto ml-auto">{{ history.created_at }}</span>
                        </div>
                        <div class="border-t-[1px] border-dashed border-gray"></div>
                        <div class="flex p-3">
                            <div class="w-5/12 flex flex-col">
                                <span class="text-xs text-gray-dark mb-1">Pengumpulan</span>
                                <span class="text-sm font-medium mt-[2px]">{{ history.total_qty }} Item, {{ history.total_weight }} Kg</span>
                            </div>
                            <div class="w-3/12 flex flex-col">
                                <span class="text-xs text-gray-dark mb-1">Dapat Koin</span>
                                <div>
                                    <i class="fa fa-circle text-[10px] text-yellow"></i>
                                    <span class="text-sm font-medium ml-1">{{ history.total_coin }}</span>
                                </div>
                            </div>
                            <div class="w-4/12 flex flex-col">
                                <span class="text-xs text-gray-dark ml-auto mb-1">Status</span>
                                <span v-if="history.status_code == 'COMPLETED'" class="text-sm font-medium text-green ml-auto mt-[2px]">Completed</span>
                                <span v-else-if="history.status_code == 'CANCEL'" class="text-sm font-medium text-red ml-auto mt-[2px]">Canceled</span>
                                <span v-else-if="history.status_code == 'PROCESS'" class="text-sm font-medium text-blue ml-auto mt-[2px]">On Going</span>
                                <span v-else class="text-sm font-medium text-gray-dark ml-auto mt-[2px]">Pending</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <bottom-navigation :menu-actived="2"></bottom-navigation>
    </container>
</template>

<script>
    import Container from './../components/Container.vue'
    import BottomNavigation from './../components/BottomNavigation.vue'
    import { mapState } from 'vuex'

    export default {
        name: 'App',
        components: {
            'container': Container,
            'bottom-navigation': BottomNavigation
        },
        data: function() {
            return {
                historyList: []
            }
        },
        computed: {
            ...mapState(['token'])
        },
        mounted() {
            this.loadHistory()
        },
        methods: {
            loadHistory() {
                this.$http.get('/api/trash/transaction/list', { headers: {'Authorization' : `Bearer ${this.token}`} })
                    .then((result) => {
                        if(result.data.status == 'OK') {
                            this.historyList = result.data.result.trash_transaction_list
                        }
                    })
                    .catch((error) => {})
            }
        }
    }
</script>