@extends('layouts.admin')

@section('content')
<div class="main-content">
    <div class="main-content-inner">
        <div class="main-content-wrap">

            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Category information</h3>

                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>

                    <li><i class="icon-chevron-right"></i></li>

                    <li>
                        <a href="{{ route('admin.categories') }}">
                            <div class="text-tiny">Categories</div>
                        </a>
                    </li>

                    <li><i class="icon-chevron-right"></i></li>

                    <li>
                        <div class="text-tiny">Edit Category</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">

               <form action="{{ route('admin.category.update', $category->id) }}" method="POST" enctype="multipart/form-data">

    @csrf
    @method('PUT')

    {{-- NAME --}}
    <input type="text" name="name" value="{{ $category->name }}" required>
    @error('name')
        <div class="text-danger">{{ $message }}</div>
    @enderror

    {{-- SLUG --}}
    <input type="text" name="slug" value="{{ $category->slug }}" required>
    @error('slug')
        <div class="text-danger">{{ $message }}</div>
    @enderror

    {{-- IMAGE --}}
    @if($category->image)
        <div id="imgpreview">
            <img src="{{ asset('uploads/categories/'.$category->image) }}" width="80">
        </div>
    @endif

    <input type="file" id="myFile" name="image">

    @error('image')
        <div class="text-danger">{{ $message }}</div>
    @enderror

    <button type="submit">Update</button>
</form>

            </div>

        </div>
    </div>

    <div class="bottom-page">
        <div class="body-text">Copyright © 2024 MarketNest</div>
    </div>
</div>
@endsection


@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {

    document.getElementById('myFile').addEventListener('change', function (e) {
        const file = e.target.files[0];

        if (file) {
            let preview = document.getElementById('imgpreview');

            if (!preview) {
                preview = document.createElement('div');
                preview.id = 'imgpreview';
                preview.innerHTML = '<img width="80">';
                this.parentNode.prepend(preview);
            }

            preview.querySelector('img').src = URL.createObjectURL(file);
        }
    });

    document.querySelector('input[name="name"]').addEventListener('input', function () {
        let text = this.value
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');

        document.querySelector('input[name="slug"]').value = text;
    });

});
</script>
@endpush
