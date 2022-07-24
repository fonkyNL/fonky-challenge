<template>
    <Head title="Dashboard" />
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex justify-center p-6 bg-white border-b border-gray-200 text-lg">
                        Hmm yup... it's empty in here...
                    </div>
                    <div>{{ quote }}</div>
                </div>
            </div>
        </div>
</template>
<script setup>
import { Head } from '@inertiajs/inertia-vue3';

defineProps({
    quote: String,
})

</script>
