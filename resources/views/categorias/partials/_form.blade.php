<div class="mb-3">
    <label for="name" class="form-label fw-bold">Nombre</label>
    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $categoria->name ?? '') }}">
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label fw-bold">Descripción</label>
    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $categoria->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-4 form-check">
    <!-- El campo hidden asegura que si no se chequea, se envíe un 0 -->
    <input type="hidden" name="is_active" value="0">
    <input type="checkbox" name="is_active" value="1" class="form-check-input @error('is_active') is-invalid @enderror" id="is_active" {{ old('is_active', $categoria->is_active ?? true) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_active">
        Activo
    </label>
    @error('is_active')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

<div class="d-flex justify-content-between pt-3 border-top">
    <a href="{{ route('categorias.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    <button type="submit" class="btn btn-primary px-4">
        {{ $buttonText }}
    </button>
</div>