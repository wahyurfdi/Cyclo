<template>
    <container>
        <div class="h-full w-full py-8 px-6 flex flex-col">
            <img src="/img/logo.png" class="w-[124px] mt-auto mb-11 mx-auto">
            <input type="text" class="bg-gray-light rounded-[10px] py-3 px-[14px] text-sm w-full mb-3" placeholder="Masukan username">
            <input type="password" class="bg-gray-light rounded-[10px] py-3 px-[14px] text-sm w-full mb-7" placeholder="Masukan password">
            <button class="mb-auto py-3 px-4 rounded-[10px] bg-[#609966] text-left flex" @click="$router.push('/web-app/home')">
                <span class="font-semibold text-white text-sm">Login</span>
                <i class="fa fa-chevron-right text-yellow text-base ml-auto my-auto"></i>
            </button>
        </div>
    </container>
</template>

<script>
    import Container from './../components/Container.vue'

    export default {
        name: 'App',
        components: {
            'container': Container
        }
    }
</script>