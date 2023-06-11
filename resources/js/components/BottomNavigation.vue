<template>
    <div class="bg-white p-[10px] shadow-navigation w-full max-w-[512px] fixed bottom-0 mx-auto rounded-tl-[20px] rounded-tr-[20px] grid grid-flow-col">
        <div v-for="(menu, i) in menus" :key="i" class="flex flex-col text-xs grid-cols-4" @click="$router.push(menu.action)">
            <i :class="[menu.icon, menuActived == menu.id ? 'text-green' : 'text-gray']" class="text-2xl mt-auto mx-auto mb-1"></i>
            <span class="text-xs mb-auto mx-auto" :class="[menuActived == menu.id ? 'text-green font-bold' : 'text-gray font-medium']">{{ menu.name }}</span>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            menuActived: {
                type: Number,
                default: 1
            }
        },
        data: function() {
            return {
                menus: [
                    {
                        id: 1,
                        icon: 'fas fa-house',
                        name: 'Home',
                        action: '/web-app/home'
                    },
                    {
                        id: 2,
                        icon: 'fas fa-trash-restore-alt',
                        name: 'History',
                        action: '/web-app/history'
                    },
                    {
                        id: 3,
                        icon: 'fas fa-user',
                        name: 'Profile',
                        action: '/web-app/profile'
                    }
                ]
            }
        }
    }
</script>

<style scoped>
    .shadow-navigation {
        box-shadow: 0px 0px 4px rgba(0, 0, 0, 0.15);
    }
</style>