<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Event } from '@/types';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const events = page.props.events as Event[]
console.log(events);

</script>

<template>
        <AuthenticatedLayout>
        <h1 class="text-xl font-bold my-6">Ini halaman events</h1>
        <pre class="text-wrap">{{ events }}</pre>
    </AuthenticatedLayout>
</template>