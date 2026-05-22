@extends('layouts.app')

@section('title', 'Crear Categoría')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card p-4">
            <h2 class="page-title">Crear Categoría</h2>

            <form action="{{ route('categorias.store') }}" method="post">
                @csrf
                @include('categorias.partials._form', ['buttonText' => 'Guardar Categoría'])
            </form>
        </div>
    </div>
</div>
@endsection