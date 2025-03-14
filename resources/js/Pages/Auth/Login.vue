<script setup lang="ts">
import Checkbox from '@/Components/UI/Input/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/UI/Input/InputError.vue';
import InputLabel from '@/Components/UI/Input/InputLabel.vue';
import PrimaryButton from '@/Components/UI/Button/PrimaryButton.vue';
import TextInput from '@/Components/UI/Input/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps<{
    canResetPassword?: boolean;
    status?: string;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => {
            form.reset('password');
        },
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Log in" />
        <main class="flex justify-center items-center h-screen bg-[#F7F7F7]">
            <div class="max-w-md w-full mx-auto bg-white shadow-2xl p-6 rounded-lg space-y-8">
                <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                    {{ status }}
                </div>
                <form @submit.prevent="submit">
                    <div>
                        <InputLabel for="email" value="Email" />
    
                        <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus
                            autocomplete="username" />
    
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>
    
                    <div class="mt-4">
                        <InputLabel for="password" value="Password" />
    
                        <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required
                            autocomplete="current-password" />
    
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>
    
                    <div class="block mt-4">
                        <label class="flex items-center">
                            <Checkbox name="remember" v-model:checked="form.remember" />
                            <span class="ms-2 text-sm text-gray-600">Remember me</span>
                        </label>
                    </div>
    
                    <div class="flex items-center justify-end mt-4">
                        <Link v-if="canResetPassword" :href="route('password.request')"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Forgot your password?
                        </Link>
    
                        <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Log in
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </main>
    </GuestLayout>
</template>
