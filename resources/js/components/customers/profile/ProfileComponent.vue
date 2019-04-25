<template>
    <div class="row profile">
        <div class="col">
            <div class="card card-default">
                <div class="card-header">Perfil {{ customer.name }}</div>

                <div class="card-body">
                    <h5> Nome: </h5>
                    <h6> {{ customer.name }} </h6>
                    <hr>

                    <h5> Email: </h5>
                    <h6> {{ customer.email ? customer.email : 'N/A' }} </h6>
                    <hr>

                    <h5> Telefone: </h5>
                    <h6> {{ customer.phone ? customer.phone : 'N/A'}} </h6>
                    <hr>

                    <h5> Tipo Cliente: </h5>
                    <h6 v-if="customer.customer_type == 1"> CPF </h6>
                    <h6 v-if="customer.customer_type == 2"> CNPJ </h6>
                    <h6 v-else> N/A </h6>
                    <hr>

                    <h5> Documento Cliente: </h5>
                    <h6> {{ customer.customer_document ? customer.customer_document : 'N/A'}} </h6>
                    <hr>

                    <h5> Tipo Contrato: </h5>
                    <h6 v-if="customer.contract_type == 1"> Carteira Assinada </h6>
                    <h6 v-else-if="customer.contract_type == 2"> Juridico </h6>
                    <h6 v-else> N/A </h6>
                    <hr>
                    
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'CustomerProfile',
        props:{
            customer: Object
        },
        mounted() {
            
        }
    }
</script>
