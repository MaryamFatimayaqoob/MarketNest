<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;  

class AdminController extends Controller
{

    public function index()
    {
        return view('admin.index');
    }


    public function brands(Request $request)
{
    if ($request->ajax()) {
        $brands = Brand::withCount('products')->select(['id', 'name', 'slug', 'image', 'created_at']);
        return DataTables::of($brands)
            ->addColumn('image', function($brand) {
                return '<img src="' . asset('uploads/brands/' . $brand->image) . '" width="50" height="50" style="border-radius:8px; object-fit:cover;">';
            })
            ->addColumn('products_count', function($brand) {
                return $brand->products_count;
            })
            ->addColumn('action', function($brand) {
                return '
                    <div class="list-icon-function">
                        <a href="' . route('admin.brand.edit', $brand->id) . '" class="item edit">
                            <i class="icon-edit-3"></i>
                        </a>
                        <form action="' . route('admin.brand.delete', $brand->id) . '" method="POST" class="d-inline">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="button" class="item text-danger delete-brand">
                                <i class="icon-trash-2"></i>
                            </button>
                        </form>
                    </div>
                ';
            })
            ->rawColumns(['image', 'action'])
            ->make(true);
    }
    
    return view('admin.brands');
}

    public function add_brand()
    {
        return view('admin.brand-add');
    }

