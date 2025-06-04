<template>
    <Head title="Press Releases" />
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center mb-8">
                <Link href="/" class="inline-flex items-center text-gray-600 hover:text-gray-900">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Home
                </Link>
            </div>
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Press Releases</h1>
                <p class="text-lg text-gray-600">Stay updated with our latest news and announcements</p>
            </div>

            <!-- Loading State -->
            <div v-if="!releases" class="flex justify-center items-center py-12">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div>
            </div>

            <div v-else-if="releases.data?.length" class="space-y-8">
                <div v-for="release in releases.data" :key="release.id"
                    class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 p-6">
                    <div class="flex flex-col space-y-3">
                        <h2 class="text-2xl font-semibold text-gray-900">
                            <Link :href="`/press-releases/${release.slug}`"
                                class="hover:text-indigo-600 transition-colors duration-200">
                                {{ release.title }}
                            </Link>
                        </h2>
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-gray-500">
                                <svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ formatDate(release.published_at) }}
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                Published
                            </span>
                        </div>
                        <p class="text-gray-600 line-clamp-2">
                            {{ stripHtml(release.content) }}
                        </p>
                        <Link :href="`/press-releases/${release.slug}`"
                            class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium">
                            Read more
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </Link>
                    </div>
                </div>
            </div>

            <div v-else class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">No press releases found</h3>
                <p class="mt-1 text-sm text-gray-500">Check back later for updates.</p>
            </div>

            <!-- Pagination -->
            <div v-if="releases?.data?.length" class="mt-8">
                <Pagination :links="releases.links" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3'
import Pagination from '@/Components/Pagination.vue'

const props = defineProps({
    releases: {
        type: Object,
        required: true,
        default: () => ({ data: [], links: [] })
    }
})

function formatDate(date) {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    })
}

function stripHtml(html) {
    if (!html) return ''
    const tmp = document.createElement('DIV')
    tmp.innerHTML = html
    const text = tmp.textContent || tmp.innerText || ''
    return text.substring(0, 200) + (text.length > 200 ? '...' : '')
}
</script>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
