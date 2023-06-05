<template>
    <div class="w-full h-full rounded-[10px] shadow-md flex">
        <div class="w-4/12 h-full rounded-[10px]" :style="{'background-image': 'url('+image+')', 'background-size': 'cover', 'background-position': 'center'}"></div>
        <div class="w-8/12 p-4 flex flex-col">
            <span class="text-sm font-medium mb-1">{{ title }}</span>
            <p class="text-xs text-gray-dark mb-3">{{ description }}</p>
            <div class="w-full flex">
                <div class="my-auto">
                    <i class="fa fa-circle text-xs text-yellow"></i>
                    <span class="text-xs font-medium ml-1">{{ coin }}</span>
                </div>
                <div class="my-auto ml-auto">
                    <slot></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            image: {
                default: '',
                type: String
            },
            title: {
                default: '',
                type: String
            },
            description: {
                default: '',
                type: String
            },
            coin: {
                default: 0,
                type: Number
            }
        }
    }
</script>