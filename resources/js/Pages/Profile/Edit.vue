<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-3xl space-y-8 sm:px-6 lg:px-8">
                <!-- Profile Information Section -->
                <div class="bg-white p-6 shadow-lg rounded-xl transition-all duration-300 hover:shadow-xl max-w-2xl mx-auto">
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class="max-w-xl"
                    />
                </div>

                <!-- Update Password Section -->
                <div class="bg-white p-6 shadow-lg rounded-xl transition-all duration-300 hover:shadow-xl max-w-2xl mx-auto">
                    <UpdatePasswordForm class="max-w-xl" />
                </div>

                <!-- Delete Account Section -->
                <div class="bg-white p-6 shadow-lg rounded-xl transition-all duration-300 hover:shadow-xl border border-red-100 max-w-2xl mx-auto">
                    <p class="text-gray-600 mb-6">Once your account is deleted, all of its resources and data will be permanently deleted.</p>
                    <DeleteUserForm class="max-w-xl" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.bg-white {
    background-color: #ffffff;
    transition: all 0.3s ease;
    width: 100%;
}

.bg-white:hover {
    transform: translateY(-2px);
}

/* Custom scrollbar for the page */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #555;
}

/* Smooth transitions for all interactive elements */
button, a, input, select, textarea {
    transition: all 0.2s ease-in-out;
}

/* Focus styles for better accessibility */
:focus {
    outline: 2px solid #4f46e5;
    outline-offset: 2px;
}

/* Custom styles for form sections */
.max-w-xl {
    margin: 0 auto;
    padding: 1rem;
}

/* Responsive adjustments */
@media (max-width: 640px) {
    .py-12 {
        padding-top: 1.5rem;
        padding-bottom: 1.5rem;
    }

    .p-6 {
        padding: 1rem;
    }

    .max-w-2xl {
        margin-left: 1rem;
        margin-right: 1rem;
    }
}
</style>
