@extends('layouts.admin')

@section('content')

<div class="main-content-inner">
    <div class="main-content-wrap">

        <div class="flex items-center justify-between mb-27">
            <h3>Edit Product</h3>

            <ul class="breadcrumbs flex items-center gap10">
                <li><a href="{{ route('admin.index') }}"><div class="text-tiny">Dashboard</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><a href="{{ route('admin.products') }}"><div class="text-tiny">Products</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><div class="text-tiny">Edit product</div></li>
            </ul>
        </div>

        <form method="POST"
              action="{{ route('admin.product.update', $product->id) }}"
              enctype="multipart/form-data">

            @csrf

            <div class="wg-box">

                {{-- NAME --}}
                <fieldset>
                    <div class="body-title mb-10">Product name</div>
                    @error('name') <div class="alert alert-danger">{{ $message }}</div> @enderror
                    <input type="text" name="name"
                        value="{{ old('name', $product->name) }}">
                </fieldset>

                {{-- SLUG --}}
                <fieldset>
                    <div class="body-title mb-10">Slug</div>
                    @error('slug') <div class="alert alert-danger">{{ $message }}</div> @enderror
                    <input type="text" name="slug"
                        value="{{ old('slug', $product->slug) }}">
                </fieldset>

                {{-- CATEGORY + BRAND --}}
                <div class="cols gap22">

                    <fieldset>
                        <div class="body-title mb-10">Category</div>
                        <select name="category_id">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </fieldset>

                    <fieldset>
                        <div class="body-title mb-10">Brand</div>
                        <select name="brand_id">
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}"
                                    {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </fieldset>

                </div>

                {{-- SHORT DESC --}}
                <fieldset>
                    <div class="body-title mb-10">Short Description</div>
                    <textarea name="short_description">{{ old('short_description', $product->short_description) }}</textarea>
                </fieldset>

                {{-- DESCRIPTION --}}
                <fieldset>
                    <div class="body-title mb-10">Description</div>
                    <textarea name="description">{{ old('description', $product->description) }}</textarea>
                </fieldset>

            </div>

            <div class="wg-box">

                {{-- IMAGE --}}
                <fieldset>
                    <div class="body-title mb-10">Product Image</div>

                    @if($product->image)
                        <img src="{{ asset('uploads/products/' . $product->image) }}"
                             width="100" style="margin-bottom:10px;">
                    @endif

                    <input type="file" name="image" id="myFile">
                </fieldset>

                {{-- PRICES --}}
                <div class="cols gap22">

                    <fieldset>
                        <div class="body-title mb-10">Regular Price</div>
                        <input type="text" name="regular_price"
                            value="{{ old('regular_price', $product->regular_price) }}">
                    </fieldset>

                    <fieldset>
                        <div class="body-title mb-10">Sale Price</div>
                        <input type="text" name="sale_price"
                            value="{{ old('sale_price', $product->sale_price) }}">
                    </fieldset>

                </div>

                {{-- SKU + QTY --}}
                <div class="cols gap22">

                    <fieldset>
                        <div class="body-title mb-10">SKU</div>
                        <input type="text" name="SKU"
                            value="{{ old('SKU', $product->SKU) }}">
                    </fieldset>

                    <fieldset>
                        <div class="body-title mb-10">Quantity</div>
                        <input type="number" name="quantity"
                            value="{{ old('quantity', $product->quantity) }}">
                    </fieldset>

                </div>

                {{-- STOCK + FEATURED --}}
                <div class="cols gap22">

                    <fieldset>
                        <div class="body-title mb-10">Stock</div>
                        <select name="stock_status">
                            <option value="instock" {{ $product->stock_status == 'instock' ? 'selected' : '' }}>In Stock</option>
                            <option value="outofstock" {{ $product->stock_status == 'outofstock' ? 'selected' : '' }}>Out of Stock</option>
                        </select>
                    </fieldset>

                    <fieldset>
                        <div class="body-title mb-10">Featured</div>
                        <select name="featured">
                            <option value="0" {{ $product->featured == 0 ? 'selected' : '' }}>No</option>
                            <option value="1" {{ $product->featured == 1 ? 'selected' : '' }}>Yes</option>
                        </select>
                    </fieldset>

                </div>

                <button class="tf-button w-full" type="submit">
                    Update Product
                </button>

            </div>
        </form>

    </div>
</div>

@endsection
