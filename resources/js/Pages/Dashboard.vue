<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps({ pressReleases: Array })

function formatDate(date) {
    return date ? new Date(date).toLocaleDateString() : '—'
}

function deleteRelease(id) {
    if (confirm('Are you sure you want to delete this press release?')) {
        router.delete(`/admin/press-releases/${id}`)
    }
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Press Releases Section -->
                <div class="mb-8 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-medium text-gray-900">Press Releases</h3>
                            <div class="space-x-4">
                                <Link
                                    :href="route('press-releases.index')"
                                    class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                >
                                    View All Press Releases
                                </Link>
                                <Link
                                    :href="route('press-releases.create')"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                >
                                    Create Press Release
                                </Link>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            <div v-for="release in pressReleases?.slice(0, 6)" :key="release.id" class="p-4 bg-gray-50 rounded-lg">
                                <h4 class="mb-2 text-lg font-medium text-gray-900">{{ release.title }}</h4>
                                <div class="flex items-center justify-between">
                                    <span
                                        :class="{
                                            'px-2 inline-flex text-xs leading-5 font-semibold rounded-full': true,
                                            'bg-green-100 text-green-800': release.status === 'published',
                                            'bg-yellow-100 text-yellow-800': release.status === 'draft',
                                            'bg-gray-100 text-gray-800': release.status === 'archived'
                                        }"
                                    >
                                        {{ release.status.charAt(0).toUpperCase() + release.status.slice(1) }}
                                    </span>
                                    <span class="text-sm text-gray-500">{{ formatDate(release.published_at) }}</span>
                                </div>
                            </div>
                        </div>

                        <div v-if="pressReleases?.length > 3" class="mt-4 text-center">
                            <Link
                                :href="route('press-releases.index')"
                                class="text-sm text-blue-600 hover:text-blue-900"
                            >
                                View all {{ pressReleases.length }} press releases →
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
