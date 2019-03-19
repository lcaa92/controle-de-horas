<template>
    
        <div class="card card-default">
            <div class="card-header">Extrato de horas</div>

            <div class="card-body">
                
                <data-table :fetch-url="fetchUrl"> </data-table>
            </div>
        </div>
        
</template>

<script>
    import DataTable from '../../DataTableComponent'
    export default {
        name: 'SummaryHours',
        props:{
            fetchUrl: { type: String, required: true }
        },
        mounted() {
            console.log(this.fetchUrl)
        }
    }
</script>
