<template>
<Head title="Manage PR" />
    <AuthenticatedLayout>

        <div class="py-6 sm:py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 sm:mb-6 space-y-3 sm:space-y-0">
                            <h3 class="text-lg font-medium text-gray-900">Manage Press Releases</h3>
                            <Link
                                :href="route('press-releases.create')"
                                class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                Create New
                            </Link>
                        </div>

                        <!-- Desktop Table View -->
                        <div class="hidden lg:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Published</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Edited By</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="release in pressReleases.data" :key="release.id" class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ release.title }}</div>
                                            <div class="text-sm text-gray-500">{{ release.slug }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
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
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ release.published_at ? formatDate(release.published_at) : 'Not published' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ release.user?.name || '—' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ release.last_edited_by?.name || '—' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                            <Link
                                                :href="route('press-releases.edit', release.id)"
                                                class="text-emerald-600 hover:text-emerald-900"
                                            >
                                                Edit
                                            </Link>
                                            <button
                                                @click="deleteRelease(release.id)"
                                                class="text-rose-600 hover:text-rose-900"
                                            >
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                    <tr v-if="!pressReleases.data?.length">
                                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                            No press releases found
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Card View -->
                        <div class="lg:hidden space-y-4">
                            <div v-for="release in pressReleases.data" :key="release.id" class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="space-y-3">
                                    <div>
                                        <h4 class="text-base font-medium text-gray-900 line-clamp-2">{{ release.title }}</h4>
                                        <p class="text-sm text-gray-500 mt-1">{{ release.slug }}</p>
                                    </div>

                                    <div class="flex flex-wrap gap-2 items-center">
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
                                        <span class="text-xs text-gray-500">
                                            {{ release.published_at ? formatDate(release.published_at) : 'Not published' }}
                                        </span>
                                    </div>

                                    <div class="text-sm text-gray-600 space-y-1">
                                        <div><span class="font-medium">Author:</span> {{ release.user?.name || '—' }}</div>
                                        <div><span class="font-medium">Last Edited By:</span> {{ release.last_edited_by?.name || '—' }}</div>
                                    </div>

                                    <div class="flex space-x-3 pt-2 border-t border-gray-200">
                                        <Link
                                            :href="route('press-releases.edit', release.id)"
                                            class="text-emerald-600 hover:text-emerald-900 text-sm font-medium"
                                        >
                                            Edit
                                        </Link>
                                        <button
                                            @click="deleteRelease(release.id)"
                                            class="text-rose-600 hover:text-rose-900 text-sm font-medium"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div v-if="!pressReleases.data?.length" class="text-center py-8">
                                <p class="text-sm text-gray-500">No press releases found</p>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-center">
                            <Pagination :links="pressReleases.links" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import Pagination from '@/Components/Pagination.vue'

const props = defineProps({
    pressReleases: Object
})

function formatDate(date) {
    return date ? new Date(date).toLocaleDateString() : '—'
}

function deleteRelease(id) {
    if (confirm('Are you sure you want to delete this press release?')) {
        router.delete(`/admin/press-releases/${id}`)
    }
}
</script>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
