<?php
Route::post('/product/{product_id}/review', [ReviewController::class, 'store'])->name('review.store')->middleware('auth');