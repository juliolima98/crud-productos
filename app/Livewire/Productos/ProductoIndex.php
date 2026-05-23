<?php

namespace App\Livewire\Productos;

use App\Models\Categorias;
use App\Models\Productos;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * COMPONENTE LIVEWIRE: ProductoIndex
 * Livewire permite crear interfaces dinámicas usando solo PHP, sin escribir JavaScript manual.
 * Cada propiedad pública de esta clase está disponible en la vista Blade y viceversa.
 */
class ProductoIndex extends Component
{
    // Trait para usar paginación de Livewire sin recargar la página completa
    use WithPagination;

    // PROPIEDAD DE PAGINACIÓN: Usa Bootstrap 5 para los enlaces de paginación en lugar de Tailwind CSS.
    // ESTO EVITA EL PROBLEMA DE LOS ÍCONOS DE FLECHAS GIGANTES en la tabla.
    protected $paginationTheme = 'bootstrap';

    // Estas variables están atadas (data binding) a los inputs en la vista usando wire:model
    public string $search = '';
    public string $categoryId = '';
    public string $name = '';
    public string $description = '';
    public string $price = '';
    public int|string $stock = 0;
    public bool $active = true;
    public string $formCategoryId = '';
    public ?int $editingId = null;

    /**
     * HOOKS DE CICLO DE VIDA (Lifecycle Hooks)
     * updatingSearch() se ejecuta JUSTO ANTES de que la propiedad $search se actualice.
     * Aquí reseteamos la página a la 1 cuando el usuario escribe algo en el buscador,
     * de lo contrario si estuviera en la página 3 de resultados y busca algo nuevo, podría no ver nada.
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryId()
    {
        $this->resetPage();
    }

    /**
     * ACCIÓN DEL COMPONENTE
     * Este método es llamado desde la vista con wire:click="delete(id)".
     * Gracias a "Route Model Binding" de Laravel, pasamos el ID en la vista pero aquí recibimos el modelo completo.
     */
    public function delete(Productos $producto)
    {
        $producto->delete();

        // flash() guarda un mensaje en sesión que solo dura hasta la siguiente petición (o renderizado actual)
        session()->flash('success', 'Producto eliminado correctamente.');
    }

    /**
     * MÉTODO RENDER
     * Es el corazón del componente. Se ejecuta inicialmente y cada vez que cambia una propiedad pública.
     * Retorna la vista Blade que se dibujará en pantalla.
     */
    public function render()
    {
        $categorias = Categorias::orderBy('name')->get();

        // Consulta de productos dinámica:
        // Se cargan las categorías ('with') para evitar el problema de consultas "N+1".
        $productos = Productos::with('categorias')
            // when() de Eloquent solo aplica la condición si el primer parámetro ($this->search) es verdadero/no vacío
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->categoryId, function ($query) {
                $query->where('category_id', $this->categoryId);
            })
            // latest() ordena por 'created_at' de forma descendente (los más nuevos primero)
            ->latest()
            // paginate() corta los resultados en bloques (ej: de 10 en 10)
            ->paginate(10);

        // Se pasa la información recopilada a la vista blade del componente
        return view('livewire.productos.producto-index', [
            'productos' => $productos,
            'categorias' => $categorias,
        ]);
    }

    /**
     * MÉTODO SAVE: CREAR O ACTUALIZAR PRODUCTOS
     * Se ejecuta al enviar el formulario (gracias al wire:submit.prevent="save").
     */
    public function save()
    {
        // 1. Validar los datos ingresados en el formulario.
        // Si hay algún error, Livewire lo devuelve automáticamente a la vista para mostrarlo.
        $data = $this->validate([
            'formCategoryId' => 'nullable|exists:categorias,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'active' => 'boolean',
        ]);

        $payload = [
            'category_id' => $data['formCategoryId'] ?: null,
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'active' => $data['active'],
        ];

        if ($this->editingId) {
            $producto = Productos::findOrFail($this->editingId);
            $producto->update($payload);

            session()->flash('success', 'Producto actualizado correctamente.');
        } else {
            Productos::create($payload);

            session()->flash('success', 'Producto creado correctamente.');
        }

        $this->resetForm();
    }

    /**
     * MÉTODO EDIT: CARGAR DATOS AL FORMULARIO
     * Se llama desde la tabla al hacer clic en "Editar".
     * Carga el producto de la BD y llena las propiedades públicas,
     * las cuales actualizan automáticamente los "wire:model" en la vista.
     */
    public function edit(Productos $producto)
    {
        $this->editingId = $producto->id;
        $this->formCategoryId = $producto->category_id ?? '';
        $this->name = $producto->name;
        $this->description = $producto->description ?? '';
        $this->price = $producto->price;
        $this->stock = $producto->stock;
        $this->active = (bool) $producto->active;
    }

    /**
     * MÉTODO RESET FORM: LIMPIAR EL FORMULARIO
     * Devuelve las variables a su estado original después de guardar o cancelar.
     */
    public function resetForm()
    {
        $this->reset([
            'editingId',
            'name',
            'description',
            'price',
            'stock',
            'active',
            'formCategoryId',
        ]);

        $this->stock = 0;
        $this->active = true;
    }
}