<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Product;

class ReviewController extends Controller
{
    public function store(Request $request, $product_id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:2'
        ]);
        
        $product = Product::findOrFail($product_id);
        

        $existing = Review::where('product_id', $product_id)
            ->where('user_id', auth()->id())
            ->first();
            
        if ($existing) {
            return back()->with('error', 'You have already reviewed this product!');
        }
        
        Review::create([
            'product_id' => $product_id,
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => true
        ]);
        
        return back()->with('success', 'Thank you for your review!');
    }
    public function storeReview(Request $request, $product_id)
{
    $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'required|string|min:2'
    ]);
    

    $existing = \App\Models\Review::where('product_id', $product_id)
        ->where('user_id', auth()->id())
        ->first();
        
    if ($existing) {
        return back()->with('error', 'You have already reviewed this product!');
    }
    
    \App\Models\Review::create([
        'product_id' => $product_id,
        'user_id' => auth()->id(),
        'rating' => $request->rating,
        'comment' => $request->comment,
        'is_approved' => true
    ]);
    
    return back()->with('success', 'Thank you for your review!');
}
}
