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

                            <!-- Multiple Images Upload Section -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Images</label>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                                    <!-- Existing Images -->
                                    <div v-for="(image, index) in existingImages" :key="'existing-' + index" class="relative group">
                                        <img :src="`/storage/${image}`" class="w-full h-32 object-cover rounded-lg" />
                                        <button
                                            @click.prevent="removeExistingImage(index)"
                                            class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                    <!-- New Image Previews -->
                                    <div v-for="(image, index) in form.images" :key="'new-' + index" class="relative group">
                                        <img :src="image.preview" class="w-full h-32 object-cover rounded-lg" />
                                        <button
                                            @click.prevent="removeImage(index)"
                                            class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                    <!-- Add Image Button -->
                                    <label class="flex items-center justify-center h-32 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition-colors">
                                        <input
                                            type="file"
                                            @change="handleImages"
                                            multiple
                                            accept="image/*"
                                            class="hidden"
                                        />
                                        <div class="text-center">
                                            <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                            <span class="mt-2 block text-sm text-gray-600">Add Images</span>
                                        </div>
                                    </label>
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
    </AuthenticatedLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
    pressRelease: {
        type: Object,
        required: true,
        default: () => ({
            title: '',
            content: '',
            status: 'draft',
            images: []
        })
    }
})

const existingImages = ref(props.pressRelease.images || [])

const form = useForm({
    title: props.pressRelease?.title || '',
    content: props.pressRelease?.content || '',
    images: [],
    status: props.pressRelease?.status || 'draft',
    _method: 'PUT'
})

function handleImages(e) {
    const files = Array.from(e.target.files)
    files.forEach(file => {
        const reader = new FileReader()
        reader.onload = (e) => {
            form.images.push({
                file: file,
                preview: e.target.result
            })
        }
        reader.readAsDataURL(file)
    })
}

function removeImage(index) {
    form.images.splice(index, 1)
}

function removeExistingImage(index) {
    existingImages.value.splice(index, 1)
}

function submit() {
    // Create FormData to handle file uploads
    const formData = new FormData()
    formData.append('title', form.title)
    formData.append('content', form.content)
    formData.append('status', form.status)
    formData.append('_method', 'PUT')

    // Append each new image file
    form.images.forEach((image, index) => {
        formData.append(`images[${index}]`, image.file)
    })

    // Append existing images that weren't removed
    existingImages.value.forEach((image, index) => {
        formData.append(`existing_images[${index}]`, image)
    })

    // Post the form data
    form.post(route('press-releases.update', props.pressRelease.id), {
        forceFormData: true,
        data: formData,
        preserveScroll: true,
        onSuccess: () => {
            // Optional: Add success message or redirect
        },
        onError: (errors) => {
            console.error('Update failed:', errors);
        }
    })
}
</script>
