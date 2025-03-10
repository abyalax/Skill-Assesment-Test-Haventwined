<script lang="ts" setup>
import { useHead } from '@vueuse/head';
import { usePage } from '@inertiajs/vue3';
import { reactive, ref } from 'vue'
import GuestLayout from '@/Layouts/GuestLayout.vue';
import Carousel from '@/Components/Carousel/Carousel.vue';
import BannerStatis from '@/Components/Carousel/BannerStatis.vue';
import { CompanyProfile, Event } from '@/types';

const page = usePage()
const company = page.props.company_profile as CompanyProfile
const events = page.props.events as Event[]
const loading = ref(false)
const formState = reactive({
    to_name: "Abya",
    from_name: "",
    from_email: "",
    from_phone: "",
    message: "",
});
defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
    company_profile: {
        type: Object,
        required: true
    }
});
useHead({
    title: 'Haventwined',
    meta: [
        { name: 'description', content: 'Profile Haventwined Creative!' },
        { name: 'viewport', content: 'width=device-width, initial-scale=1' },
    ]
})
const handleSubmit = async () => {
    loading.value = true
    try {
        const response = await fetch('https://api.emailjs.com/api/v1.0/email/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                service_id: import.meta.env.VITE_SERVICE_ID,
                template_id: import.meta.env.VITE_TEMPLATE_ID,
                user_id: import.meta.env.VITE_USER_ID,
                template_params: formState,
            }),
        })
        console.log(response);
        if (response.ok) {
            formState.from_name = ''
            formState.from_email = ''
            formState.from_phone = ''
            formState.message = ''
        } else {
            console.log(response)
        }
    } catch (error) {
        console.error(error)
    } finally {
        loading.value = false
    }
}

</script>

