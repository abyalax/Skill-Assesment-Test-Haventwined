<script lang="ts" setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
const currentIndex = ref(0)
const visible = ref(false)
let intervalId: number | undefined = undefined
const props = defineProps<{
    images: string[],
}>()
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
        <div class="flex rounded-xl overflow-hidden">
            <div v-for="(item, index) in images" :key="index"
                class="relative min-w-full min-h-full flex items-center justify-center"
                :style="{ transform: `translate(-${currentIndex * 100}%)` }" @mouseover="visible = true"
                @mouseout="visible = false">
                <!-- Gunakan tag <img> untuk menampilkan gambar -->
                <img :src="item" alt="Carousel Image" class="rounded-xl lg:min-h-72 md:min-h-60 sm:min-h-56 w-fit object-cover object-center" />
            </div>
        </div>
    </div>
</template>
