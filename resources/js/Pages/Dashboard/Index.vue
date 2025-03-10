<script lang="ts" setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BannerInteractive from '@/Components/Carousel/BannerInteractive.vue';
import { CompanyProfile } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';

const page = usePage();
const company = page.props.company_profile as CompanyProfile

</script>

<template>

    <Head title="Dashboard" />

        <AuthenticatedLayout >

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-gray-900">Halo {{ page.props.auth.user.name }}, You're logged in!</p>

                    <BannerInteractive :images="company.banner"/>

                    <h1 class="text-xl font-bold my-4">Detail Company Profile</h1>
                    <table class="min-w-full border-collapse border border-slate-300 rounded-lg">
                        <tbody>
                            <tr class="border-b border-slate-300">
                                <th class="px-4 py-2 text-left">Name</th>
                                <td class="px-4 py-2">: {{ company.name }}</td>
                            </tr>
                            <tr class="border-b border-slate-300">
                                <th class="px-4 py-2 text-left">Description</th>
                                <td class="px-4 py-2">: {{ company.description }} </td>
                            </tr>
                            <tr class="border-b border-slate-300">
                                <th class="px-4 py-2 text-left">Email</th>
                                <td class="px-4 py-2">: {{ company.email }}</td>
                            </tr>
                            <tr>
                                <th class="px-4 py-2 text-left">Whatsapp</th>
                                <td class="px-4 py-2">: {{ company.whatsapp }}</td>
                            </tr>
                            <tr>
                                <th class="px-4 py-2 text-left">Location</th>
                                <td class="px-4 py-2">: {{ company.location }}</td>
                            </tr>
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
