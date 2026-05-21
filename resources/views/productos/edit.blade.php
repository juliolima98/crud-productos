
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Editar Producto</h1>
    <form action="{{ route('productos.update', $producto->id) }}" method="post">
        @csrf
        @method('PUT')
        @include('productos.partials._form', ['buttonText' => 'Actualizar'])
    </form>
    <a href="{{ route('productos.index') }}">Volver</a>
</body>
</html>