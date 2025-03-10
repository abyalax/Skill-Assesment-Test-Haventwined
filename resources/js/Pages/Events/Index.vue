<script lang="ts" setup>
import { ref, reactive, computed, onMounted, shallowRef } from 'vue';
import { debouncedWatch } from '@vueuse/core';
import { EventPagination } from '@/types';
import { formatDate } from '@/utils';
import { usePage } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import Pagination from '@/Components/UI/Pagination.vue';
import Dropdown from '@/Components/Dropdown/Dropdown.vue';
import XSquare from '@/Components/Icons/XSquare.vue';
import Modal from '@/Components/UI/Modal.vue';
import DatabaseConf from '@/Components/Icons/DatabaseConf.vue';

const page = usePage()
console.log(page.props);
const openFilter = ref(false)
const isDropdownOpen = ref(false)
const eventPagination = page.props.events as EventPagination
const uniqueFields = shallowRef<{ themes: string[], categories: string[], locations: string[] }>({ themes: [], categories: [], locations: [] });
const options = [
    { label: 'Newest Events', value: 'newest_events' },
    { label: 'Nearby Event Registration', value: 'nearby_events' },
    { label: 'Most Estimated Visitors', value: 'most_estimated_visitors' },
]
onMounted(async function () {
    console.log('🔄️ Fetching unique fields...');
    const res = await fetch('/api/event/unique', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    });
    uniqueFields.value = await res.json();
    console.log('✅ Unique Fields:', uniqueFields.value);
});
const events = computed(() => {
    return {
        data: eventPagination.data ?? [],
        links: eventPagination.links ?? []
    };
});
const form = reactive({
    search: '',
    page: eventPagination.current_page ?? 1,
    perPage: eventPagination.per_page ?? 10,
    sort: '',
})
const formFilter = reactive({
    themes: Array.isArray(uniqueFields.value.themes) ? uniqueFields.value.themes : [] as string[],
    categories: Array.isArray(uniqueFields.value.categories) ? uniqueFields.value.categories : [] as string[],
    sort: '',
    status: '',
    location: '',
})
debouncedWatch(() => form.search, () => {
    router.get(route('event.index'), form, {
        preserveState: false,
        preserveScroll: true
    })
}, { debounce: 800 });
const onSubmit = () => {
    console.log('⚡submit!');
    openFilter.value = false
    router.post(route('event.index'), formFilter, {
        preserveState: false,
        preserveScroll: true
    });
    console.log(page.props);
}
const onReset = () => {
    formFilter.themes = []
    formFilter.categories = []
    formFilter.sort = ''
    formFilter.status = ''
    formFilter.location = ''
}
const handlePageSize = () => {
    form.perPage = form.perPage === 10 ? 20 : 10
    console.log(form);
    router.get('/event', form, {
        preserveState: false,
        preserveScroll: true
    })
}
</script>

