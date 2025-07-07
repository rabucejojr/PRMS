<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

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
    pressReleases: {
        type: Array,
        default: () => []
    }
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}

function formatDate(date) {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
}

function stripHtml(html) {
    if (!html) return '';
    const tmp = document.createElement('DIV');
    tmp.innerHTML = html;
    return tmp.textContent || tmp.innerText || '';
}
</script>

<template>
    <Head title="Press Release Management System" />
    <div class="min-h-screen bg-gray-50">
        <div class="relative">
            <!-- Header -->
            <header class="bg-white shadow-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center py-4 sm:py-6">
                        <div class="flex items-center">
                            <!-- <ApplicationLogo class="h-11 auto text-indigo-600" />
                            <h1 class="ml-3 text-2xl font-bold text-gray-900">PRMS</h1> -->
                        </div>
                        <nav v-if="canLogin" class="flex items-center space-x-3 sm:space-x-4">
                            <Link
                                v-if="$page.props.auth.user"
                                :href="route('dashboard')"
                                class="text-sm sm:text-base text-gray-600 hover:text-gray-900"
                            >
                                Dashboard
                            </Link>
                            <template v-else>
                                <Link
                                    :href="route('login')"
                                    class="text-sm sm:text-base text-gray-600 hover:text-gray-900"
                                >
                                    Log in
                                </Link>
                                <Link
                                    v-if="canRegister"
                                    :href="route('register')"
                                    class="text-sm sm:text-base text-gray-600 hover:text-gray-900"
                                >
                                    Register
                                </Link>
                            </template>
                        </nav>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
                <!-- Hero Section -->
                <div class="text-center mb-12 sm:mb-16">
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-3 sm:mb-4">
                        Welcome to Press Release Management System
                    </h2>
                    <p class="text-base sm:text-lg lg:text-xl text-gray-600 max-w-3xl mx-auto">
                        Streamline your press release workflow with our comprehensive management solution
                    </p>
                </div>

                <!-- Features Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 mb-12 sm:mb-16">
                    <!-- Create Press Release -->
                    <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 hover:shadow-md transition-shadow duration-200">
                        <div class="flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-indigo-100 mb-3 sm:mb-4">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <h3 class="text-lg sm:text-xl font-semibold text-gray-900 mb-2">Create Press Release</h3>
                        <p class="text-sm sm:text-base text-gray-600 mb-3 sm:mb-4">Create and publish professional press releases with our intuitive editor</p>
                        <Link
                            :href="route('press-releases.create')"
                            class="inline-flex items-center text-indigo-600 hover:text-indigo-800 text-sm sm:text-base"
                        >
                            Get Started
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </Link>
                    </div>

                    <!-- Manage Releases -->
                    <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 hover:shadow-md transition-shadow duration-200">
                        <div class="flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-green-100 mb-3 sm:mb-4">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <h3 class="text-lg sm:text-xl font-semibold text-gray-900 mb-2">Manage Releases</h3>
                        <p class="text-sm sm:text-base text-gray-600 mb-3 sm:mb-4">View, edit, and manage all your press releases in one place</p>
                        <Link
                            :href="route('press-releases.index')"
                            class="inline-flex items-center text-green-600 hover:text-green-800 text-sm sm:text-base"
                        >
                            View All
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </Link>
                    </div>

                    <!-- Public View -->
                    <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 hover:shadow-md transition-shadow duration-200">
                        <div class="flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-blue-100 mb-3 sm:mb-4">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                        <h3 class="text-lg sm:text-xl font-semibold text-gray-900 mb-2">Public View</h3>
                        <p class="text-sm sm:text-base text-gray-600 mb-3 sm:mb-4">See how your press releases appear to the public</p>
                        <Link
                            :href="route('press-releases.public')"
                            class="inline-flex items-center text-blue-600 hover:text-blue-800 text-sm sm:text-base"
                        >
                            View Public Page
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </Link>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 mb-12 sm:mb-16">
                    <h3 class="text-lg sm:text-xl font-semibold text-gray-900 mb-4 sm:mb-6">Latest Press Releases</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6">
                        <div v-for="release in pressReleases" :key="release.id" class="bg-gray-50 rounded-lg p-3 sm:p-4">
                            <h4 class="text-base sm:text-lg font-medium text-gray-900 mb-2 line-clamp-2">{{ release.title }}</h4>
                            <p class="text-xs sm:text-sm text-gray-500 mb-2">{{ formatDate(release.published_at) }}</p>
                            <p class="text-sm sm:text-base text-gray-600 line-clamp-2 mb-3 sm:mb-4">{{ stripHtml(release.content) }}</p>
                            <Link
                                :href="`/press-releases/${release.slug}`"
                                class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium text-sm sm:text-base"
                            >
                                Read more
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </Link>
                        </div>
                        <div v-if="!pressReleases.length" class="col-span-3 text-center py-6 sm:py-8">
                            <p class="text-sm sm:text-base text-gray-500">No press releases available at the moment.</p>
                        </div>
                    </div>
                    <div v-if="pressReleases.length" class="mt-4 sm:mt-6 text-center">
                        <Link
                            :href="route('press-releases.public')"
                            class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium text-sm sm:text-base"
                        >
                            View all press releases
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </Link>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6">
                    <h3 class="text-lg sm:text-xl font-semibold text-gray-900 mb-4 sm:mb-6">Recent Activity</h3>
                    <div class="text-center text-gray-500 py-6 sm:py-8">
                        <p class="text-sm sm:text-base">No recent activity to display</p>
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 mt-8 sm:mt-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
                    <p class="text-center text-xs sm:text-sm text-gray-500">
                        Press Release Management System &copy; {{ new Date().getFullYear() }}
                    </p>
                </div>
            </footer>
        </div>
    </div>
</template>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
