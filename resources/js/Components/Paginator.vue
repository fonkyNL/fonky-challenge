<template>
    <div v-if="links.prev || links.next" class="flex justify-between mt-4">
        <Link
            v-if="links.prev"
            :href="links.prev"
            class="bg-white rounded-lg py-2 px-4">
            Previous
        </Link>
        <span v-else class="bg-white rounded-lg py-2 px-4 opacity-50">Previous</span>

        <Link
            v-if="links.next"
            :href="links.next"
            class="inline-flex items-center py-2 px-4 bg-white rounded-lg">
            Next
        </Link>
        <span v-else class="bg-white rounded-lg py-2 px-4 opacity-50">Next</span>

    </div>
</template>
<script setup lang="ts">
import { Link } from '@inertiajs/inertia-vue3';

defineProps<{
    links: PaginationLinkObject,
}>();
</script>
