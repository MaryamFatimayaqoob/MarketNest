@extends('layouts.admin')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Order Details #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</h3>
            <a href="{{ route('admin.orders') }}" class="btn btn-secondary">Back to Orders</a>
        </div>
        
        @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        
        <div class="wg-box">
            <div class="row">
                <div class="col-md-6">
                    <h5>Customer Information</h5>
                    <p><strong>Name:</strong> {{ $order->name }}</p>
                    <p><strong>Phone:</strong> {{ $order->phone }}</p>
                    <p><strong>Email:</strong> {{ $order->email ?? 'N/A' }}</p>
                    <p><strong>Address:</strong> {{ $order->address }}, {{ $order->city }}, {{ $order->state }} - {{ $order->zip }}</p>
                </div>
                <div class="col-md-6">
                    <h5>Order Information</h5>
                    <p><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y H:i') }}</p>
                    <p><strong>Status:</strong> 
                        <span class="badge {{ $order->status == 'delivered' ? 'bg-success' : ($order->status == 'canceled' ? 'bg-danger' : 'bg-warning') }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>
                    @if($order->delivered_date)
                    <p><strong>Delivered Date:</strong> {{ \Carbon\Carbon::parse($order->delivered_date)->format('M d, Y') }}</p>
                    @endif
                    @if($order->canceled_date)
                    <p><strong>Canceled Date:</strong> {{ \Carbon\Carbon::parse($order->canceled_date)->format('M d, Y') }}</p>
                    @endif
                    <p><strong>Subtotal:</strong> ${{ number_format($order->subtotal, 2) }}</p>
                    <p><strong>Tax:</strong> ${{ number_format($order->tax, 2) }}</p>
                    <p><strong>Total:</strong> ${{ number_format($order->total, 2) }}</p>
                </div>
            </div>
            
            <div class="wg-box mt-5">
                <h5>Update Order Status</h5>
                <form action="{{ route('admin.order.status.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="select">
                                <select name="order_status" class="form-control">
                                    <option value="ordered" {{ $order->status == 'ordered' ? 'selected' : '' }}>Ordered</option>
                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">Update Status</button>
                        </div>
                    </div>
                </form>
            </div>
            
            <h5 class="mt-4">Order Items</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $item)
                        <tr>
                            <td>{{ $item->product_name }}</td>
                            <td class="text-center">${{ number_format($item->price, 2) }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-center">${{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">Total:</th>
                            <th class="text-center">${{ number_format($order->total, 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <div class="wg-box mt-5">
                <h5>Shipping Address</h5>
                <div class="my-account__address-item col-md-6">                
                    <div class="my-account__address-item__detail">
                        <p><strong>{{ $order->name }}</strong></p>
                        <p>{{ $order->address }}</p>
                        @if($order->locality)<p>{{ $order->locality }}</p>@endif
                        <p>{{ $order->city }}, {{ $order->state }} {{ $order->zip }}</p>
                        @if($order->country)<p>{{ $order->country }}</p>@endif
                        @if($order->landmark)<p>{{ $order->landmark }}</p>@endif
                        <p>Mobile: {{ $order->phone }}</p>
                    </div>
                </div>              
            </div>
        </div>
    </div>
</div>
@endsection
