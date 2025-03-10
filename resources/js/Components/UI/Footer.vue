<script lang="ts" setup>
import { Link } from '@inertiajs/vue3';

</script>
<template>
    <footer class="bg-[#4e598c] text-white flex gap-5 flex-col justify-between lg:px-40 md:px-32 px-14 pt-8">
        <Link href="/" class="mb-4">
        <img src="/images/logo.png" alt="Logo" class="w-80">
        </Link>
        <div class="md:grid md:grid-cols-8 flex flex-col gap-6 w-full">

            <div class="md:col-span-5 flex-1">
                <h1 class="font-semibold text-xl md:mb-8 mb-4">Hubungi Kami</h1>
                <div class="md:grid md:grid-rows-2 md:gap-4 flex flex-col gap-2">
                    <div class="row-span-1 flex gap-3">
                        <img src="/images/mail.png" alt="" class="w-16 h-14 object-cover object-center">
                        <div>
                            <h1>Email</h1>
                            <h1>admin@haventwined.com</h1>
                        </div>
                    </div>
                    <div class="row-span-1 flex gap-3">
                        <img src="/images/whatsapp.webp" alt="" class="w-16 h-14 object-cover object-center">
                        <div>
                            <h1>WhatsApp Customer Service</h1>
                            <h1>+62 822-9944-9708</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="md:col-span-2 flex-1">
                <h1 class="font-semibold text-xl md:mb-8 mb-4">Jelajahi Event</h1>
                <div class="md:grid md:grid-rows-3 md:gap-6 flex flex-col gap-2">
                    <div class="row-span-1">Festival - Fair - Bazaar</div>
                    <div class="row-span-1">Exhibition - Expo - Pameran</div>
                    <div class="row-span-1">Pensi - Acara Sekolah - Acara Kampus</div>
                </div>
            </div>
            <div class="md:col-span-1 flex-1">
                <h1 class="font-semibold text-xl md:mb-8 mb-4">Dukungan</h1>
                <div class="md:grid md:grid-rows-3 md:gap-6 flex flex-col gap-2">
                    <div class="row-span-1">FAQ</div>
                    <div class="row-span-1">Kebijakan Privasi</div>
                    <div class="row-span-1">Syarat & Ketentuan</div>
                </div>
            </div>

        </div>
        <div class="flex justify-center items-center text-white w-full py-8 border-t border-white mt-8">
            <p>© 2025 <b className="text-green-600">AbyaLaxx</b> All Rights Reserved, Inc</p>
        </div>
    </footer>
</template>