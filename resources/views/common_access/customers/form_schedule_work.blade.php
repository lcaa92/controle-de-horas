@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Formulário de Clientes</div>

                <div class="card-body">
                    @if (session('msg'))
                        <div class="alert alert-{{session('alert')}}">
                            {{ session('msg') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('save.schedule.worked', [ 'customer_id' => $customer->id ]) }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="customer_name">Cliente</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Customer Name" value="{{ $customer->name }}" readonly>
                        </div>

                        <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                        @if($schedule->id)
                            <input type="hidden" name="id" value="{{ $schedule->id }}">
                        @endif
                        
                        <div class="form-group">
                            <label for="start_time">Hora Inicio</label>
                            <input type="text" class="form-control datetime" id="start_time" name="start_time" placeholder="Hora Início" value="{{ isset($schedule->start_time) ? $schedule->start_time : old('start_time') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="end_time">Hora Inicio</label>
                            <input type="text" class="form-control datetime" id="end_time" name="end_time" placeholder="Hora Termino" value="{{ isset($schedule->end_time) ? $schedule->end_time : old('end_time') }}" required>
                        </div>

                        @if ($customer->workschedules->count() > 0)
                            <div class="form-group">
                                <label for="work_schedule_id">Escala</label>
                                <select class="form-control" id="work_schedule_id" name="work_schedule_id">
                                    <option value="">Selectine uma escala</option>
                                    @foreach ($customer->workschedules as $workSchedule)
                                    <option value="{{ $workSchedule->id }}" {{ $schedule->work_schedule_id == $workSchedule->id ? 'selected' : '' }} >{{ $workSchedule->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
window.onload = function(e){ 
    flatpickr(".datetime", {
        enableTime: true,
        altFormat: "d/m/Y H:i",
        dateFormat: "Y-m-d H:i:00",
        time_24hr: true
    });
}
</script>
@endsection
