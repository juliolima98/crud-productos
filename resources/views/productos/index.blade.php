@extends('layouts.app')

@section('title', 'Productos')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="page-title mb-0">Productos</h1>
        <a href="{{ route('productos.create') }}" class="btn btn-primary">Nuevo Producto</a>
    </div>

    <!-- Filtro de Categorías -->
    <div class="card p-3 mb-4 bg-light">
        <form action="{{ route('productos.index') }}" method="GET" class="row g-3 align-items-center">
            <div class="col-auto">
                <label for="category_id" class="col-form-label fw-bold">Filtrar por Categoría:</label>
            </div>
            <div class="col-auto">
                <select name="category_id" id="category_id" class="form-select">
                    <option value="">Todas las categorías</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ request('category_id') == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-secondary">Filtrar</button>
                @if(request('category_id'))
                    <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary">Limpiar</a>
                @endif
            </div>
        </form>
    </div>


    <div class="card p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Categoría</th>
                        <th>Activo?</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($productos as $producto)
                        <tr>
                            <td>{{ $producto->name }}</td>
                            <td class="text-truncate" style="max-width: 200px;">{{ $producto->description }}</td>
                            <td class="fw-bold">${{ number_format($producto->price, 2) }}</td>
                            <td>
                                @if($producto->stock > 10)
                                    <span class="badge bg-success">{{ $producto->stock }}</span>
                                @elseif($producto->stock > 0)
                                    <span class="badge bg-warning text-dark">{{ $producto->stock }}</span>
                                @else
                                    <span class="badge bg-danger">Agotado</span>
                                @endif
                            </td>
                            <td>{{ $producto->categorias?->name ?? 'Sin categoría' }}</td>
                            <td>
                                @if($producto->is_active)
                                    <span class="badge bg-success">Sí</span>
                                @else
                                    <span class="badge bg-danger">No</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('productos.edit', $producto->id) }}"
                                        class="btn btn-sm btn-outline-primary">Editar</a>
                                    <form action="{{ route('productos.destroy', $producto->id) }}" method="post"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('¿Estás seguro de eliminar este producto?')">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No hay productos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection