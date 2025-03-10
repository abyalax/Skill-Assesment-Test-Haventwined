<script lang="ts" setup>
import { CompanyProfile, UploadWidgetCallback, UploadWidgetInstance } from '@/types';
import { useForm, usePage } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const page = usePage();
const company = page.props.company_profile as CompanyProfile
const uploadWidget = ref<UploadWidgetInstance | null>(null);
const dataState = useForm({
    id: company.id,
    name: company.name,
    description: company.description,
    email: company.email,
    whatsapp: company.whatsapp,
    banner: [...company.banner],
});
const handlerSubmit = () => {
    console.log('State to be submit ', dataState);

    if (dataState.banner.length === 0) {
        alert("Please upload an image or wait a minute");
        return;
    }
    dataState.put(`/dashboard/update/${dataState.id}`, {
        onSuccess: () => alert("Success to update company profile"),
        onError: (errors) => {
            console.error("Update failed:", errors);
            alert("Failed to update company profile. Check the console for details.");
        }
    });
};
onMounted(() => {
    if (window.cloudinary) {
        uploadWidget.value = window.cloudinary.createUploadWidget({
            cloudName: 'dllhxulpv',
            uploadPreset: 'haventwined',
            multiple: true,
            folder: 'haventwined',
            maxFiles: 10,
        }, handleUpload);
    }
});
const openUploadWidget = () => {
    if (uploadWidget.value) {
        uploadWidget.value.open();
    } else {
        console.log('Cloudinary is not loaded yet');
    }
};
const handleUpload: UploadWidgetCallback = async (err, result) => {
    if (result.event === "success") {
        console.log("Upload berhasil:", result.info.secure_url);
        dataState.banner = [...dataState.banner, result.info.secure_url];
    } else {
        console.log("Upload gagal:", err);
    }
};
const removeBanner = (event: Event, index: number) => {
    event.preventDefault();
    dataState.banner.splice(index, 1);
};
const resetForm = () => {
    dataState.reset();
};
</script>

<template>

        <AuthenticatedLayout >

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manage Company Profile</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto -mt-4 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form @submit.prevent="handlerSubmit" class="w-full flex flex-col gap-2 justify-center items-center">
                    <div class="flex flex-col items-center justify-center md:mx-28 lg:mx-32">
                        <div class="flex flex-col w-full">
                            <label class="mt-1 text-sm font-normal">Name</label>
                            <input v-model="dataState.name" type="text"
                                class="border border-gray-400 w-full px-2 py-1 focus:outline-none focus:ring-1 focus:ring-blue-400 rounded-lg" />
                        </div>

                        <div class="flex flex-col w-full">
                            <label class="mt-1 text-sm font-normal">Description</label>
                            <textarea v-model="dataState.description" type="text" spellcheck="false"
                                class="border border-gray-400 w-full min-h-32 px-2 py-1 focus:outline-none focus:ring-1 focus:ring-blue-400 rounded-lg" />
                        </div>
                        <div class="flex flex-col w-full">
                            <label class="mt-1 text-sm font-normal">Email</label>
                            <input v-model="dataState.email" type="email"
                                class="border border-gray-400 w-full px-2 py-1 focus:outline-none focus:ring-1 focus:ring-blue-400 rounded-lg" />
                        </div>
                        <div class="flex flex-col w-full">
                            <label class="mt-1 text-sm font-normal">Whatsapp</label>
                            <input v-model="dataState.whatsapp" type="number"
                                class="border border-gray-400 w-full px-2 py-1 focus:outline-none focus:ring-1 focus:ring-blue-400 rounded-lg" />
                        </div>

                        <div class="my-3 flex flex-col justify-center items-center">
                            <div class="mt-3 flex gap-3 flex-wrap justify-center">
                                <div v-for="(image, index) in dataState.banner" :key="index"
                                    class="relative group sm:mx-auto sm:w-full md:w-4/5 lg:w-2/5 h-fit md:mx-0 rounded-lg">
                                    <img :src="image" alt="Banner Image" class="w-full h-full object-cover rounded-lg">
                                    <button @click="removeBanner($event, index)"
                                        class="absolute top-0 right-0 bg-red-500 text-white text-xs p-2 rounded-full opacity-0 group-hover:opacity-100 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white"
                                            stroke="white" stroke-width="2" class="bi bi-x-lg" viewBox="0 0 16 16">
                                            <path
                                                d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-start items-center gap-2 mt-4">
                            <el-button type="primary" @click="openUploadWidget">
                                <svg xmlns="http://www.w3.org/2000/svg" style="margin-right: 10px;" width="20" height="20" fill="currentColor"
                                    className="bi bi-cloud-arrow-up" viewBox="0 0 16 16">
                                    <path fillRule="evenodd"
                                        d="M7.646 5.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708z" />
                                    <path
                                        d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383m.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z" />
                                </svg>
                                Upload Banner
                            </el-button>
                            <el-button type="success">
                                Submit
                            </el-button>
                            <el-button type="default" @click="resetForm">
                                Cancel
                            </el-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>