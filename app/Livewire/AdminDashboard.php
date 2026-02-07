<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Location;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
// --- IMPORTACIONES PARA EL QR (BaconQrCode v3) ---
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
// ------------------------------------------------
use Livewire\Component;
use Livewire\WithFileUploads;

class AdminDashboard extends Component
{
    use WithFileUploads;

    // Estados de Flujo
    public $passcode = '';

    public $isAuthenticated = false;

    public $selectedLocationId = null; // ID del local seleccionado

    public $selectedLocationName = '';

    // Navegación interna
    public $view = 'list';

    public $search = '';

    // Inputs Formulario
    public $productId = null;
    public $name;
    public $description;
    public $price;
    public $category_id;
    public $image;
    public $currentImage;
    public $cat_name;

    public function mount()
    {
        $this->isAuthenticated = Session::get('admin_logged_in', false);
        $this->selectedLocationId = Session::get('admin_location_id', null);

        if ($this->selectedLocationId) {
            $this->selectedLocationName = Location::find($this->selectedLocationId)->name ?? '';
        }
    }

    public function login()
    {
        if ($this->passcode === '2468') {
            Session::put('admin_logged_in', true);
            $this->isAuthenticated = true;
            $this->passcode = '';
        } else {
            $this->addError('passcode', 'Código incorrecto');
        }
    }

    public function selectLocation($id)
    {
        $location = Location::find($id);
        if ($location) {
            $this->selectedLocationId = $id;
            $this->selectedLocationName = $location->name;
            Session::put('admin_location_id', $id);
            $this->view = 'list';
        }
    }

    public function switchLocation()
    {
        $this->selectedLocationId = null;
        Session::forget('admin_location_id');
        $this->view = 'list';
    }

    public function logout()
    {
        Session::forget('admin_logged_in');
        Session::forget('admin_location_id');
        $this->isAuthenticated = false;
        $this->selectedLocationId = null;
    }

    // --- Helpers UI ---

    public function changeView($viewName)
    {
        $this->view = $viewName;
        if ($viewName === 'create_product') {
            $this->resetForm();
        }
    }

    public function resetForm()
    {
        $this->reset(['name', 'description', 'price', 'category_id', 'image', 'productId', 'currentImage']);
        $this->resetErrorBag();
    }

    // --- Categorías ---

    public function saveCategory()
    {
        $this->validate(['cat_name' => 'required|min:3']);

        Category::create([
            'name' => $this->cat_name,
            'location_id' => $this->selectedLocationId,
        ]);

        $this->reset('cat_name');
        session()->flash('message', 'Categoría creada en ' . $this->selectedLocationName);
    }

    public function deleteCategory($id)
    {
        Category::where('id', $id)->where('location_id', $this->selectedLocationId)->delete();
        session()->flash('message', 'Categoría eliminada.');
    }

    // --- Productos ---

    public function editProduct($id)
    {
        $product = Product::find($id);
        if ($product && $product->category->location_id == $this->selectedLocationId) {
            $this->productId = $product->id;
            $this->name = $product->name;
            $this->description = $product->description;
            $this->price = $product->price;
            $this->category_id = $product->category_id;
            $this->currentImage = $product->image_path;
            $this->view = 'create_product';
        }
    }

    public function saveProduct()
    {
        $this->validate([
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:51200',
        ]);

        $category = Category::find($this->category_id);
        if ($category->location_id != $this->selectedLocationId) {
            $this->addError('category_id', 'Categoría inválida.');
            return;
        }

        if ($this->productId) {
            $product = Product::find($this->productId);
            $data = [
                'name' => $this->name,
                'description' => $this->description,
                'price' => $this->price,
                'category_id' => $this->category_id,
            ];
            if ($this->image) {
                if ($product->image_path) {
                    Storage::disk('public')->delete($product->image_path);
                }
                $data['image_path'] = $this->image->store('products', 'public');
            }
            $product->update($data);
            session()->flash('message', 'Producto actualizado.');
        } else {
            $path = $this->image ? $this->image->store('products', 'public') : null;
            Product::create([
                'name' => $this->name,
                'description' => $this->description,
                'price' => $this->price,
                'category_id' => $this->category_id,
                'image_path' => $path,
            ]);
            session()->flash('message', 'Producto creado.');
        }
        $this->resetForm();
        $this->view = 'list';
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);
        if ($product && $product->category->location_id == $this->selectedLocationId) {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $product->delete();
            session()->flash('message', 'Producto eliminado.');
        }
    }

    // --- GENERADOR DE QR (Lógica Manual con BaconQrCode) ---

    protected function generateQrSvg($url, $size = 250)
    {
        // Configuramos el renderizador para SVG
        $renderer = new ImageRenderer(
            new RendererStyle($size),
            new SvgImageBackEnd()
        );

        // Creamos el escritor
        $writer = new Writer($renderer);

        // Retornamos el string del SVG
        return $writer->writeString($url);
    }

    public function downloadQr()
    {
        $location = Location::find($this->selectedLocationId);

        if (!$location) return;

        // URL Pública
        $url = route('menu.show', ['slug' => $location->slug]);

        // Generamos contenido SVG grande para imprimir (500px)
        $svgContent = $this->generateQrSvg($url, 500);

        // Forzamos la descarga del archivo
        return response()->streamDownload(function () use ($svgContent) {
            echo $svgContent;
        }, 'qr-' . $location->slug . '.svg');
    }

    public function render()
    {
        $locations = [];
        if ($this->isAuthenticated && !$this->selectedLocationId) {
            $locations = Location::all();
        }

        $categories = [];
        $products = [];
        $qrSvg = ''; // Variable para almacenar el dibujo del QR
        $qrUrl = ''; // Variable para mostrar la URL en texto

        if ($this->selectedLocationId) {
            $categories = Category::where('location_id', $this->selectedLocationId)
                ->withCount('products')
                ->get();

            // Inicio de la consulta base filtrada por Local
            $productsQuery = Product::query()
                ->whereHas('category', function ($q) {
                    $q->where('location_id', $this->selectedLocationId);
                })
                ->with('category')
                ->latest();

            // Lógica de Búsqueda Mejorada (Nombre O Categoría)
            if (!empty($this->search)) {
                $term = '%' . $this->search . '%';

                $productsQuery->where(function ($query) use ($term) {
                    // Busca por nombre del producto
                    $query->where('name', 'like', $term)
                        // O busca por nombre de la categoría relacionada
                        ->orWhereHas('category', function ($q) use ($term) {
                            $q->where('name', 'like', $term);
                        });
                });
            }

            $products = $productsQuery->get();

            // --- Generación del QR para la vista ---
            $location = Location::find($this->selectedLocationId);
            if ($location) {
                $qrUrl = route('menu.show', ['slug' => $location->slug]);
                $qrSvg = $this->generateQrSvg($qrUrl, 250);
            }
        }

        return view('livewire.admin-dashboard', [
            'locations' => $locations,
            'categories' => $categories,
            'products' => $products,
            'qrSvg' => $qrSvg, // Pasamos el dibujo SVG a la vista
            'qrUrl' => $qrUrl  // Pasamos la URL texto a la vista
        ]);
    }
}
