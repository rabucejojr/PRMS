<template>
    <div v-if="links.length > 3" class="flex justify-center">
        <div class="flex flex-wrap -mb-1">
            <template v-for="(link, key) in links" :key="key">
                <div v-if="link.url === null"
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                >
                    {{ getPaginationLabel(link.label) }}
                </div>
                <Link v-else
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-indigo-50 focus:border-indigo-500 focus:text-indigo-500"
                    :class="{ 'bg-indigo-50': link.active }"
                    :href="link.url"
                >
                    {{ getPaginationLabel(link.label) }}
                </Link>
            </template>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    links: {
        type: Array,
        required: true,
    },
})

function getPaginationLabel(label) {
    if (label === '&laquo; Previous') return '←'
    if (label === 'Next &raquo;') return '→'
    return label
}
</script>
