<script lang="ts" setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
const currentIndex = ref(0)
const visible = ref(false)
let intervalId: number | undefined = undefined
const props = defineProps<{
    images: string[],
}>()
const next = () => currentIndex.value = (currentIndex.value + 1) % props.images.length
const prev = () => currentIndex.value = (currentIndex.value - 1 + props.images.length) % props.images.length
const carouselInfiniteScroll = () => {
    if (props.images.length) {
        currentIndex.value = currentIndex.value === props.images.length - 1 ? 0 : currentIndex.value + 1
    }
}
onMounted(() => {
    intervalId = setInterval(() => {
        carouselInfiniteScroll()
    }, 3000)
})
onBeforeUnmount(() => {
    clearInterval(intervalId)
})
</script>

<template>
    <div class="w-full mx-auto rounded-xl overflow-hidden">
        <div class="flex rounded-xl">
            <div v-for="(item, index) in images" :key="index"
                class="relative min-w-full min-h-full flex items-center justify-center"
                :style="{ transform: `translate(-${currentIndex * 100}%)` }" @mouseover="visible = true"
                @mouseout="visible = false">
                <button class="absolute md:p-2 p-0 left-0" :class="{ 'opacity-100': visible, 'opacity-0': !visible }"
                    @click="prev">
                    <div class="w-10 h-10 flex items-center justify-center bg-white rounded-full">
                        <svg class="text-slate-500 rotate-180" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" stroke="currentColor" stroke-width="2" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708" />
                        </svg>
                    </div>
                </button>
                <!-- Gunakan tag <img> untuk menampilkan gambar -->
                <img :src="item" alt="Carousel Image"
                    class="rounded-xl w-full h-full" />
                <button class="absolute md:p-2 p-0 right-0" :class="{ 'opacity-100': visible, 'opacity-0': !visible }"
                    @click="next">
                    <div class="w-10 h-10 flex items-center justify-center bg-white rounded-full">
                        <svg class="text-slate-500" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" stroke="currentColor" stroke-width="2" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708" />
                        </svg>
                    </div>
                </button>
            </div>
        </div>
    </div>
</template>
