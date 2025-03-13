<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Event } from '@/types';
import { usePage } from '@inertiajs/vue3';
import Table from '@/Components/Table/Table.vue';
import { columns } from '@/Components/Table/Columns';

const page = usePage();
const events = page.props.events as Event[]
console.log(events);


</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h1 class="text-xl font-bold">Manage Events</h1>
        </template>
        <main class="p-8">
            <div class="mx-auto w-fit bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <Table :data="events" :columns="columns"/>
            </div>
        </main>
    </AuthenticatedLayout>
</template>