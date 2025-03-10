<script lang="ts" setup>
import { ref, onMounted, onUnmounted } from 'vue'

const props = withDefaults(
    defineProps<{
        data?: Array<any> | [];
        jump?: number;
    }>(),
    {
        data: () => [], 
        jump: 2,
    }
);


let interval: number | undefined = 0
const currentIndex = ref(0)
const visible = ref(false)
const prevSlide = () => { currentIndex.value = (currentIndex.value - props.jump + props.data.length) % props.data.length }
const nextSlide = () => { currentIndex.value = (currentIndex.value + props.jump) % props.data.length }
onMounted(() => {
    interval = setInterval(() => {
        currentIndex.value = (currentIndex.value + 1) % props.data.length;
    }, 5000);
});

onUnmounted(() => {
    clearInterval(interval); // Bersihkan interval agar tidak berjalan terus-menerus saat komponen di-unmount
});

</script>

<template>
    <div class="md:w-[80vw] mx-auto w-[90vw]">
        <div class="relative w-full rounded-2xl md:px-16 px-6 py-2 overflow-hidden" @mouseover="visible = true"
            @mouseout="visible = false">

            <div class="flex flex-nowrap overflow-hidden">

                <div class="p-6 flex" :style="{
                    transform: `translateX(-${currentIndex * (100 / props.data.length)}%)`,
                    transition: 'transform 0.5s ease-in-out'
                }">

                    <div v-for="(item, index) in props.data" :key="index"
                        class="w-full px-2 flex items-center justify-center">

                        <slot :data="item"></slot>

                    </div>
                </div>
            </div>

            <!-- Tombol Navigasi Sebelumnya -->
            <button class="absolute left-4 top-1/2 transform -translate-y-1/2 transition-opacity duration-600"
                :class="{ 'opacity-100': visible, 'opacity-0': !visible }" @click="prevSlide"
                :style="{ 'pointer-events': visible ? 'auto' : 'none' }">
                <div class="w-8 h-8 flex items-center justify-center bg-white rounded-full shadow">
                    <svg class="text-slate-500 rotate-180" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                        fill="currentColor" stroke="currentColor" stroke-width="2" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708" />
                    </svg>
                </div>
            </button>

            <!-- Tombol Navigasi Berikutnya -->
            <button class="absolute right-4 top-1/2 transform -translate-y-1/2 transition-opacity duration-600"
                :class="{ 'opacity-100': visible, 'opacity-0': !visible }" @click="nextSlide"
                :style="{ 'pointer-events': visible ? 'auto' : 'none' }">
                <div class="w-8 h-8 flex items-center justify-center bg-white rounded-full shadow">
                    <svg class="text-slate-500" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                        fill="currentColor" stroke="currentColor" stroke-width="2" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708" />
                    </svg>
                </div>
            </button>
        </div>
    </div>
</template>
