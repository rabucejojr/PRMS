<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Reset Password" />

        <div class="max-w-md mx-auto">
            <!-- Header -->
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Reset your password</h2>
                <p class="mt-2 text-sm text-gray-600">
                    Enter your new password below to reset your account password.
                </p>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <div>
                    <InputLabel for="email" value="Email Address" class="text-sm font-medium text-gray-700" />

                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-50"
                        v-model="form.email"
                        required
                        autofocus
                        autocomplete="username"
                        readonly
                    />

                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div>
                    <InputLabel for="password" value="New Password" class="text-sm font-medium text-gray-700" />

                    <TextInput
                        id="password"
                        type="password"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        v-model="form.password"
                        required
                        autocomplete="new-password"
                        placeholder="Enter your new password"
                    />

                    <InputError class="mt-2" :message="form.errors.password" />

                    <!-- Password requirements -->
                    <div class="mt-2 text-xs text-gray-500">
                        Password must be at least 8 characters long.
                    </div>
                </div>

                <div>
                    <InputLabel
                        for="password_confirmation"
                        value="Confirm New Password"
                        class="text-sm font-medium text-gray-700"
                    />

                    <TextInput
                        id="password_confirmation"
                        type="password"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        v-model="form.password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="Confirm your new password"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.password_confirmation"
                    />
                </div>

                <div>
                    <PrimaryButton
                        class="w-full justify-center py-3 text-base font-medium bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500"
                        :class="{ 'opacity-50 cursor-not-allowed': form.processing }"
                        :disabled="form.processing"
                    >
                        <svg v-if="form.processing" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        {{ form.processing ? 'Resetting Password...' : 'Reset Password' }}
                    </PrimaryButton>
                </div>

                <div class="text-center">
                    <Link
                        :href="route('login')"
                        class="text-sm text-indigo-600 hover:text-indigo-500 font-medium"
                    >
                        Back to login
                    </Link>
                </div>
            </form>
        </div>
    </GuestLayout>
</template>
