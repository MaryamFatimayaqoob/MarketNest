<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ReviewController;
Auth::routes();

Route::get('/contact-us', [HomeController::class, 'contact'])->name('home.contact');
Route::post('/contact-us', [HomeController::class, 'contact_store'])->name('home.contact.store');
Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{product_slug}', [ShopController::class, 'product_details'])->name('shop.product.details');
Route::get('/cart',[CartController::class,'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add_To_Cart'])->name('cart.add');
Route::get('/about', function () {
    return view('about');
})->name('about.index');
Route::put('/cart/increase-quantity/{rowId}', [CartController::class, 'increase_item_quantity'])->name('cart.increase.qty');

Route::put('/cart/reduce-quantity/{rowId}', [CartController::class, 'reduce_item_quantity'])->name('cart.reduce.qty');
Route::delete('/cart/remove/{rowId}',[CartController::class,'remove_item_from_cart'])->name('cart.remove');
Route::delete('/cart/clear',[CartController::class,'empty_cart'])->name('cart.empty');
Route::get('/checkout',[CartController::class,'checkout'])->name('cart.checkout');

Route::post('/place-order',[CartController::class,'place_order'])->name('cart.place.order');
Route::get('/order-confirmation',[CartController::class,'confirmation'])->name('cart.confirmation');

Route::get('/contact-us', [HomeController::class, 'contact'])->name('home.contact');
Route::get('/contact/store', [HomeController::class, 'contact_store'])->name('home.contact.store');
Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');
Route::middleware(['auth'])->group(function () {
Route::put('/account-order/cancel-order', [UserController::class, 'account_cancel_order'])->name('user.account_cancel_order');
   Route::get('/account-dashboard', [UserController::class, 'index'])->name('user.index');
    

    Route::get('/account-orders', [UserController::class, 'account_orders'])->name('user.account.orders');
    Route::get('/account-order-details/{order_id}', [UserController::class, 'account_order_details'])->name('user.account.order.details');
Route::put('/account-order/cancel-order', [UserController::class, 'account_cancel_order'])->name('user.account_cancel_order');
Route::post('/product/{product_id}/review', [ReviewController::class, 'storeReview'])->name('review.store')->middleware('auth');
});





Route::middleware(['auth',AuthAdmin::class])->group(function () {

    Route::get('/admin', [AdminController::class, 'index'])
        ->name('admin.index');
    
        Route::get('/admin/brands', [AdminController::class, 'brands'])
    ->name('admin.brands');
      Route::get('/admin/brand/add', [AdminController::class, 'add_brand'])
    ->name('admin.brand.add');
     Route::post('/admin/brand/store', [AdminController::class, 'brand_Store'])
    ->name('admin.brand.store');
    Route::get('/admin/brand/edit/{id}', [AdminController::class, 'edit_brand'])
    ->name('admin.brand.edit');
    Route::put('/admin/brand/update/{id}', [AdminController::class, 'update_brand'])
    ->name('admin.brand.update');
    Route::delete('/admin/brand/{id}/delete', [AdminController::class, 'brand_delete'])
    ->name('admin.brand.delete');
    
    Route::put('/admin/order/update-status', [AdminController::class, 'update_order_status'])->name('admin.order.status.update');
    
    Route::get('/admin/categories', [AdminController::class, 'categories'])
    ->name('admin.categories');
    Route::get('/admin/category/add', [AdminController::class, 'add_category'])->name('admin.category.add');
    Route::post('/admin/category/store', [AdminController::class, 'category_store'])->name('admin.category.store');
    Route::get('/admin/category/{id}/edit', [AdminController::class, 'edit_category'])->name('admin.category.edit');
    Route::put('/admin/category/update/{id}', [AdminController::class, 'update_category'])->name('admin.category.update');
    Route::delete('/admin/category/{id}/delete', [AdminController::class, 'category_delete'])->name('admin.category.delete');



    Route::get('/admin/products', [AdminController::class, 'products'])
    ->name('admin.products');

Route::get('/admin/product/add', [AdminController::class, 'product_add'])
    ->name('admin.product.add');


Route::post('/admin/product/add', [AdminController::class, 'product_store'])->name('admin.product.store');


Route::get('/admin/product/edit/{id}', [AdminController::class, 'product_edit'])
    ->name('admin.product.edit');

// UPDATE ACTION
Route::post('/admin/product/update/{id}', [AdminController::class, 'product_update'])
    ->name('admin.product.update');
Route::delete('/admin/product/delete/{id}', [AdminController::class, 'product_delete'])
    ->name('admin.product.delete');
    
Route::get('/admin/orders',[AdminController::class,'orders'])->name('admin.orders');
Route::get('/admin/order/items/{order_id}',[AdminController::class,'order_items'])->name('admin.order.items');

Route::get('/admin/contacts', [AdminController::class, 'contacts'])->name('admin.contacts');
Route::put('/admin/contact/read/{id}', [AdminController::class, 'contact_read'])->name('admin.contact.read');
});
Route::get('/check-gd', function () {
    return extension_loaded('gd') ? 'GD YES' : 'GD NO';
});