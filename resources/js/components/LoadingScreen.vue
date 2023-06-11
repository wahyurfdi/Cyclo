<template>
    <div class="w-full h-full bg-black bg-opacity-20 absolute top-0 left-0 flex" :class="[isShow ? '' : 'hidden']">
        <div class="w-[70px] h-[70px] border-8 border-t-white border-r-white border-l-white border-b-gray rounded-full m-auto animate-spin"></div>
    </div>
</template>

<script>
    export default {
        props: {
            isShow: {
                type: Boolean,
                default: false
            }
        }   
    }
</script>