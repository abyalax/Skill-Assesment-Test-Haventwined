<script lang="ts" setup>
import { Link } from '@inertiajs/vue3';
const props = defineProps({
    links: Array<{ url: string, label: string, active: boolean }>
})
</script>

<template>

    <div v-if="props.links">
        <div class="flex flex-wrap -mb-1">

            <template v-for="(link, index) in props.links" :key="index">

                <div v-if="link.url === null" class="mr-1 mb-1 px-4 py-3 text-lg text-slate-300 font-semibold leading-4 border-2 border-slate-500 rounded-lg"
                    v-html="link.label"></div>

                <Link v-else
                    class="mr-1 mb-1 px-4 py-3 text-slate-400 leading-4 border-2 font-semibold text-lg border-slate-500 rounded-lg hover:bg-slate-900 hover:text-white focus:outline-none focus:bg-white"
                    :href="link.url" :class="{ 'text-black font-bold bg-white': link.active }">
                    <span v-html="link.label"></span>
                </Link>
            </template>
        </div>
    </div>

</template>
