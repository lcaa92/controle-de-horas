@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Lista de Clientes
                    <a href="{{ route('form.customers') }}"> Novo cliente</a>
                </div>

                <div class="card-body">
                    @if (session('msg'))
                        <div class="alert alert-{{session('alert')}}">
                            {{ session('msg') }}
                        </div>
                    @endif

                    @if($customers->count() > 0)
                        <div class="table-responsive">
                           <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nome</th>
                                        <th scope="col">Tipo Cliente</th>
                                        <th scope="col">Documento</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Telefone</th>
                                        <th scope="col">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customers as $customer)
                                        <tr>
                                            <td> {{ $customer->id }} </td>
                                            <td> {{ $customer->name }} </td>
                                            <td> {{ $customer->customer_type }} </td>
                                            <td> {{ $customer->customer_document }} </td>
                                            <td> {{ $customer->email }} </td>
                                            <td> {{ $customer->phone }} </td>
                                            <td>
                                                <a href="{{ route('profile.customers', ['id'=>$customer->id]) }}">
                                                    Perfil
                                                </a> 
                                                <a href="{{ route('form.customers', ['id'=>$customer->id]) }}">
                                                    Editar
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        Nenhum cliente cadastrado
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
