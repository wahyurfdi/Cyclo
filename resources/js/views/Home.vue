<template>
    <container>
        <div class="h-full w-full">
            <div class="rounded-bl-[30px] rounded-br-[30px] bg-green pt-[30px] pb-5 px-[22px] relative">
                <div class="mb-[6px]">
                    <span class="text-base font-bold text-white">Peduli Sampah Bersama</span>
                </div>
                <div>
                    <p class="text-sm text-gray-light">
                        Pengolahan sampah daur ulang dalam <br> satu kali klik di manapin dan kapan pun
                    </p>
                </div>
                <div class="flex my-5">
                    <div class="flex flex-col text-white">
                        <span class="text-xs">Koin Kamu</span>
                        <div>
                            <i class="fa fa-circle text-xs text-yellow"></i>
                            <span class="text-base font-bold ml-1">1.000</span>
                        </div>
                    </div>
                    <div class="w-[1px] bg-white h-6 my-auto mx-4"></div>
                    <div class="flex flex-col text-white">
                        <span class="text-xs">Kontribusi Kamu</span>
                        <div>
                            <span class="text-base font-bold ml-1">100 Kg</span>
                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="w-10/12">
                        <button class="py-[10px] px-[14px] rounded-lg bg-yellow text-green-dark w-full flex" @click="$router.push('/web-app/request-pickup/trash-form')">
                            <span class="text-sm font-semibold my-auto">Kumpulkan Sampah Lainnya</span>
                            <i class="fa-solid fa-up-right-from-square ml-auto my-auto text-lg"></i>
                        </button>
                    </div>
                    <div class="w-2/12 flex">
                        <button class="py-[10px] px-[14px] rounded-lg bg-yellow text-green-dark flex ml-auto">
                            <i class="fa-solid fa-qrcode m-auto text-lg"></i>
                        </button>
                    </div>
                </div>

                <img src="/img/illust1.png" width="120" class="absolute top-3 right-0">
            </div>
            
            <!-- PRODUCT REDEEM -->
            <div class="flex px-[22px] mt-8">
                <span class="text-sm font-semibold">Tukarkan Koin</span>
                <span class="text-xs ml-auto my-auto text-gray-dark">Lihat Semua</span>
            </div>
            <div class="grid grid-flow-col gap-5 px-[22px] mt-4">
                <div class="grid-cols-4" v-for="(product, i) in products" :key="i">
                    <div class="w-full h-full rounded-[10px] shadow-md">
                        <div class="w-100 h-[90px] rounded-tl-[10px] rounded-tr-[10px]" :style="{'background-image': 'url('+product.image+')', 'background-size': 'cover', 'background-position': 'center'}"></div>
                        <div class="p-2">
                            <i class="fa fa-circle text-xs text-yellow"></i>
                            <span class="text-xs font-medium ml-1">{{ product.price }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END -->

            <!-- INFORMATION -->
            <div class="flex px-[22px] mt-8">
                <span class="text-sm font-semibold">Informasi Terbaru</span>
                <span class="text-xs ml-auto my-auto text-gray-dark">Lihat Semua</span>
            </div>
            <div class="grid grid-flow-col gap-5 px-[22px] mt-4">
                <div class="grid-cols-12" v-for="(information, i) in informations" :key="i">
                    <div class="w-full h-full rounded-[10px] shadow-md flex">
                        <div class="w-4/12 h-[110px] rounded-tl-[10px] rounded-bl-[10px]" :style="{'background-image': 'url('+information.image+')', 'background-size': 'cover', 'background-position': 'center'}"></div>
                        <div class="w-8/12 p-3 flex flex-col">
                            <span class="text-sm font-medium mb-1 mt-auto">{{ information.title }}</span>
                            <p class="text-xs text-gray-dark mb-auto">{{ information.description }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END -->
        </div>

        <bottom-navigation :menu-actived="1"></bottom-navigation>
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
        },
        data: function() {
            return {
                products: [
                    {
                        image: '/img/product-redeem/product-1.jpg',
                        price: 1000
                    },
                    {
                        image: '/img/product-redeem/product-2.jpg',
                        price: 500
                    },
                    {
                        image: '/img/product-redeem/product-3.webp',
                        price: 100
                    },
                ],
                informations: [
                    {
                        image: '/img/information/info-1.jpg',
                        title: 'Bijak Mengelola Sampah di Masa Libur Lebaran 2023',
                        description: 'Ada banyak persiapan untuk dilakukan menjelang perayaan Leb...'
                    }
                ]
            }
        }
    }
</script>