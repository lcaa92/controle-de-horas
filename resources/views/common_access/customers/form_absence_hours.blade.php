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

                    <form method="POST" action="{{ route('save.absence.permission', [ 'customer_id' => $customer->id ]) }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                        @if($absence->id)
                            <input type="hidden" name="id" value="{{ $absence->id }}">
                        @endif
                        
                        <div class="form-group">
                            <label for="date">Data</label>
                            <input type="text" class="form-control date" id="date" name="date" placeholder="Data Abono" value="{{ isset($absence->date) ? $absence->date : old('date') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="hours_absence">Horas Abono</label>
                            <input type="text" class="form-control time" id="hours_absence" name="hours_absence" placeholder="Horas Abono" value="{{ isset($absence->hours_absence) ? $absence->hours_absence : old('hours_absence') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="description">Descrição</label>
                            <input type="text" class="form-control" id="description" name="description" placeholder="Descrição" value="{{ isset($absence->description) ? $absence->description : old('description') }}" >
                        </div>

                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script src="{{ asset('js/form_schedule_work.js') }}" defer></script>

@endsection
