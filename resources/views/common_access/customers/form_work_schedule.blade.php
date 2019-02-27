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

                    <form method="POST" action="{{ route('save.work.schedule', [ 'customer_id' => $customer->id ]) }}">
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
                            <label for="type">Tipo</label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="">Selectine uma opção</option>
                                <option value="1" {{ $schedule->type == 1 ? 'selected' : '' }} >Horas</option>
                                <option value="2" {{ $schedule->type == 2 ? 'selected' : '' }}>Valor por horas</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="hours_per_day">Horas por dia (hh:mm)</label>
                            <input type="text" class="form-control" id="hours_per_day" name="hours_per_day" placeholder="Horas por dia" value="{{ isset($schedule->hours_per_day) ? $schedule->hours_per_day : old('hours_per_day') }}">
                        </div>

                        <div class="form-group">
                            <label for="price_per_day">Valor por hora</label>
                            <input type="text" class="form-control" id="price_per_day" name="price_per_day" placeholder="Preço por dia" value="{{ isset($schedule->price_per_day) ? $schedule->price_per_day : old('price_per_day') }}">
                        </div>

                        <div class="form-group">
                            <label for="description">Descrição</label>
                            <input type="text" class="form-control" id="description" name="description" placeholder="Descrição" value="{{ isset($schedule->description) ? $schedule->description : old('description') }}" >
                        </div>

                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
