<div>
    {{--
    Todo componente de Livewire V3 debe tener un único elemento raíz o contenedor.
    En este caso es este <div> principal.
        --}}
        <h1>productos con Livewire</h1>
        <hr>

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

        <div class="card mb-4">
            <div class="card-header">
                {{-- Mostrar si estamos editando o creando --}}
                {{ $editingId ? 'Editar producto' : 'Crear producto con Livewire' }}
            </div>

            <div class="card-body">
                <form wire:submit.prevent="save">
                    <div class="mb-3">
                        <label class="form-label">Categoría</label>

                        <select class="form-control" wire:model="formCategoryId">
                            <option value="">Sin categoría</option>

                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}">
                                    {{ $categoria->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('formCategoryId')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" wire:model="name">

                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea class="form-control" wire:model="description"></textarea>

                        @error('description')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Precio</label>
                        <input type="number" step="0.01" class="form-control" wire:model="price">

                        @error('price')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Stock</label>
                        <input type="number" class="form-control" wire:model="stock">

                        @error('stock')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" wire:model="active" id="active">
                        <label class="form-check-label" for="active">Activo</label>

                        @error('active')
                            <small class="text-danger d-block">{{ $message }}</small>
                        @enderror
                    </div>

                    @if ($editingId)
                        <button type="submit" class="btn btn-success">
                            Actualizar producto
                        </button>
                        <button type="button" class="btn btn-secondary" wire:click="resetForm">
                            Cancelar
                        </button>
                    @else
                        <button type="submit" class="btn btn-primary">
                            Guardar producto
                        </button>
                    @endif
                </form>
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

                            {{-- Usamos el nullsafe operator (?->) para evitar un error si el producto no tiene categoría
                            --}}
                            <td>{{ $producto->categorias?->name ?? 'Sin categoría' }}</td>

                            <td>${{ number_format($producto->price, 2) }}</td>
                            <td>{{ $producto->stock }}</td>
                            <td>{{ $producto->active ? 'Sí' : 'No' }}</td>
                            <td>
                                {{--
                                wire:click="delete(...)": Ejecuta la función delete() del componente PHP.
                                wire:confirm="...": Es una directiva de Livewire que muestra un cuadro de confirmación
                                nativo del navegador antes de ejecutar la acción.
                                --}}
                                <button type="button" wire:click="delete({{ $producto->id }})"
                                    wire:confirm="¿Seguro que deseas eliminar este producto?">
                                    Eliminar
                                </button>

                                {{-- Botón para editar --}}
                                <button type="button" wire:click="edit({{ $producto->id }})">
                                    Editar
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