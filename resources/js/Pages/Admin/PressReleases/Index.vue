<template>
<Head title="Manage PR" />
    <AuthenticatedLayout>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-medium text-gray-900">Manage Press Releases</h3>
                            <Link
                                :href="route('press-releases.create')"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                Create New
                            </Link>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Published</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
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
                                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                            No press releases found
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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
