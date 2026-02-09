<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Product;
use App\Models\Location;

class PublicMenu extends Component
{
    public $location; // El objeto Location
    public $selectedCategory = null;

    public function mount($slug)
    {
        // Buscamos el local por su slug de la URL (ej: bar-centro)
        $this->location = Location::where('slug', $slug)->firstOrFail();
    }

    public function selectCategory($id)
    {
        $this->selectedCategory = $id === $this->selectedCategory ? null : $id;
    }

    public function render()
    {
        // 1. Cargamos categorías SOLO de este local
        $categories = Category::where('location_id', $this->location->id)->get();

        // 2. Buscamos específicamente si existe la categoría "Promo" (insensible a mayúsculas)
        $promoCategory = $categories->first(function ($cat) {
            return strtolower($cat->name) === 'promo';
        });

        $promoProducts = collect(); // Colección vacía por defecto

        if ($promoCategory) {
            // Si existe la categoría, traemos sus productos para el carrusel
            $promoProducts = Product::where('category_id', $promoCategory->id)
                ->where('is_available', true)
                ->latest()
                ->get();
        }

        // 3. Productos del listado general (Lógica original)
        $products = Product::query()
            ->whereHas('category', function ($query) {
                // Filtramos productos cuya categoría pertenezca a ESTE local
                $query->where('location_id', $this->location->id);
            })
            ->when($this->selectedCategory, function ($query) {
                $query->where('category_id', $this->selectedCategory);
            })
            ->where('is_available', true)
            ->get();

        return view('livewire.public-menu', [
            'categories' => $categories,
            'products' => $products,
            'promoProducts' => $promoProducts, // Pasamos las promos a la vista
            'locationName' => $this->location->name // Para el título
        ]);
    }
}
