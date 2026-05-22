@extends('layouts.app')

@section('title', 'Editar Producto')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card p-4">
            <h2 class="page-title">Editar Producto</h2>

            <form action="{{ route('productos.update', $producto->id) }}" method="post">
                @csrf
                @method('PUT')
                @include('productos.partials._form', ['buttonText' => 'Actualizar Producto'])
            </form>
        </div>
    </div>
</div>
@endsection