<template>
    <GuestLayout :can-login="true" :can-register="true">
        <!-- Home Page -->
        <section class="md:px-32 sm:px-12 px-6 pt-20 bg-[#4e598c] h-fit">
            <div class="w-full lg:grid lg:grid-cols-4 flex flex-col justify-center items-center">
                <div class="col-span-1">
                    <h1 class="text-white text-wrap text-4xl font-semibold">Jadilah Tenant pada Event Pilihanmu dengan
                        Mudah, Cepat, dan Terpercaya.</h1>
                </div>
                <div class="col-span-3 mt-4 mb-10 h-fit rounded-xl overflow-hidden">
                    <BannerStatis :images="company.banner" />
                </div>
            </div>
        </section>

        <!-- About Company -->
        <div id="about"
            class="flex flex-col md:flex-row-reverse md:gap-y-12 gap-y-12 justify-center items-center w-full md:px-32 px-16 py-8">
            <div class=" md:w-1/2 w-full h-fit flex justify-end relative my-2">
                <img src="/images/join-us.png" alt=""
                    class="absolute lg:top-96 md:top-80 top-60 -left-2 md:h-48 h-24 sm:h-32">
                <img src="/images/guest-star.png" alt="" class="">
            </div>
            <div class="md:w-1/2 w-full md:px-4">
                <h1 style="line-height: 1;" class="text-slate-900 font-bold text-wrap md:text-[4rem] text-[2rem]">
                    Welcome To Our Company
                </h1>
                <h1 style="line-height: 1;" class="text-wrap font-bold md:text-[4rem] text-[2rem] text-yellow-500">
                    Profile 2025
                </h1>

                <p class="text-slate-900 mt-8 text-lg">
                    {{ company.description }}
                </p>
                <el-button type="warning" class="my-8" size="large">
                    Learn More
                </el-button>
            </div>

        </div>

        <!-- Events -->
        <div class="md:my-16 my-4 md:px-16 px-0 w-full">
            <div class="my-8 md:px-14">
                <h1 class="text-slate-900 lg:text-5xl sm:text-3xl text-xl my-6 text-center font-semibold">
                    Jadikan Event Berkesan & Tak Terlupakan
                </h1>
                <div class="w-3/4 mx-auto">
                    <p class="text-slate-900 text-wrap text-center md:mx-12">
                        Kami bangga telah menjadi bagian dari berbagai acara luar biasa.
                        Dari festival skala besar hingga acara privat yang intim,
                        inilah beberapa event yang telah kami sukseskan bersama para klien terbaik kami.
                    </p>
                </div>
            </div>

            <Carousel :data="events" :jump="2">
                <template #default="{ data }">
                    <div class="h-fit md:w-96 w-80 border border-slate-400 rounded-lg flex justify-center items-center flex-col overflow-hidden">
                        <div class="w-full h-64">
                            <img :src="data.url" class="object-center object-cover w-full h-full" />
                        </div>
                        <div class="w-full h-2/5 text-slate-900 p-4">
                            <h2 class="text-wrap font-bold">
                                {{ data.name.length > 30 ? data.name.substring(0, 30) + '...' :
                                    data.name }}
                            </h2>
                            <div class="mt-2 mb-5">
                                <p class="text-slate-900">{{ data.event_start }} - {{ data.event_end }}
                                </p>
                                <p class="text-slate-900">{{ data.location }}</p>
                            </div>
                            <p class="mt-4 text-slate-900">{{ data.estimated_visitors }}+ orang</p>
                        </div>
                    </div>
                </template>
            </Carousel>

        </div>

        <section>
            <h2 class="text-slate-900 lg:text-5xl sm:text-3xl text-xl my-2 text-center font-semibold">
                Contact With Our Team
            </h2>
            <div id="contact" class="md:px-44 lg:flex lg:flex-row md:flex md:gap-16 flex flex-col mb-20">

                <div class="w-full text-slate-900 px-12 flex flex-col justify-between">
                    <h2 class="sm:text-3xl text-lg my-6 font-semibold mb-4 ">Let's Get in Touch with us
                    </h2>
                    <p class="mt-4 sm:mb-12 mb-2 text-slate-900">
                        Hubungi kami hari ini untuk konsultasi gratis dan mulailah perjalanan menuju event sukses
                    </p>
                    <table>
                        <tbody>
                            <tr>
                                <td class="pr-7 font-semibold sm:my-2 sm:text-lg text-sm">Address</td>
                                <td>
                                    <p class="text-slate-900 text-sm sm:text-base flex gap-2 items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6" />
                                        </svg>
                                        {{ company.location }}
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td class="pr-7 font-semibold sm:my-2 sm:text-lg text-sm">Phone</td>
                                <td class="text-slate-900 text-sm sm:text-base flex gap-2 items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                        class="bi bi-telephone-inbound" viewBox="0 0 16 16">
                                        <path
                                            d="M15.854.146a.5.5 0 0 1 0 .708L11.707 5H14.5a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5v-4a.5.5 0 0 1 1 0v2.793L15.146.146a.5.5 0 0 1 .708 0m-12.2 1.182a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.6 17.6 0 0 0 4.168 6.608 17.6 17.6 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.68.68 0 0 0-.58-.122l-2.19.547a1.75 1.75 0 0 1-1.657-.459L5.482 8.062a1.75 1.75 0 0 1-.46-1.657l.548-2.19a.68.68 0 0 0-.122-.58zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z" />
                                    </svg>
                                    {{ company.whatsapp }}
                                </td>
                            </tr>

                            <tr>
                                <td class="pr-7 font-semibold sm:my-2 sm:text-lg text-sm ">Email</td>
                                <td class="text-slate-900 text-sm sm:text-base flex gap-2 items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                        stroke-width=".8" class="bi bi-envelope" viewBox="0 0 16 16">
                                        <path
                                            d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z" />
                                    </svg>
                                    {{ company.email }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <p class="mt-4 sm:mb-12 mb-2 text-slate-900 text-balance">
                        Kami mengubah setiap acara menjadi pengalaman istimewa melalui perencanaan yang matang dan
                        sentuhan
                        profesional. Temukan bagaimana Haventwined bisa membantu Anda mewujudkan event impian!
                    </p>
                </div>

                <div class="text-slate-900 rounded-xl md:w-full md:mx-0 mx-12">
                    <form class="flex flex-col gap-6 sm:p-10 p-6" @submit.prevent="handleSubmit">
                        <input
                            class="min-h-11 bg-transparent focus:outline-none border-b-2 border-slate-500 appearance-none rounded-lg"
                            name="name" type="text" placeholder="Your Name" v-model="formState.from_name" />
                        <input
                            class="min-h-11 bg-transparent focus:outline-none border-b-2 border-slate-500 appearance-none rounded-lg"
                            type="email" name="email" placeholder="Your Email" v-model="formState.from_email" />
                        <input
                            class="min-h-11 bg-transparent focus:outline-none border-b-2 border-slate-500 appearance-none rounded-lg"
                            type="number" min="9" name="phone" placeholder="Your Phone"
                            v-model="formState.from_phone" />
                        <textarea
                            class="bg-transparent focus:outline-none border-b-2 border-slate-500 appearance-none rounded-lg"
                            name="message" placeholder="Messages..." v-model="formState.message" />
                        <button
                            class="hover:bg-slate-700 bg-slate-600 text-white font-semibold text-lg px-11 py-3 rounded-md disabled:cursor-not-allowed"
                            type="submit" :disabled="loading">
                            {{ loading ? 'Sending...' : 'Send' }}
                        </button>

                    </form>
                </div>
            </div>
        </section>
    </GuestLayout>
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}

@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>
