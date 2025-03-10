<script lang="ts" setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import Footer from '@/Components/UI/Footer.vue';

const props = usePage().props
const user = props.auth.user

const showingNavigationDropdown = ref(false);
</script>

<template>
    <section class="min-h-screen">
        <!-- Navigation Bar -->
        <nav class="bg-[#4e598c] text-white fixed top-0 left-0 right-0 z-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <Link href="/">
                    <img src="/images/logo.png" alt="Logo" class="w-32 md:w-52">
                    </Link>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden sm:flex items-center space-x-4 relative">
                    <Link :href="route('event.index')">Events</Link>
                    <Link href="/#about">About</Link>
                    <Link href="/#contact">Contact</Link>
                    <template v-if="user">
                        <!-- Jika sudah login -->
                        <template v-if="user.role === 'admin'">
                            <Link href="/dashboard">Dashboard</Link>
                        </template>
                    </template>

                    <template v-else>
                        <!-- Jika belum login -->
                        <Link class="absolute -right-60 text-white" href="/login">Login</Link>
                    </template>
                </div>

                <!-- Hamburger (Mobile) -->
                <div class="sm:hidden">
                    <button @click="showingNavigationDropdown = !showingNavigationDropdown"
                        class="p-2 rounded-md focus:outline-none focus:bg-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path v-if="!showingNavigationDropdown" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation Dropdown -->
            <div :class="showingNavigationDropdown ? 'block' : 'hidden'" class="sm:hidden bg-[#4e598c]">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <template v-if="props.canLogin">
                        <template v-if="user">
                            <Link :href="route('dashboard')" class="block px-3 py-2 rounded-md text-base font-medium text-white">
                            Dashboard
                            </Link>
                        </template>
                        <template v-else>
                            <Link :href="route('event.index')" class="block px-3 py-2 rounded-md text-base font-medium text-white">
                            Events
                            </Link>
                            <Link href="/#about" class="block px-3 py-2 rounded-md text-base font-medium text-white">
                            About
                            </Link>
                            <Link href="/#contact" class="block px-3 py-2 rounded-md text-base font-medium text-white">
                            Contact
                            </Link>
                            <Link :href="route('login')" class="block px-3 py-2 rounded-md text-base font-medium text-white">
                            Log in
                            </Link>
                            <!-- <Link v-if="canRegister" href="/register"
                                class="block px-3 py-2 rounded-md text-base font-medium text-white">
                            Register
                            </Link> -->
                        </template>
                    </template>
                </div>
            </div>
        </nav>

        <!-- Content (dengan padding agar tidak tertutup navbar) -->
        <main class="">
            <slot />
        </main>

        <Footer />

    </section>
</template>
