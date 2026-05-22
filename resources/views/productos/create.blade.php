@extends('layouts.app')

@section('title', 'Crear Producto')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card p-4">
            <h2 class="page-title">Crear Producto</h2>

            <form action="{{ route('productos.store') }}" method="post">
                @csrf
                @include('productos.partials._form', ['buttonText' => 'Guardar Producto'])
            </form>
        </div>
    </div>
</div>
@endsection