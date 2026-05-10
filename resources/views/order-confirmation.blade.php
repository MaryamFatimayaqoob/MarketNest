
@extends('layouts.app')

@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>

    <section class="shop-checkout container">

        <h2 class="page-title">Order Received</h2>

        <div class="checkout-steps">
            <a href="{{ route('cart.index') }}" class="checkout-steps__item active">
                <span class="checkout-steps__item-number">01</span>
                <span class="checkout-steps__item-title">
                    <span>Shopping Bag</span>
                    <em>Manage Your Items List</em>
                </span>
            </a>

            <a href="{{ route('cart.checkout') }}" class="checkout-steps__item active">
                <span class="checkout-steps__item-number">02</span>
                <span class="checkout-steps__item-title">
                    <span>Shipping and Checkout</span>
                    <em>Checkout Your Items List</em>
                </span>
            </a>

            <a href="#" class="checkout-steps__item active">
                <span class="checkout-steps__item-number">03</span>
                <span class="checkout-steps__item-title">
                    <span>Confirmation</span>
                    <em>Review And Submit Your Order</em>
                </span>
            </a>
        </div>

        {{-- SUCCESS MESSAGE --}}
        <div class="order-complete">
            <div class="order-complete__message">

                <svg width="80" height="80" viewBox="0 0 80 80" fill="none">
                    <circle cx="40" cy="40" r="40" fill="#B9A16B" />
                    <path d="M52.97 35.76L36.96 51.29L27.49 41.82" fill="white"/>
                </svg>

                <h3>Your order is completed!</h3>
                <p>Thank you. Your order has been received.</p>

                <a href="{{ route('shop.index') }}" class="btn btn-info mt-5">
                    Shop More
                </a>
            </div>
        </div>

        {{-- ORDER INFO (DYNAMIC LATER) --}}
        <div class="order-info">
            <div class="order-info__item">
                <label>Order Number</label>
                <span>#{{ $order->id ?? 'N/A' }}</span>
            </div>

            <div class="order-info__item">
                <label>Date</label>
                @if($order)
    <span>{{ $order->created_at->format('d/m/Y') }}</span>
@else
    <span>No date</span>
@endif
            </div>

            <div class="order-info__item">
                <label>Total</label>
                <span>${{ $order->total ?? '0.00' }}</span>
            </div>

            <div class="order-info__item">
                <label>Payment Method</label>
                <span>Cash on Delivery</span>
            </div>
        </div>

        {{-- ORDER ITEMS --}}
        <div class="checkout__totals-wrapper">
            <div class="checkout__totals">
                <h3>Order Details</h3>

                <table class="checkout-cart-items">
                    <thead>
                        <tr>
                            <th>PRODUCT</th>
                            <th>SUBTOTAL</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($order->items ?? [] as $item)
                            <tr>
                                <td>
                                    {{ $item->product->name }} x {{ $item->quantity }}
                                </td>
                                <td>
                                    ${{ $item->price * $item->quantity }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <table class="checkout-totals">
                    <tbody>
                        <tr>
                            <th>SUBTOTAL</th>
                            <td>${{ $order->subtotal ?? 0 }}</td>
                        </tr>
                        <tr>
                            <th>SHIPPING</th>
                            <td>Free</td>
                        </tr>
                        <tr>
                            <th>VAT</th>
                            <td>${{ $order->tax ?? 0 }}</td>
                        </tr>
                        <tr>
                            <th>TOTAL</th>
                            <td>${{ $order->total ?? 0 }}</td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>

    </section>
</main>
@endsection
