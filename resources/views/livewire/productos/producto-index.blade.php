<div>
    {{-- 
        Todo componente de Livewire V3 debe tener un único elemento raíz o contenedor.
        En este caso es este <div> principal. 
    --}}
    <h1>productos con Livewire</h1>

    {{-- Mostrar mensajes flash (como el que enviamos al eliminar un producto) --}}
    @if (session('success'))
        <p style="color: green;">
            {{ session('success') }}
        </p>
    @endif

    <div style="margin-bottom: 15px;">
        {{-- 
            wire:model.live="search":
            "wire:model" enlaza este input con la variable $search del componente PHP.
            ".live" hace que cada vez que se escriba, se envíe automáticamente al servidor para filtrar en tiempo real. 
        --}}
        <input type="text" wire:model.live="search" placeholder="Buscar producto...">

        {{-- Igual que el buscador, enlaza el select con la propiedad $categoryId --}}
        <select wire:model.live="categoryId">
            <option value="">Todas las categorías</option>

            @foreach ($categorias as $categoria)
                <option value="{{ $categoria->id }}">
                    {{ $categoria->name }}
                </option>
            @endforeach
        </select>
    </div>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Activo</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            {{-- Bucle para recorrer la variable $productos que nos envió el componente PHP --}}
            @forelse ($productos as $producto)
                {{-- 
                    wire:key es OBLIGATORIO en bucles dentro de Livewire.
                    Le ayuda a Livewire a llevar el rastro exacto de qué fila es cuál cuando se redibuja la tabla.
                --}}
                <tr wire:key="producto-{{ $producto->id }}">
                    <td>{{ $producto->name }}</td>
                    
                    {{-- Usamos el nullsafe operator (?->) para evitar un error si el producto no tiene categoría --}}
                    <td>{{ $producto->categorias?->name ?? 'Sin categoría' }}</td>
                    
                    <td>${{ number_format($producto->price, 2) }}</td>
                    <td>{{ $producto->stock }}</td>
                    <td>{{ $producto->active ? 'Sí' : 'No' }}</td>
                    <td>
                        {{-- 
                            wire:click="delete(...)": Ejecuta la función delete() del componente PHP.
                            wire:confirm="...": Es una directiva de Livewire que muestra un cuadro de confirmación nativo del navegador antes de ejecutar la acción.
                        --}}
                        <button type="button" wire:click="delete({{ $producto->id }})"
                            wire:confirm="¿Seguro que deseas eliminar este producto?">
                            Eliminar
                        </button>
                    </td>
                </tr>
            @empty
                {{-- @empty se ejecuta si el array/colección $productos está vacío --}}
                <tr>
                    <td colspan="6">No hay productos.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 15px;">
        {{-- Muestra los enlaces de paginación de Laravel --}}
        {{ $productos->links() }}
    </div>
</div>