<template>
    <div class="container">
        <!-- Display the fetched data -->
        <div v-for="barData in barDataArray" :key="barData" class="column">
            <Bar v-if="barDataLoaded(barData)" :data="barData" :options="options"/>
        </div>
        <div class="column">
            <p v-if="bestSellers.length > 0" class="best-sellers">Best sellers in the Netherlands</p>
            <ul>
                <li v-for="(seller, index) in bestSellers" :key="seller">
                    {{ index + 1 }}. {{ seller.supplier }} with {{ seller.amount }} donations
                </li>
            </ul>
        </div>
    </div>
</template>

<script lang="ts">
import {Chart as ChartJS, BarElement, CategoryScale, LinearScale, Title, Tooltip, Legend} from 'chart.js';
import {Bar} from 'vue-chartjs';
import axios from 'axios';

ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend);

export default {
    name: 'App',
    components: {
        Bar
    },
    data() {
        return {
            barDataArray: [
                {
                    labels: [],
                    datasets: []
                },
                {
                    labels: [],
                    datasets: []
                }
            ],
            options: {
                responsive: true,
                onClick: this.handleChartClick
            },
            dataLoaded: [false, false],
            selectedBranch: '',
            bestSellers: [],
            allBranches: []
        };
    },
    mounted() {
        this.fetchData('branch', 'Amount of donations per branch', 0);
    },
    watch: {
        selectedBranch: {
            immediate: false,
            handler(newValue, oldValue) {
                if (newValue !== oldValue && this.allBranches.includes(newValue)) {
                    this.fetchData('seller', `Amount of donations in ${newValue}`, 1);
                    this.fetchBestSellers();
                }
            }
        }
    },
    methods: {
        fetchData(supplier, label, barDataIndex) {
            if (barDataIndex === 1 && this.barDataArray[1].datasets.length > 0) {
                barDataIndex = 0;
            }
            this.dataLoaded[barDataIndex] = false;
            const apiUrl =
                supplier === 'branch'
                    ? 'api/v1/orders?supplier=branch&type=COUNT'
                    : `api/v1/orders?supplier=seller&type=COUNT&where=${this.selectedBranch}`;
            axios
                .get(apiUrl)
                .then(response => {
                    const labels = response.data.data.map(item => item.supplier);
                    const data = response.data.data.map(item => item.amount);

                    if(supplier === 'branch'){
                        this.allBranches = labels;
                    }

                    this.barDataArray[barDataIndex].labels = labels;
                    this.barDataArray[barDataIndex].datasets = [
                        {
                            data: data,
                            backgroundColor: '#24A1DA',
                            label: label
                        }
                    ];
                    this.dataLoaded[barDataIndex] = true;

                    if (barDataIndex === 1) {
                        // Swap data between the two barData objects
                        [this.barDataArray[0], this.barDataArray[1]] = [this.barDataArray[1], this.barDataArray[0]];
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        },
        handleChartClick(event, activeElements) {
            if (activeElements.length > 0) {
                const branchDataIndex = this.barDataArray[1].datasets.length > 0 ? 1 : 0;
                const index = activeElements[0].index;
                const label = this.barDataArray[branchDataIndex].labels[index];
                this.selectedBranch = label;
            }
        },
        barDataLoaded(barData) {
            const barDataIndex = barData === this.barDataArray[0] ? 0 : 1;
            return this.dataLoaded[barDataIndex];
        },
        fetchBestSellers() {
            const apiUrl = `api/v1/orders?supplier=seller&type=COUNT`;
            axios
                .get(apiUrl)
                .then(response => {
                    this.bestSellers = response.data.data;
                })
                .catch(error => {
                    console.error(error);
                });
        },
    }
};
</script>
