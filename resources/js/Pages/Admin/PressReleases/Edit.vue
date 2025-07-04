<template>
<Head title="Edit PR" />
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="submit">
                            <div class="mb-4">
                                <label class="block mb-1 text-sm font-medium text-gray-700">Title</label>
                                <input
                                    v-model="form.title"
                                    type="text"
                                    class="w-full p-2 border rounded focus:ring-blue-500 focus:border-blue-500"
                                    :class="{ 'border-red-500': form.errors.title }"
                                />
                                <div v-if="form.errors.title" class="mt-1 text-sm text-red-600">
                                    {{ form.errors.title }}
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block mb-1 text-sm font-medium text-gray-700">Author</label>
                                <div class="w-full p-2 border rounded bg-gray-100 text-gray-700">
                                    {{ props.pressRelease.user?.name || '—' }}
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="block mb-1 text-sm font-medium text-gray-700">Content</label>
                                <textarea
                                    v-model="form.content"
                                    class="w-full p-2 border rounded focus:ring-blue-500 focus:border-blue-500"
                                    :class="{ 'border-red-500': form.errors.content }"
                                    rows="10"
                                ></textarea>
                                <div v-if="form.errors.content" class="mt-1 text-sm text-red-600">
                                    {{ form.errors.content }}
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="block mb-1 text-sm font-medium text-gray-700">Status</label>
                                <select
                                    v-model="form.status"
                                    class="w-full p-2 border rounded focus:ring-blue-500 focus:border-blue-500"
                                    :class="{ 'border-red-500': form.errors.status }"
                                >
                                    <option value="draft">Draft</option>
                                    <option value="published">Published</option>
                                    <option value="archived">Archived</option>
                                </select>
                                <div v-if="form.errors.status" class="mt-1 text-sm text-red-600">
                                    {{ form.errors.status }}
                                </div>
                            </div>

                            <div class="flex justify-end space-x-4">
                                <Link
                                    :href="route('press-releases.index')"
                                    class="px-6 py-3 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors"
                                >
                                    Cancel
                                </Link>
                                <button
                                    type="submit"
                                    class="px-6 py-3 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 ease-in-out transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed"
                                    :disabled="form.processing"
                                >
                                    <span v-if="form.processing">Updating...</span>
                                    <span v-else>Update Press Release</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="history.length" class="mt-10">
            <h4 class="text-md font-semibold mb-4">Edit History</h4>
            <div class="space-y-4">
                <div v-for="entry in history" :key="entry.id" class="p-4 border rounded bg-gray-50">
                    <div class="text-sm text-gray-700 mb-1">
                        <span class="font-medium">{{ entry.user?.name || 'Unknown user' }}</span>
                        edited on
                        <span>{{ new Date(entry.created_at).toLocaleString() }}</span>
                    </div>
                    <ul class="ml-4 list-disc text-sm text-gray-800">
                        <li v-for="(change, field) in JSON.parse(entry.changes)" :key="field">
                            <span class="font-semibold">{{ field }}:</span>
                            <span class="text-red-600 line-through">{{ change.old }}</span>
                            <span class="mx-1">→</span>
                            <span class="text-green-700">{{ change.new }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link } from '@inertiajs/vue3'

const props = defineProps({
    pressRelease: {
        type: Object,
        required: true,
        default: () => ({
            title: '',
            content: '',
            status: 'draft'
        })
    },
    history: {
        type: Array,
        default: () => []
    }
})

const form = useForm({
    title: props.pressRelease?.title || '',
    content: props.pressRelease?.content || '',
    status: props.pressRelease?.status || 'draft',
    _method: 'PUT'
})

function submit() {
    form.put(route('press-releases.update', props.pressRelease.id))
}
</script>