    public function brand_store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'slug'  => 'required|unique:brands,slug',
            'image' => 'required|image|mimes:png,jpg,jpeg|max:2048'
        ]);

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);

        $image = $request->file('image');
        $imageName = Carbon::now()->timestamp . '.' . $image->extension();

        $this->generateBrandThumbnailImage($image, $imageName);
        $brand->image = $imageName;
        $brand->save();

        return redirect()->route('admin.brands')->with('status', 'Brand added successfully');
    }

    public function edit_brand($id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brand-edit', compact('brand'));
    }

    public function update_brand(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'slug'  => 'required|unique:brands,slug,' . $id,
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048'
        ]);

        $brand = Brand::findOrFail($id);
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);

        if ($request->hasFile('image')) {
            if ($brand->image && file_exists(public_path('uploads/brands/' . $brand->image))) {
                unlink(public_path('uploads/brands/' . $brand->image));
            }
            $image = $request->file('image');
            $imageName = Carbon::now()->timestamp . '.' . $image->extension();
            $this->generateBrandThumbnailImage($image, $imageName);
            $brand->image = $imageName;
        }

        $brand->save();
        return redirect()->route('admin.brands')->with('status', 'Brand updated successfully');
    }

    public function brand_delete($id)
    {
        $brand = Brand::findOrFail($id);
        $imagePath = public_path('uploads/brands/' . $brand->image);
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }
        $brand->delete();
        return redirect()->route('admin.brands')->with('status', 'Brand deleted successfully');
    }

    public function generateBrandThumbnailImage($image, $imageName)
    {
        $destinationPath = public_path('uploads/brands');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        $manager = new ImageManager(new Driver());
        $img = $manager->read($image);
        $img->resize(124, 124, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($destinationPath . '/' . $imageName);
    }


    public function categories(Request $request)
{
    if ($request->ajax()) {
        $categories = Category::withCount('products')->select('categories.*');
        return DataTables::of($categories)
            ->addColumn('image', function($category) {
                if ($category->image) {
                    return '<img src="' . asset('uploads/categories/' . $category->image) . '" width="50" height="50" style="border-radius:8px; object-fit:cover;">';
                }
                return '<span class="text-muted">No Image</span>';
            })
            ->addColumn('products_count', function($category) {
                return $category->products_count;
            })
            ->addColumn('action', function($category) {
                return '
                    <div class="list-icon-function">
                        <a href="' . route('admin.category.edit', $category->id) . '" class="item edit">
                            <i class="icon-edit-3"></i>
                        </a>
                        <form action="' . route('admin.category.delete', $category->id) . '" method="POST" class="d-inline">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="button" class="item text-danger delete-category">
                                <i class="icon-trash-2"></i>
                            </button>
                        </form>
                    </div>
                ';
            })
            ->rawColumns(['image', 'action'])
            ->make(true);
    }
    
    return view('admin.categories');
}
    public function add_category()
    {
        return view('admin.category-add');
    }

    public function category_store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'slug'      => 'required|unique:categories,slug',
            'parent_id' => 'nullable|exists:categories,id',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->slug);
        $category->parent_id = $request->parent_id;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $this->generateThumbnail($image, $imageName, 'categories');
            $category->image = $imageName;
        }

        $category->save();
        return redirect()->route('admin.categories')->with('status', 'Category added successfully');
    }

    public function edit_category($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category-edit', compact('category'));
    }

    public function update_category(Request $request, $id)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'slug'      => 'required|unique:categories,slug,' . $id,
            'parent_id' => 'nullable|exists:categories,id',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->slug);
        $category->parent_id = $request->parent_id;

        if ($request->hasFile('image')) {
            if ($category->image && file_exists(public_path('uploads/categories/' . $category->image))) {
                unlink(public_path('uploads/categories/' . $category->image));
            }
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $this->generateThumbnail($image, $imageName, 'categories');
            $category->image = $imageName;
        }

        $category->save();
        return redirect()->route('admin.categories')->with('status', 'Category updated successfully');
    }

    public function category_delete($id)
    {
        $category = Category::findOrFail($id);
        if ($category->image && file_exists(public_path('uploads/categories/' . $category->image))) {
            unlink(public_path('uploads/categories/' . $category->image));
        }
        $category->delete();
        return redirect()->route('admin.categories')->with('status', 'Category deleted successfully');
    }

    public function generateThumbnail($image, $imageName, $folder)
    {
        $destinationPath = public_path('uploads/' . $folder);
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        $manager = new ImageManager(new Driver());
        $img = $manager->read($image);
        $img->resize(150, 150, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($destinationPath . '/' . $imageName);
    }


   public function products(Request $request)
{
    if ($request->ajax()) {
        $products = Product::with(['category', 'brand'])->select('products.*');
        return DataTables::of($products)
            ->addColumn('name_display', function($product) {
                return '
                    <div class="pname">
                        <div class="image">
                            <img src="' . asset('uploads/products/thumbnails/' . $product->image) . '" alt="' . $product->name . '" class="image">
                        </div>
                        <div class="name">
                            <a href="#" class="body-title-2">' . $product->name . '</a>
                            <div class="text-tiny mt-3">' . $product->slug . '</div>
                        </div>
                    </div>
                ';
            })
            ->addColumn('category_name', function($product) {
                return $product->category ? $product->category->name : 'N/A';
            })
            ->addColumn('brand_name', function($product) {
                return $product->brand ? $product->brand->name : 'N/A';
            })
            ->addColumn('featured', function($product) {
                return $product->featured ? 'Yes' : 'No';
            })
            ->addColumn('stock_badge', function($product) {
                if ($product->stock_status == 'instock') {
                    return '<span class="badge bg-success">In Stock</span>';
                }
                return '<span class="badge bg-danger">Out of Stock</span>';
            })
            ->addColumn('action', function($product) {
                return '
                    <div class="list-icon-function">
                        <a href="#" target="_blank">
                            <div class="item eye">
                                <i class="icon-eye"></i>
                            </div>
                        </a>
                        <a href="' . route('admin.product.edit', $product->id) . '">
                            <div class="item edit">
                                <i class="icon-edit-3"></i>
                            </div>
                        </a>
                        <form action="' . route('admin.product.delete', $product->id) . '" method="POST" class="d-inline">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="button" class="item text-danger delete-product">
                                <i class="icon-trash-2"></i>
                            </button>
                        </form>
                    </div>
                ';
            })
            ->rawColumns(['name_display', 'stock_badge', 'action'])
            ->make(true);
    }
    
    return view('admin.products');
}

    public function product_add()
    {
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $brands = Brand::select('id', 'name')->orderBy('name')->get();
        return view('admin.product-add', compact('categories', 'brands'));
    }

    public function product_store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'slug'             => 'required|unique:products,slug',
            'short_description'=> 'nullable|string',
            'description'      => 'nullable|string',
            'regular_price'    => 'required|numeric',
            'sale_price'       => 'nullable|numeric',
            'SKU'              => 'required|unique:products,SKU',
            'stock_status'     => 'required|in:instock,outofstock',
            'featured'         => 'nullable',
            'quantity'         => 'required|integer|min:0',
            'image'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'category_id'      => 'nullable|exists:categories,id',
            'brand_id'         => 'nullable|exists:brands,id',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::slug($request->slug ?: $request->name);
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->SKU = $request->SKU;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->has('featured') ? 1 : 0;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $destinationPath = public_path('uploads/products');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $image->move($destinationPath, $imageName);
            $product->image = $imageName;
        }

        $product->save();
        return redirect()->route('admin.products')->with('status', 'Product created successfully');
    }

    public function product_edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $brands = Brand::select('id', 'name')->orderBy('name')->get();
        return view('admin.product-edit', compact('product', 'categories', 'brands'));
    }

    public function product_update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|unique:products,slug,' . $id,
            'regular_price' => 'required|numeric',
            'sale_price' => 'nullable|numeric',
            'SKU' => 'required|unique:products,SKU,' . $id,
            'quantity' => 'required|integer|min:0',
            'stock_status' => 'required|in:instock,outofstock',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->slug = Str::slug($request->slug);
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->SKU = $request->SKU;
        $product->quantity = $request->quantity;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->has('featured') ? 1 : 0;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->short_description = $request->short_description;
        $product->description = $request->description;

        if ($request->hasFile('image')) {
            if ($product->image && file_exists(public_path('uploads/products/' . $product->image))) {
                unlink(public_path('uploads/products/' . $product->image));
            }
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('uploads/products'), $imageName);
            $product->image = $imageName;
        }

        $product->save();
        return redirect()->route('admin.products')->with('status', 'Product updated successfully');
    }

    public function product_delete($id)
    {
        $product = Product::findOrFail($id);
        $mainImagePath = public_path('uploads/products/' . $product->image);
        if ($product->image && file_exists($mainImagePath)) {
            unlink($mainImagePath);
        }
        $product->delete();
        return redirect()->route('admin.products')->with('status', 'Product deleted successfully');
    }

    public function generateProductThumbnailImage($image, $imageName)
    {
        $destinationPath = public_path('uploads/products/thumbnails');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        $manager = new ImageManager(new Driver());
        $img = $manager->read($image);
        $img->cover(300, 300);
        $img->save($destinationPath . '/' . $imageName);
    }


   public function orders(Request $request)
{
    if ($request->ajax()) {
        $orders = Order::withCount('orderItems')->select('orders.*');
        return DataTables::of($orders)
            ->addColumn('order_number', function($order) {
                return str_pad($order->id, 4, '0', STR_PAD_LEFT);
            })
            ->addColumn('total_formatted', function($order) {
                return '$' . number_format($order->total, 2);
            })
            ->addColumn('status_badge', function($order) {
                $badges = [
                    'ordered' => 'bg-warning',
                    'pending' => 'bg-warning',
                    'processing' => 'bg-info',
                    'shipped' => 'bg-primary',
                    'delivered' => 'bg-success',
                    'cancelled' => 'bg-danger',
                    'canceled' => 'bg-danger'
                ];
                $badgeClass = $badges[$order->status] ?? 'bg-secondary';
                return '<span class="badge ' . $badgeClass . '">' . ucfirst($order->status) . '</span>';
            })
            ->addColumn('created_at_formatted', function($order) {
                return $order->created_at->format('M d, Y');
            })
            ->addColumn('items_count', function($order) {
                return $order->orderItems->count() ?? 0;
            })
            ->addColumn('delivered_date_formatted', function($order) {
                return $order->delivered_date ? date('M d, Y', strtotime($order->delivered_date)) : 'Pending';
            })
            ->addColumn('action', function($order) {
                return '
                    <a href="' . route('admin.order.items', ['order_id' => $order->id]) . '">
                        <div class="list-icon-function view-icon">
                            <div class="item eye">
                                <i class="icon-eye"></i>
                            </div>                                        
                        </div>
                    </a>
                ';
            })
            ->rawColumns(['status_badge', 'action'])
            ->make(true);
    }
    
    return view('admin.orders');
}
    public function order_items($order_id)
    {
        $order = Order::with('orderItems')->findOrFail($order_id);
        $orderitems = OrderItem::where('order_id', $order_id)->orderBy('id')->paginate(12);
        $transaction = Transaction::where('order_id', $order_id)->first();
        return view('admin.order-details', compact('order', 'orderitems', 'transaction'));
    }

    public function update_status(Request $request, $id)
    {
        $order = Order::find($id);
        $order->status = $request->status;
        $order->save();
        return back()->with('success', 'Status updated');
    }

    public function update_order_status(Request $request)
    {        
        $order = Order::find($request->order_id);
        
        if ($order->status == 'canceled') {
            return back()->with('error', 'Cannot update canceled orders!');
        }
        
        $order->status = $request->order_status;
        
        if ($request->order_status == 'delivered') {
            $order->delivered_date = Carbon::now();
        } elseif ($request->order_status == 'canceled') {
            $order->canceled_date = Carbon::now();
        }
        
        $order->save();
        
        if ($request->order_status == 'delivered') {
            $transaction = Transaction::where('order_id', $request->order_id)->first();
            if ($transaction) {
                $transaction->status = 'approved';
                $transaction->save();
            }
        }
        
        return back()->with('status', 'Status changed successfully!');
    }


    public function contacts()
    {
        $contacts = Contact::orderBy('created_at', 'DESC')->paginate(15);
        return view('admin.contacts', compact('contacts'));
    }

    public function contact_read($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->is_read = true;
        $contact->save();
        return back()->with('success', 'Message marked as read');
    }
}
