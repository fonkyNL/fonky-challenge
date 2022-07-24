<template>
    <div class="max-w-7xl mx-auto p-8">

        <div class="flex w-full justify-end mb-4">
            <input class="w-full lg:w-1/3 rounded-md border-none shadow p-2" placeholder="Search" type="text" v-model="search">
        </div>

        <div class="flex flex-col card">
            <table>
                <thead>
                <tr class="text-left ">
                    <th class="p-2">Name</th>
                    <th class="p-2">Total orders</th>
                    <th class="p-2">Created at</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="customer of customers.data"
                    class="hover:bg-gray-50 hover:cursor-pointer"
                    @click="$inertia.visit(route('customer.show', { customer: customer.id}))"
                >
                    <td class="p-2">{{ customer.name }}</td>
                    <td class="p-2">{{ customer.orders_count }}</td>
                    <td class="p-2">{{ customer.created_at }}</td>
                </tr>
                </tbody>
            </table>

        </div>
        <Paginator :links="customers.links"/>
    </div>
</template>
<script setup lang="ts">

import {ref, watch} from "vue";
import {Inertia} from "@inertiajs/inertia";
import Paginator from "@/Components/Paginator.vue";

const props = defineProps<{
    customers: PaginatedCollection<Customer>
    filters: Object,
}>();

const search = ref(props.filters?.search);

watch(search, _.debounce((value) => {

    let data = (value ? { search: value } : {});

    Inertia.get(route('customer.index'), data, { only: ['customers', 'filters'], replace: true, preserveState: true })

}, 300));

</script>
