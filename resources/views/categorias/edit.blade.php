@extends('layouts.app')

@section('title', 'Editar Categoría')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card p-4">
            <h2 class="page-title">Editar Categoría</h2>

            <form action="{{ route('categorias.update', $categoria->id) }}" method="post">
                @csrf
                @method('PUT')
                @include('categorias.partials._form', ['buttonText' => 'Actualizar Categoría'])
            </form>
        </div>
    </div>
</div>
@endsection