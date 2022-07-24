<template>
    <div class="p-8">
        <div class="flex w-full justify-between items-center mb-4">
            <div class="flex flex-col ">
                <span class="text-2xl">{{ customer.data.name }}</span>
                <span>
                    Total orders: {{ props.customerStats.total_orders.total }}
                </span>

            </div>
            <div class="flex items-center space-x-4">
                <span class="font-semibold">Year:</span>
                <select class="select" v-model="selectedYear">
                    <option value="all">All-time</option>
                    <option v-for="year of yearOptions" :value="year">{{ year }}</option>
                </select>
            </div>
        </div>

        <div class="grid xl:grid-cols-3 gap-6">

            <div class="flex flex-col card space-y-4">
                <span class="header">Orders by product</span>
                <apexchart v-if="orderByProductsChart.series.length"
                           height="350"
                           type="pie"
                           :options="orderByProductsChart.chartOptions"
                           :series="orderByProductsChart.series">
                </apexchart>
                <span v-else class="m-auto min-h-[12rem]"> No data </span>
            </div>

            <div class="flex flex-col card space-y-4">
                <span class="header">Orders by branch</span>
                <apexchart v-if="orderByBranchChart.series.length"
                           height="350"
                           type="pie" :options="orderByBranchChart.chartOptions"
                           :series="orderByBranchChart.series">
                </apexchart>
                <span v-else class="m-auto min-h-[12rem]"> No data </span>

            </div>

            <div class="flex flex-col card space-y-4">
                <span class="header">Orders by employee</span>
                <apexchart v-if="orderByEmployeeChart.series.length"
                           height="350"
                           type="pie"
                           :options="orderByEmployeeChart.chartOptions"
                           :series="orderByEmployeeChart.series">
                </apexchart>
                <span v-else class="m-auto min-h-[12rem]"> No data </span>
            </div>
        </div>

    </div>
</template>
<script setup lang="ts">
import {computed, ref, watch} from "vue";
import {Inertia} from "@inertiajs/inertia";

const props = defineProps<{
    customer: LaravelResource<Customer>,
    customerStats: unknown
}>();

const orderByProductsChart = computed(() => {
    return {
        chartOptions: {
            labels: props.customerStats.total_orders_by_product.map(x => x.name)
        },
        series: props.customerStats.total_orders_by_product.map(x => x.total)
    }
})

const orderByBranchChart = computed(() => {
    return {
        chartOptions: {
            labels: props.customerStats.total_orders_by_branch.map(x => x.name)
        },
        series: props.customerStats.total_orders_by_branch.map(x => x.total)
    }
})

const orderByEmployeeChart = computed(() => {
    return {
        chartOptions: {
            labels: props.customerStats.total_orders_by_employee.map(x => x.name)
        },
        series: props.customerStats.total_orders_by_employee.map(x => x.total)
    }
})

const selectedYear = ref('all');

const yearOptions = computed(() => {
    const currentYear = new Date().getFullYear();
    const years = [];

    let startYear = currentYear-2;

    while (startYear <= currentYear) {
        years.push(startYear++);
    }
    return years;
});

watch(selectedYear, _.debounce((value) => {

    let data = (value && value !== 'all' ? { year: value } : {});

    Inertia.get(
        route('customer.show', {customer: props.customer.data.id}),
        data,
        { only: ['customerStats', 'customer'], replace: true, preserveState: true }
    );

}, 150));

</script>

