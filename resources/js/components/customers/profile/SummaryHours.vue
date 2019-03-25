<template>
    
        <div class="card card-default">
            <div class="card-header">Extrato de horas</div>
            <div class="card-body">
                <canvas id="myChart" width="400" height="400"></canvas>

                <data-table ref="dataTableComponent" :fetch-cols-rows="arrDataTable" > </data-table>
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
                arrDataTable: {
                    cols: [],
                    rows: []
                },
                chartConfig: {
                    labels: [],
                    data: [],

                }
            }
        },
        mounted() {
            this.fetchChartData()
            this.fetchData()
        },
        methods: {
            fetchData(url) {
                axios.get(this.fetchUrl)
                .then((res) => {
                    this.$refs.dataTableComponent.cols = res.data.columns
                    this.$refs.dataTableComponent.rows = res.data.rows
                    // this.arrDataTable.cols = res.data.columns
                    // this.arrDataTable.rows = res.data.rows
                })
                .catch((res) => {
                    if(res instanceof Error) {
                    console.log(res.message);
                    } else {
                    console.log(res.data);
                    }
                });
            },
            fetchChartData() {
                axios.get(this.chartUrlData)
                .then((res) => {
                    // console.log(res)
                    let data = res.data.data
                    this.chartConfig.data = data.map(el => el.diff_time_day)
                    this.chartConfig.labels = data.map(el => el.date)
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
