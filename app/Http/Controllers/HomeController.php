<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $featured_products = Product::where('stock_status', 'instock')
            ->orderBy('created_at', 'DESC')
            ->take(8)
            ->get();
        
        $categories = Category::orderBy('name', 'ASC')->take(6)->get();
        
        return view('index', compact('featured_products', 'categories'));
    }
    
    public function contact()
    {
        return view('contact');
    }
    
   public function contact_store(Request $request)
{
    $request->validate([
        'name'    => 'required|string|max:255',
        'email'   => 'required|email|max:255',
        'phone'   => 'nullable|string|max:20',
        'message' => 'required|string|min:10|max:1000',
    ]);
    
    Contact::create([
        'name'    => $request->name,
        'email'   => $request->email,
        'phone'   => $request->phone,
        'comment' => $request->message,  
       
    ]);
    
    return redirect()->back()->with('success', 'Thank you for contacting us! We will get back to you soon.');
}
}
