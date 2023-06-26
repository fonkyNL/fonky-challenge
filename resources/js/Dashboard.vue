<template>
    <div>
        <!-- Display the fetched data -->
        <div v-for="barData in [firstBar, secondBar]" :key="barData">
            <Bar v-if="barDataLoaded(barData)" :data="barData" :options="options" />
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
            firstBar: {
                labels: [],
                datasets: []
            },
            secondBar: {
                labels: [],
                datasets: []
            },
            options: {
                responsive: true,
                onClick: this.handleChartClick
            },
            dataLoaded: {
                firstBar: false,
                secondBar: false
            },
            selectedBranch: ''
        };
    },
    mounted() {
        this.fetchData('branch', 'Aantal donaties per vestiging', 'firstBar');
    },
    watch: {
        selectedBranch: {
            immediate: false,
            handler(newValue, oldValue) {
                if (newValue !== oldValue) {
                    this.fetchData('seller', 'Aantal donaties in vestiging', 'secondBar');
                }
            }
        }
    },
    methods: {
        fetchData(supplier, label, barDataKey) {
            const apiUrl = supplier === 'branch' ? 'api/v1/orders?supplier=branch&type=COUNT' : `api/v1/orders?supplier=seller&type=COUNT&where=${this.selectedBranch}`;
            axios
                .get(apiUrl)
                .then(response => {
                    const labels = response.data.data.map(item => item.supplier);
                    const data = response.data.data.map(item => item.amount);
                    this[barDataKey].labels = labels;
                    this[barDataKey].datasets = [
                        {
                            data: data,
                            backgroundColor: '#24A1DA',
                            label: label
                        }
                    ];
                    this.dataLoaded[barDataKey] = true;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        handleChartClick(event, activeElements) {
            if (activeElements.length > 0) {
                const index = activeElements[0].index;
                const label = this.firstBar.labels[index];
                this.selectedBranch = label;
            }
        },
        barDataLoaded(barData) {
            console.log(this.dataLoaded[barData === this.firstBar ? 'firstBar' : 'secondBar'])
            return this.dataLoaded[barData === this.firstBar ? 'firstBar' : 'secondBar'];
        }
    }
};
</script>
