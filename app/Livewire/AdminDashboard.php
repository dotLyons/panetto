<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Location;
use App\Models\Product;
use App\Models\SurveyEntry;
use App\Models\RaffleEntry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

use Livewire\Component;
use Livewire\WithFileUploads;

class AdminDashboard extends Component
{
    use WithFileUploads;

    public $selectedLocationId = null;

    public $selectedLocationName = '';

    public $view = 'list';

    public $search = '';

    public $productId = null;
    public $name;
    public $description;
    public $price;
    public $category_id;
    public $image;
    public $currentImage;
    public $cat_name;

    public $active = true;

    public $winner = null;

    public function mount()
    {
        if (!Auth::check()) {
            $this->redirect(route('login'), navigate: true);
            return;
        }

        $user = Auth::user();
        $locationId = $user->location_id ?? session('admin_location_id');

        if (!$locationId) {
            $this->redirect(route('login'), navigate: true);
            return;
        }

        $this->selectedLocationId = $locationId;
        $location = Location::find($this->selectedLocationId);
        $this->selectedLocationName = $location?->name ?? '';
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
        $this->reset(['name', 'description', 'price', 'category_id', 'image', 'productId', 'currentImage', 'active']);
        $this->resetErrorBag();
    }


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

    public function pickWinner()
    {
        $this->winner = RaffleEntry::inRandomOrder()->first();
    }

    public function resetWinner()
    {
        $this->winner = null;
    }


    public function editProduct($id)
    {
        $product = Product::find($id);
        if ($product && $product->category->location_id == $this->selectedLocationId) {
            $this->productId = $product->id;
            $this->name = $product->name;
            $this->description = $product->description;
            $this->price = $product->price;
            $this->category_id = $product->category_id;
            $this->active = $product->active;
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
            'active' => 'boolean'
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
                'active' => $this->active,
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
                'active' => $this->active,
                'image_path' => $path,
            ]);
            session()->flash('message', 'Producto creado.');
        }
        $this->resetForm();
        $this->view = 'list';
    }

    public function toggleProductVisibility($id)
    {
        $product = Product::find($id);
        if ($product && $product->category->location_id == $this->selectedLocationId) {
            $product->active = !$product->active;
            $product->save();
        }
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


    protected function generateQrSvg($url, $size = 250)
    {
        $renderer = new ImageRenderer(
            new RendererStyle($size),
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);

        return $writer->writeString($url);
    }

    public function downloadQr()
    {
        $location = Location::find($this->selectedLocationId);

        if (!$location) return;

        $url = route('menu.show', ['slug' => $location->slug]);

        $svgContent = $this->generateQrSvg($url, 500);

        return response()->streamDownload(function () use ($svgContent) {
            echo $svgContent;
        }, 'qr-' . $location->slug . '.svg');
    }

    public function render()
    {
        $categories = [];
        $products = [];
        $surveys = [];
        $raffles = [];
        $qrSvg = '';
        $qrUrl = '';

        if ($this->selectedLocationId) {
            $categories = Category::where('location_id', $this->selectedLocationId)
                ->withCount('products')
                ->get();

            $productsQuery = Product::query()
                ->whereHas('category', function ($q) {
                    $q->where('location_id', $this->selectedLocationId);
                })
                ->with('category')
                ->latest();

            if (!empty($this->search)) {
                $term = '%' . $this->search . '%';

                $productsQuery->where(function ($query) use ($term) {
                    $query->where('name', 'like', $term)
                        ->orWhereHas('category', function ($q) use ($term) {
                            $q->where('name', 'like', $term);
                        });
                });
            }

            $products = $productsQuery->get();

            if ($this->view === 'survey') {
                $surveys = SurveyEntry::latest()->get();
            }

            if ($this->view === 'raffle') {
                $raffles = RaffleEntry::latest()->get();
            }

            $location = Location::find($this->selectedLocationId);
            if ($location) {
                $qrUrl = route('menu.show', ['slug' => $location->slug]);
                $qrSvg = $this->generateQrSvg($qrUrl, 250);
            }
        }

        return view('livewire.admin-dashboard', [
            'categories' => $categories,
            'products' => $products,
            'surveys' => $surveys,
            'raffles' => $raffles,
            'qrSvg' => $qrSvg,
            'qrUrl' => $qrUrl
        ]);
    }
}
