<div>
    <label for="name">Nombre</label>
    <input 
        type="text" 
        name="name" 
        id="name"
        value="{{ old('name', $producto->name ?? '') }}"
    >

    @error('name')
        <p style="color: red;">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="description">Descripción</label>
    <textarea 
        name="description" 
        id="description"
    >{{ old('description', $producto->description ?? '') }}</textarea>

    @error('description')
        <p style="color: red;">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="price">Precio</label>
    <input 
        type="number" 
        step="0.01"
        name="price" 
        id="price"
        value="{{ old('price', $producto->price ?? '') }}"
    >

    @error('price')
        <p style="color: red;">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="stock">Stock</label>
    <input 
        type="number" 
        name="stock" 
        id="stock"
        value="{{ old('stock', $producto->stock ?? 0) }}"
    >

    @error('stock')
        <p style="color: red;">{{ $message }}</p>
    @enderror
</div>

<div>
    <label>
        <input 
            type="checkbox" 
            name="active" 
            value="1"
            {{ old('active', $producto->active ?? true) ? 'checked' : '' }}
        >
        Activo
    </label>

    @error('active')
        <p style="color: red;">{{ $message }}</p>
    @enderror
</div>

<button type="submit">
    {{ $buttonText }}
</button>