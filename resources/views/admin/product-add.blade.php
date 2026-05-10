@extends('layouts.admin')

@section('content')

<div class="main-content-inner">
    <div class="main-content-wrap">

        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Add Product</h3>

            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('admin.index') }}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li><i class="icon-chevron-right"></i></li>
                <li>
                    <a href="{{ route('admin.products') }}">
                        <div class="text-tiny">Products</div>
                    </a>
                </li>
                <li><i class="icon-chevron-right"></i></li>
                <li><div class="text-tiny">Add product</div></li>
            </ul>
        </div>

        <form class="tf-section-2 form-add-product"
              method="POST"
              enctype="multipart/form-data"
              action="{{ route('admin.product.store') }}">

            @csrf

            <div class="wg-box">

                {{-- NAME --}}
                <fieldset class="name">
                    <div class="body-title mb-10">Product name <span class="tf-color-1">*</span></div>

                    @error('name')
                        <div class="alert alert-danger text-center">{{ $message }}</div>
                    @enderror

                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter product name" required>
                </fieldset>

                {{-- SLUG --}}
                <fieldset class="name">
                    <div class="body-title mb-10">Slug <span class="tf-color-1">*</span></div>

                    @error('slug')
                        <div class="alert alert-danger text-center">{{ $message }}</div>
                    @enderror

                    <input type="text" name="slug" value="{{ old('slug') }}" placeholder="Enter product slug" required>
                </fieldset>

                {{-- CATEGORY + BRAND --}}
                <div class="gap22 cols">

                    <fieldset class="category">
                        <div class="body-title mb-10">Category <span class="tf-color-1">*</span></div>

                        @error('category_id')
                            <div class="alert alert-danger text-center">{{ $message }}</div>
                        @enderror

                        <select name="category_id">
                            <option value="">Choose category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </fieldset>

                    <fieldset class="brand">
                        <div class="body-title mb-10">Brand <span class="tf-color-1">*</span></div>

                        @error('brand_id')
                            <div class="alert alert-danger text-center">{{ $message }}</div>
                        @enderror

                        <select name="brand_id">
                            <option value="">Choose brand</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </fieldset>

                </div>

                {{-- SHORT DESCRIPTION --}}
                <fieldset>
                    <div class="body-title mb-10">Short Description</div>

                    @error('short_description')
                        <div class="alert alert-danger text-center">{{ $message }}</div>
                    @enderror

                    <textarea name="short_description">{{ old('short_description') }}</textarea>
                </fieldset>

                {{-- DESCRIPTION --}}
                <fieldset>
                    <div class="body-title mb-10">Description</div>

                    @error('description')
                        <div class="alert alert-danger text-center">{{ $message }}</div>
                    @enderror

                    <textarea name="description">{{ old('description') }}</textarea>
                </fieldset>

            </div>

            <div class="wg-box">

                {{-- IMAGE --}}
                <fieldset>
                    <div class="body-title">Upload image</div>

                    @error('image')
                        <div class="alert alert-danger text-center">{{ $message }}</div>
                    @enderror

                    <input type="file" name="image" accept="image/*">
                </fieldset>

                {{-- PRICES --}}
                <div class="cols gap22">

                    <fieldset>
                        <div class="body-title mb-10">Regular Price</div>

                        @error('regular_price')
                            <div class="alert alert-danger text-center">{{ $message }}</div>
                        @enderror

                        <input type="text" name="regular_price" value="{{ old('regular_price') }}">
                    </fieldset>

                    <fieldset>
                        <div class="body-title mb-10">Sale Price</div>

                        @error('sale_price')
                            <div class="alert alert-danger text-center">{{ $message }}</div>
                        @enderror

                        <input type="text" name="sale_price" value="{{ old('sale_price') }}">
                    </fieldset>

                </div>

                {{-- SKU + QTY --}}
                <div class="cols gap22">

                    <fieldset>
                        <div class="body-title mb-10">SKU</div>

                        @error('SKU')
                            <div class="alert alert-danger text-center">{{ $message }}</div>
                        @enderror

                        <input type="text" name="SKU" value="{{ old('SKU') }}">
                    </fieldset>

                    <fieldset>
                        <div class="body-title mb-10">Quantity</div>

                        @error('quantity')
                            <div class="alert alert-danger text-center">{{ $message }}</div>
                        @enderror

                        <input type="number" name="quantity" value="{{ old('quantity') }}">
                    </fieldset>

                </div>

                {{-- STOCK + FEATURED --}}
                <div class="cols gap22">

                    <fieldset>
                        <div class="body-title mb-10">Stock</div>

                        @error('stock_status')
                            <div class="alert alert-danger text-center">{{ $message }}</div>
                        @enderror

                        <select name="stock_status">
                            <option value="instock">In Stock</option>
                            <option value="outofstock">Out of Stock</option>
                        </select>
                    </fieldset>

                    <fieldset>
                        <div class="body-title mb-10">Featured</div>

                        <select name="featured">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </fieldset>

                </div>

                <button class="tf-button w-full" type="submit">
                    Add Product
                </button>

            </div>
        </form>

    </div>
</div>

@endsection
@push('scripts')
<script>
$(document).ready(function () {


   $('#myFile').on('change', function (e) {
    const file = e.target.files[0];

    if (file) {
        $('#imgpreview img').attr('src', URL.createObjectURL(file));
        $('#imgpreview').show();
    }
});
    $('#gFile').on('change', function (e) {
    let files = e.target.files;

    $('#galUpload').html('');

    for (let i = 0; i < files.length; i++) {
        $('#galUpload').append(`
            <img src="${URL.createObjectURL(files[i])}" style="width:60px; height:60px; margin:5px;">
        `);
    }
});


    $('input[name="name"]').on('change', function () {
        let name = $(this).val();
        $('input[name="slug"]').val(stringToSlug(name));
    });

    function stringToSlug(text) {
        return text
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
    }

});
</script>
@endpush
