@extends('layouts.admin')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">

        {{-- HEADER --}}
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>All Products</h3>

            <ul class="breadcrumbs flex items-center flex-wrap gap10">
                <li>
                    <a href="{{ route('admin.index') }}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>

                <li><i class="icon-chevron-right"></i></li>

                <li>
                    <div class="text-tiny">All Products</div>
                </li>
            </ul>
        </div>

        {{-- BOX --}}
        <div class="wg-box">

            {{-- TOP BAR --}}
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <!-- Search will be added by DataTables -->
                </div>

                <a class="tf-button style-1 w208" href="{{ route('admin.product.add') }}">
                    <i class="icon-plus"></i>Add new
                </a>
            </div>

            {{-- SUCCESS MESSAGE --}}
            @if (Session::has('status'))
                <p class="alert alert-success">{{ Session::get('status') }}</p>
            @endif

            {{-- TABLE --}}
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="products-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Sale Price</th>
                            <th>SKU</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Featured</th>
                            <th>Stock</th>
                            <th>Qty</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DataTables will populate this -->
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    var table = $('#products-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.products') }}",
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name_display', name: 'name' },
            { data: 'regular_price', name: 'regular_price' },
            { data: 'sale_price', name: 'sale_price' },
            { data: 'SKU', name: 'SKU' },
            { data: 'category_name', name: 'category.name' },
            { data: 'brand_name', name: 'brand.name' },
            { data: 'featured', name: 'featured' },
            { data: 'stock_badge', name: 'stock_status' },
            { data: 'quantity', name: 'quantity' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [[0, 'desc']],
        responsive: true,
        language: {
            search: "Search:",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
        }
    });
    

    $(document).on('click', '.delete-product', function(e) {
        e.preventDefault();
        let form = $(this).closest('form');
        
        Swal.fire({
            title: "Are you sure?",
            text: "This product will be deleted permanently.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#dc3545",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endpush
