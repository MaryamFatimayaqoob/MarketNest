<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Product;
use App\Models\Address;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use App\Models\OrderItem;
use App\Models\Transaction;


class CartController extends Controller
{
   

public function index()
{
    $cartItems = Cart::instance('cart')->content();
    return view('cart',compact('cartItems'));
}
   public function add_To_Cart(Request $request)
{
    Cart::instance('cart')->add($request->id,$request->name,$request->quantity,$request->price)->associate(\App\Models\Product::class);        
    session()->flash('success', 'Product is Added to Cart Successfully !');        
    return response()->json(['status'=>200,'message'=>'Success ! Item Successfully added to your cart.']);
} 
public function increase_item_quantity($rowId)
{
    $product = Cart::instance('cart')->get($rowId);
    $qty = $product->qty + 1;
    Cart::instance('cart')->update($rowId, $qty);

    return redirect()->back();
}

public function reduce_item_quantity($rowId)
{
    $product = Cart::instance('cart')->get($rowId);
    $qty = $product->qty - 1;

    if ($qty < 1) {
        Cart::instance('cart')->remove($rowId);
        return redirect()->back();
    }

    Cart::instance('cart')->update($rowId, $qty);

    return redirect()->back();
}
public function remove_item_from_cart($rowId)
{
    Cart::instance('cart')->remove($rowId);
    return redirect()->back();
}
public function empty_cart()
{
    Cart::instance('cart')->destroy();
    return redirect()->back();
}

public function checkout()
{
    if(!Auth::check())
    {
        return redirect()->route("login");
    }
    $address = Address::where('user_id',Auth::user()->id)->where('isdefault',1)->first();              
    return view('checkout',compact("address"));
}


public function place_order(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'nullable|string',
        'address' => 'nullable|string',
        'city' => 'nullable|string',
        'state' => 'nullable|string',
        'zip' => 'nullable|string',
        'locality' => 'nullable|string',
        'landmark' => 'nullable|string',
    ]);

    $order = new Order();
    

    $order->user_id = Auth::id();
    $order->name = $request->name;
    $order->status = "ordered";
    

    $order->phone = $request->phone;
    $order->address = $request->address;
    $order->city = $request->city;
    $order->state = $request->state;
    $order->zip = $request->zip;
    $order->locality = $request->locality;
    $order->landmark = $request->landmark;
    $order->country = $request->country ?? 'Pakistan';
    

    $order->subtotal = floatval(str_replace(',', '', Cart::instance('cart')->subtotal()));
    $order->tax = floatval(str_replace(',', '', Cart::instance('cart')->tax()));
    $order->total = floatval(str_replace(',', '', Cart::instance('cart')->total()));
    
    $order->save();


    foreach (Cart::instance('cart')->content() as $item) {
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $item->id,
            'product_name' => $item->name,
            'price' => $item->price,
            'quantity' => $item->qty,
        ]);
    }



    Cart::instance('cart')->destroy();


    session(['last_order_id' => $order->id]);

    return redirect()->route('cart.confirmation')->with('success', 'Order placed successfully!');
}
public function setAmountForCheckout()
{ 
    if(!Cart::instance('cart')->count() > 0)
    {
        session()->forget('checkout');
        return;
    }    
    if(session()->has('coupon'))
    {
        session()->put('checkout',[
            'discount' => session()->get('discounts')['discount'],
            'subtotal' =>  session()->get('discounts')['subtotal'],
            'tax' =>  session()->get('discounts')['tax'],
            'total' =>  session()->get('discounts')['total']
        ]);
    }
    else
    {
        session()->put('checkout',[
            'discount' => 0,
            'subtotal' => Cart::instance('cart')->subtotal(),
            'tax' => Cart::instance('cart')->tax(),
            'total' => Cart::instance('cart')->total()
        ]);
    }
}
public function confirmation()
{
    $order = Order::orderBy('created_at', 'DESC')->first();

    return view('order-confirmation', compact('order'));
}
public function getCartCount()
{
    $count = Cart::instance('cart')->count();
    return response()->json(['count' => $count]);
}
}
