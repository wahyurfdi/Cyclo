<template>
    <container>
        <div class="h-full w-full py-8 px-6">
            <div>
                <span class="font-bold text-green-dark text-base">Riwayat Pengumpulan</span>
            </div>
            <div class="mt-8">
                <div v-for="i in 3" :key="i" class="mb-3">
                    <div class="rounded-[10px] shadow-md" @click="$router.push('/web-app/history/'+'CYC-000001')">
                        <div class="flex p-3">
                            <span class="text-sm font-bold my-auto">CYC-000001</span>
                            <span class="text-xs text-gray-dark my-auto ml-auto">10 Mei 2023, 10:00</span>
                        </div>
                        <div class="border-t-[1px] border-dashed border-gray"></div>
                        <div class="flex p-3">
                            <div class="w-5/12 flex flex-col">
                                <span class="text-xs text-gray-dark mb-1">Pengumpulan</span>
                                <span class="text-sm font-medium mt-[2px]">1 Item, 10 Kg</span>
                            </div>
                            <div class="w-3/12 flex flex-col">
                                <span class="text-xs text-gray-dark mb-1">Dapat Koin</span>
                                <div>
                                    <i class="fa fa-circle text-[10px] text-yellow"></i>
                                    <span class="text-sm font-medium ml-1">100</span>
                                </div>
                            </div>
                            <div class="w-4/12 flex flex-col">
                                <span class="text-xs text-gray-dark ml-auto mb-1">Status</span>
                                <span class="text-sm font-medium text-green ml-auto mt-[2px]">Selesai</span>
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

    export default {
        name: 'App',
        components: {
            'container': Container,
            'bottom-navigation': BottomNavigation
        }
    }
</script>