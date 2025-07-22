<template>
    <Head title="View Press Release" />
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-4xl mx-auto py-6 sm:py-12 px-4 sm:px-6 lg:px-8">
            <!-- Back Button -->
            <!--  <div class="mb-6 sm:mb-8">
                <Link href="/press-releases" class="inline-flex items-center text-gray-600 hover:text-gray-900 text-sm sm:text-base">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Press Releases
                </Link>
            </div> -->

            <!-- Press Release Content -->
            <article class="bg-white rounded-lg shadow-sm overflow-hidden">
                <!-- Content -->
                <div class="p-4 sm:p-6 lg:p-8">
                    <!-- Header -->
                    <header class="mb-6 sm:mb-8">
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-3 sm:mb-4">
                            {{ release.title }}
                        </h1>
                        <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-2 sm:space-y-0">
                            <span class="text-xs sm:text-sm text-gray-500 flex items-center">
                                <svg class="inline-block w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ formatDate(release.published_at) }}
                            </span>
                            <span v-if="release.user?.name" class="text-xs sm:text-sm text-gray-500 flex items-center">
                                <svg class="inline-block w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ release.user.name }}
                            </span>
                            <span class="inline-flex items-center px-2 py-0.5 sm:px-2.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                Published
                            </span>
                        </div>
                    </header>

                    <!-- Main Content -->
                    <div class="prose prose-sm sm:prose-base lg:prose-lg max-w-none">
                        <div v-html="release.content" class="text-justify"></div>
                    </div>
                </div>
            </article>

            <!-- Share Section -->
            <div class="mt-6 sm:mt-8 text-center">
                <h3 class="text-sm font-medium text-gray-500 mb-3 sm:mb-4">Share this press release</h3>
                <div class="flex justify-center space-x-4">
                    <a href="#" class="text-gray-400 hover:text-gray-500 p-2">
                        <span class="sr-only">Facebook</span>
                        <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-gray-500 p-2">
                        <span class="sr-only">Twitter</span>
                        <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-gray-500 p-2">
                        <span class="sr-only">LinkedIn</span>
                        <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3'

const props = defineProps({
    release: {
        type: Object,
        required: true
    }
})

function formatDate(date) {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    })
}
</script>

<style scoped>
.prose img {
    border-radius: 0.5rem;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    max-width: 100%;
    height: auto;
}

.prose a {
    color: #4f46e5;
    text-decoration: none;
}

.prose a:hover {
    color: #3730a3;
}

.prose h2 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #111827;
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
}

.prose h3 {
    font-size: 1.125rem;
    font-weight: 700;
    color: #111827;
    margin-top: 1.25rem;
    margin-bottom: 0.5rem;
}

.prose p {
    color: #4b5563;
    line-height: 1.7;
    margin-bottom: 1.5em;
    margin-top: 0;
    text-indent: 0;
}

.prose p + p {
    margin-top: 1.5em;
    text-indent: 2em;
}

.prose ul {
    list-style-type: disc;
    list-style-position: inside;
    margin-bottom: 1rem;
}

.prose ol {
    list-style-type: decimal;
    list-style-position: inside;
    margin-bottom: 1rem;
}

.prose blockquote {
    border-left: 4px solid #e5e7eb;
    padding-left: 1rem;
    font-style: italic;
    margin: 1rem 0;
}

@media (min-width: 640px) {
    .prose h2 {
        font-size: 1.5rem;
        margin-top: 2rem;
        margin-bottom: 1rem;
    }

    .prose h3 {
        font-size: 1.25rem;
        margin-top: 1.5rem;
        margin-bottom: 0.75rem;
    }
}
</style>