<template>
    <GuestLayout>
        <section class="pt-20">
            <div class="flex px-[6%] justify-between w-full h-fit">
                <div class="h-12 flex">
                    <input
                        class="py-2 h-11 focus:outline-none border-b-2 border-slate-500 focus:border-slate-700 appearance-none rounded-tl rounded-bl"
                        type="text" placeholder="Search here..." v-model="form.search" />
                    <div class="bg-slate-400 rounded-tr rounded-br flex justify-center items-center w-10 h-11">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" class="bi bi-search"
                            viewBox="0 0 16 16">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                        </svg>
                    </div>
                </div>

                <div class="flex gap-4">
                    <span class="inline-flex rounded-md gap-4">
                        <el-button size="large" style="font-size: 1rem;" type="default"
                            @click="router.get('/event', {}, { preserveState: false })">
                            <XSquare :height="18" :width="18" class="mr-2"/>
                            Reset
                        </el-button>
                        <el-button size="large" style="font-size: 1rem;" type="default" @click="handlePageSize">
                            <DatabaseConf :height="18" :width="18" class="mr-2"/>
                            Page Size ( {{ form.perPage }} )
                        </el-button>
                        <el-button size="large" style="font-size: 1rem;" type="default"
                            @click="openFilter = !openFilter">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                stroke="currentColor" stroke-width=".8" class="bi bi-sliders2 mr-2"  viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M10.5 1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4H1.5a.5.5 0 0 1 0-1H10V1.5a.5.5 0 0 1 .5-.5M12 3.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5m-6.5 2A.5.5 0 0 1 6 6v1.5h8.5a.5.5 0 0 1 0 1H6V10a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5M1 8a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2A.5.5 0 0 1 1 8m9.5 2a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V13H1.5a.5.5 0 0 1 0-1H10v-1.5a.5.5 0 0 1 .5-.5m1.5 2.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5" />
                            </svg>
                            Filter
                        </el-button>
                        <Dropdown align="right" width="60" @toggle="isDropdownOpen = $event"
                            :content-classes="'bg-white py-1 text-nowrap flex flex-col justify-center items-center'">
                            <template #trigger>
                                <span class="inline-flex rounded-md">
                                    <el-button size="large" style="font-size: 1rem;" type="default"
                                        class="px-4 py-2 text-nowrap flex gap-4 justify-between items-center rounded-lg cursor-pointer bg-transparent border-2 border-slate-500 hover:border-slate-300 text-slate-200 hover:text-white"
                                        @click="$emit('toggleDropdown')">
                                        Sort Events
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor"
                                            :class="`bi bi-chevron-up ${isDropdownOpen ? '' : 'rotate-180'}`"
                                            viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708z" />
                                        </svg>
                                    </el-button>
                                </span>
                            </template>
                            <template #content>
                                <div v-for="option in options" :key="option.value" class="overflow-hidden w-full">
                                    <button
                                        @click="router.get('/event', { ...form, sort: option.value }, { preserveState: false })"
                                        class="px-2 py-0.5 w-full hover:bg-slate-300">
                                        {{ option.label }}
                                    </button>
                                </div>
                            </template>
                        </Dropdown>
                    </span>

                </div>

                <Modal :show="openFilter" @close="openFilter = false">
                    <div class="flex flex-col justify-center gap-6 items-center h-fit p-8">
                        <h1 class="text-2xl font-semibold">Modal untuk Filtering</h1>
                        <el-form :model="formFilter" label-width="auto" style="max-width: 600px">
                            <el-form-item label="Status">
                                <el-radio-group v-model="formFilter.status">
                                    <el-radio value="active">Event Aktif</el-radio>
                                    <el-radio value="passive">Event Lalu</el-radio>
                                </el-radio-group>
                            </el-form-item>
                            <el-form-item label="Categories">
                                <el-checkbox-group v-model="formFilter.categories"
                                    v-for="category in uniqueFields.categories" :key="category">
                                    <el-checkbox :value="category" :name="category" class="pr-6">
                                        {{ category }}
                                    </el-checkbox>
                                </el-checkbox-group>
                            </el-form-item>
                            <el-form-item label="Themes">
                                <el-checkbox-group v-model="formFilter.themes" v-for="theme in uniqueFields.themes"
                                    :key="theme">
                                    <el-checkbox :value="theme" :name="theme" class="pr-6">
                                        {{ theme }}
                                    </el-checkbox>
                                </el-checkbox-group>
                            </el-form-item>
                            <el-form-item label="Location">
                                <el-select v-model="formFilter.location" placeholder="Select where events">
                                    <div v-for="location in uniqueFields.locations" :key="location">
                                        <el-option :label="location" :value="location" />
                                    </div>
                                </el-select>
                            </el-form-item>
                            <el-form-item>
                                <el-button type="primary" @click="onSubmit">Filter</el-button>
                                <el-button type="warning" @click="onReset">Reset</el-button>
                                <el-button @click="openFilter = false">Cancel</el-button>
                            </el-form-item>
                        </el-form>
                    </div>
                </Modal>
            </div>

            <div v-if="events.data" class="flex flex-wrap gap-4 justify-center items-center px-[6%] my-14">

                <div v-for="event in events.data" :key="event.id.toString()">

                    <div @click="router.visit(route('event.show', event.id))"
                        class="xl:h-[26rem] xl:w-80 lg:w-72 lg:h-[24rem] md:h-[24rem] sm:h-[24rem] w-72 h-[24rem] relative group my-4 border border-slate-500 hover:bg-[#4e598c] hover:text-white cursor-pointer rounded-lg flex justify-center items-center flex-col overflow-hidden">
                        <div class="w-full h-3/5">
                            <img :src="event.url" class="object-center object-cover w-full h-full" />
                            <div className="absolute inset-0 bg-[#4e598c]/40 opacity-0 group-hover:opacity-100"></div>
                        </div>
                        <div class="w-full h-2/5 px-4 pb-6 pt-2">
                            <p class="text-xs">{{ event.category }}</p>
                            <h2 class="text-wrap font-bold text-xl">
                                {{ event.name.length > 30 ? event.name.substring(0, 30) + '...' : event.name }}
                            </h2>
                            <div class="mt-2 mb-5">
                                <p>
                                    {{ formatDate(event.event_start) }} - {{ formatDate(event.event_end) }}
                                </p>
                                <p>{{ event.location }}</p>
                            </div>
                            <p class="mt-2 ">{{ event.estimated_visitors }}+ orang</p>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="flex justify-center items-center w-full">
                <h2 class="text-2xl font-semibold">No Events available</h2>
            </div>

            <div class="w-full flex justify-center items-center my-14">
                <Pagination :links="events.links" />
            </div>

        </section>
    </GuestLayout>
</template>