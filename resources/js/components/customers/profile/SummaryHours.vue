<template>
    
        <div class="card card-default">
            <div class="card-header">Extrato de horas</div>
            <div class="card-body">

                <div class="form-row">
                    <div class="col-5">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupPrepend">De</span>
                            </div>
                            <input type="text" v-model="dateBegin" class="form-control date" id="date_begin" placeholder="De">
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupPrepend">Até</span>
                            </div>
                            <input type="text" v-model="dateEnd" class="form-control date" id="date_end" placeholder="Até" required>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="input-group">
                            <button class="btn btn-primary" type="submit" v-on:click="fetchData">Buscar</button>
                        </div>
                    </div>
                </div>
                

                <canvas id="myChart" width="400" height="400"></canvas>

                <data-table ref="dataTableComponent" :fetch-cols-rows="arrDataTable" > </data-table>
            </div>
        </div>
        
</template>

<script>
    import DataTable from '../../DataTableComponent'
    import Chart from 'chart.js';
    import flatpickr from "flatpickr";
    export default {
        name: 'SummaryHours',
        props:{
            fetchUrl: { type: String, required: true },
            dateBegin: {
                type: String,
                required: false,
                default: new Date(new Date().getTime() - (30 * 24 * 60 * 60 * 1000) ).toISOString().slice(0,10)
            },
            dateEnd: {
                type: String,
                required: false,
                default: new Date().toISOString().slice(0,10)
            }
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

            flatpickr(".date", {
                enableTime: false,
                altInput: true,
                altFormat: "d/m/Y",
                dateFormat: "Y-m-d",
                time_24hr: true
            });

        },
        methods: {
            fetchData(url) {
                axios.get(this.fetchUrl, {
                    params: {
                        'begin_date': this.dateBegin,
                        'end_date': this.dateEnd
                    }
                })
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
