@extends('layouts.app')

@section('dtfilters_scripts')

<script>
    window.dtfilters = {}
    window.dtfilters.link_edit = function(value, obj){
        return '<a href="{{ route("form.work.schedule", ["customer_id" => $customer->id]) }}/'+value+'">Editar</a>'

    }

    window.dtfilters.link_edit_worked_schedule = function(value, obj){
        return '<a href="{{ route("form.schedule.worked", ["customer_id" => $customer->id]) }}/'+value+'">Editar</a>'

    }

    window.dtfilters.link_edit_absence = function(value, obj){
        return '<a href="{{ route("form.absence.permission", ["customer_id" => $customer->id]) }}/'+value+'">Editar</a>'

    }
</script>
@endsection

@section('content')
<div class="container-fluid">
    @if (session('msg'))
        <div class="alert alert-{{session('alert')}}">
            {{ session('msg') }}
        </div>
    @endif

    <div class="row">
        <div class="col-sm-12 col-md-3">
            <customer-profile-component :customer='{!! json_encode($customer) !!}'></customer-profile-component>
        </div>
        <div class="col-md">
            <div class="row" >
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            Escalas de trabalho
                            <a class="float-right" href="{{ route('form.work.schedule', ['customer_id' => $customer->id]) }}"> Adicionar escala</a>
                        </div>

                        <div class="card-body">
                            <data-table fetch-url="{{ route('list.work.schedule', ['customer_id'=>$customer->id]) }}"> </data-table>
                        </div>
                    </div>
                </div>
                @if($customer->contract_type == 1)
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                Abonos
                                <a class="float-right" href="{{ route('form.absence.permission', ['customer_id' => $customer->id]) }}"> Adicionar abono</a>
                            </div>

                            <div class="card-body">
                                <data-table fetch-url="{{ route('list.absence.permission', ['customer_id'=>$customer->id]) }}"> </data-table>
                            </div>
                        </div>
                    </div>
                @endif
                @if($customer->contract_type == 2)
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                Projetos
                                <!-- <a class="float-right" href="{{ route('form.absence.permission', ['customer_id' => $customer->id]) }}"> Adicionar abono</a> -->
                            </div>

                            <div class="card-body">
                                Listagem de projetos
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            Horários
                            <a class="float-right" href="{{ route('form.schedule.worked', ['customer_id' => $customer->id]) }}"> Adicionar horário</a>
                        </div>

                        <div class="card-body">
                            <data-table fetch-url="{{ route('list.schedule.work', ['customer_id'=>$customer->id]) }}"> </data-table>
                        </div>
                    </div>
                </div> 
                @if($customer->contract_type == 1)
                    <div class="col">
                        <summary-hours fetch-url="{{ route('list.summary.hours', ['customer_id' => $customer->id]) }}"></summary-hours>
                    </div>   
                @endif
            </div>
           
            <br />

        </div>
    </div>

</div>
@endsection

@section('scripts')

@endsection
