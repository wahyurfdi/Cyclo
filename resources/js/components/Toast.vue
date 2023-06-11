<template>
    <div v-show="isShow" class="w-full max-w-[512px] fixed flex top-0 pt-6 px-6 mx-auto">
        <div class="w-full mx-auto flex">
            <div class="w-full flex">
                <div class="w-full py-4 px-4 rounded-lg flex shadow-sm mx-auto bg-slate-600 animate__animated animate__slideInDown">
                    <span class="text-white text-[14px]">{{ message }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import 'animate.css';

    export default {
        props: {
            isShow: {
                type: Boolean,
                default: false
            },
            message: {
                type: String,
                default: ''
            }
        }
    }
</script>

<style scoped>
    .animate__animated.animate__slideInDown {
        --animate-duration: 0.5s;
    }
</style>