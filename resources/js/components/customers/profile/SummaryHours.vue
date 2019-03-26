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
            fetchUrl: { type: String, required: true }
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
            this.fetchData()
        },
        methods: {
            fetchData(url) {
                axios.get(this.fetchUrl)
                .then((res) => {
                    this.$refs.dataTableComponent.cols = res.data.columns
                    this.$refs.dataTableComponent.rows = res.data.rows
                    let data = res.data.rows
                    let arrData = []
                    let arrLabels = []
                    data.map(function(el){
                        el.map(function(e){
                            if(e.field == 'diff_time_day'){
                                arrData.push(e.value)
                            }
                            if(e.field == 'date'){
                                arrLabels.push(e.value)
                            }
                        })
                    })
                    
                    this.chartConfig.data = arrData.reverse()
                    this.chartConfig.labels = arrLabels.reverse()
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
