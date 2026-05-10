<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ShopController extends Controller
{
    public function index(Request $request)
    {        

        $size = $request->query('size') ? $request->query('size') : 12;
        

        $sorting = $request->query('sorting') ? $request->query('sorting') : 'default';
        

        $f_brands = $request->query('brands');
        

        $f_categories = $request->query('categories');
        

        $query = Product::where('stock_status', 'instock');
        

        if ($f_brands) {
            $brandArray = explode(',', $f_brands);
            $query->whereIn('brand_id', $brandArray);
        }
        

        if ($f_categories) {
            $categoryArray = explode(',', $f_categories);
            $query->whereIn('category_id', $categoryArray);
        }
        

        if ($sorting == 'date') {
            $query->orderBy('created_at', 'DESC');
        } elseif ($sorting == 'price') {
            $query->orderBy('regular_price', 'ASC');
        } elseif ($sorting == 'price-desc') {
            $query->orderBy('regular_price', 'DESC');
        } else {
            $query->orderBy('created_at', 'DESC');
        }
        

        $products = $query->paginate($size);
        

        $categories = Category::orderBy('name', 'ASC')->get();
        $brands = Brand::orderBy('name', 'ASC')->get();
        

        return view('shop', compact('products', 'size', 'sorting', 'categories', 'brands', 'f_brands', 'f_categories'));
    }
    
  public function product_details($slug)
{
    $product = Product::where('slug', $slug)->firstOrFail();
    
    $rproducts = Product::where('category_id', $product->category_id)
        ->where('id', '!=', $product->id)
        ->where('stock_status', 'instock')
        ->take(8)
        ->get();
    
    return view('details', compact('product', 'rproducts'));
}
}

