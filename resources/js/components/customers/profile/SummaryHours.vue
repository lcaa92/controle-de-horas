<template>
    
        <div class="card card-default">
            <div class="card-header">Extrato de horas</div>
            <div class="card-body">
                <canvas id="myChart" width="400" height="400"></canvas>

                <data-table ref="dataTableComponent" :fetch-url="fetchUrl"> </data-table>
            </div>
        </div>
        
</template>

<script>
    import DataTable from '../../DataTableComponent'
    import Chart from 'chart.js';
    export default {
        name: 'SummaryHours',
        props:{
            fetchUrl: { type: String, required: true },
            chartUrlData: { type: String, required: true }
        },
        data: function () {
            return {
                chartConfig: {
                    labels: [],
                    data: [],

                }
            }
        },
        mounted() {
            this.fetchChartData()
        },
        methods: {
            fetchChartData() {
                axios.get(this.chartUrlData)
                .then((res) => {
                    // console.log(res)
                    let data = res.data.data
                    this.chartConfig.data = data.map(el => el.diff_time_day)
                    this.chartConfig.labels = data.map(el => el.date)
                    console.log(this.chartConfig)
                    this.createChart('myChart', {
                        type: 'line',
                        data: {
                            labels: this.chartConfig.labels,
                            datasets: [{
                                label: 'Diff',
                                data: this.chartConfig.data,                        
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    })
                })
                .catch((res) => {
                    if(res instanceof Error) {
                    console.log(res.message);
                    } else {
                    console.log(res.data);
                    }
                });
            },
            createChart(chartId, chartData) {
                const ctx = document.getElementById(chartId);
                const myChart = new Chart(ctx, {
                    type: chartData.type,
                    data: chartData.data,
                    options: chartData.options,
                });
            }
        }
    }
</script>
