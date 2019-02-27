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

                    <form method="POST" action="{{ route('save.customer') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="name">Nome</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nome" value="{{ isset($customer->name) ? $customer->name : old('name') }}" required>
                        </div>

                        @if($customer->id)
                            <input type="hidden" name="id" value="{{ $customer->id }}">
                        @endif

                        <div class="form-group">
                            <label for="customer_type">Tipo Cadastro</label>
                            <select class="form-control" id="customer_type" name="customer_type">
                                <option value="1" {{ $customer->customer_type == 1 ? 'selected' : '' }} >Pessoa Fisica</option>
                                <option value="2" {{ $customer->customer_type == 2 ? 'selected' : '' }}>Pessoa Juridica</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="contract_type">Tipo de Contrato</label>
                            <select class="form-control" id="contract_type" name="contract_type">
                                <option value="">Selectine uma opção</option>
                                <option value="1" {{ $customer->contract_type == 1 ? 'selected' : '' }} >Carteira Assinada</option>
                                <option value="2" {{ $customer->contract_type == 2 ? 'selected' : '' }}>Prestação de serviços</option>
                            </select>
                        </div>
  
                        <div class="form-group">
                            <label for="customer_document">CPF/CNPJ</label>
                            <input type="text" class="form-control" id="customer_document" customer_document="customer_document" placeholder="CPF/CNPJ" value="{{ isset($customer->customer_document) ? $customer->customer_document : old('customer_document') }}" >
                        </div>

                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="E-mail" value="{{ isset($customer->email) ? $customer->email : old('email') }}" >
                        </div>

                        <div class="form-group">
                            <label for="phone">Telefone</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Telefone" value="{{ isset($customer->phone) ? $customer->phone : old('phone') }}" >
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
