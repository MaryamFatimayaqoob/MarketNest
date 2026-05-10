@extends('layouts.app')

@section('content')
<style>
    .cart-total th,
    .cart-total td {
        color: green;
        font-weight: bold;
        font-size: 21px !important;
    }
</style>

<main class="pt-90">
    <div class="mb-4 pb-4"></div>

    <section class="shop-checkout container">
        <h2 class="page-title">Shipping and Checkout</h2>

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

            <a href="{{ route('cart.confirmation') }}" class="checkout-steps__item">
                <span class="checkout-steps__item-number">03</span>
                <span class="checkout-steps__item-title">
                    <span>Confirmation</span>
                    <em>Order Confirmation</em>
                </span>
            </a>
        </div>

        <form name="checkout-form" action="{{ route('cart.place.order') }}" method="POST">
            @csrf

            <div class="checkout-form">

                <div class="billing-info__wrapper">

                    <div class="row">
                        <div class="col-6">
                            <h4>SHIPPING DETAILS</h4>
                        </div>

                        <div class="col-6">
                            @if($address)
                                <a href="{{ route('user.account.addresses') }}" class="btn btn-info btn-sm float-right">
                                    Change Address
                                </a>

                                <a href="{{ route('user.account.address.edit', ['address_id' => $address->id]) }}"
                                   class="btn btn-warning btn-sm float-right mr-3">
                                    Edit Address
                                </a>
                            @endif
                        </div>
                    </div>

                    @if($address)

                        <div class="row">
                            <div class="col-md-12">
                                <div class="my-account__address-list">
                                    <div class="my-account__address-item">
                                        <div class="my-account__address-item__detail">
                                            <p>{{ $address->name }}</p>
                                            <p>{{ $address->address }}</p>
                                            <p>{{ $address->landmark }}</p>
                                            <p>{{ $address->city }}, {{ $address->state }}, {{ $address->country }}</p>
                                            <p>{{ $address->zip }}</p>
                                            <p>Phone :- {{ $address->phone }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @else

                        <div class="row mt-5">

                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                    <label>Full Name *</label>
                                    <span class="text-danger">@error('name') {{ $message }} @enderror</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
                                    <label>Phone Number *</label>
                                    <span class="text-danger">@error('phone') {{ $message }} @enderror</span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="zip" value="{{ old('zip') }}">
                                    <label>Pincode *</label>
                                    <span class="text-danger">@error('zip') {{ $message }} @enderror</span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="state" value="{{ old('state') }}">
                                    <label>State *</label>
                                    <span class="text-danger">@error('state') {{ $message }} @enderror</span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="city" value="{{ old('city') }}">
                                    <label>City *</label>
                                    <span class="text-danger">@error('city') {{ $message }} @enderror</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="address" value="{{ old('address') }}">
                                    <label>House no, Building *</label>
                                    <span class="text-danger">@error('address') {{ $message }} @enderror</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="locality" value="{{ old('locality') }}">
                                    <label>Area *</label>
                                    <span class="text-danger">@error('locality') {{ $message }} @enderror</span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="landmark" value="{{ old('landmark') }}">
                                    <label>Landmark *</label>
                                    <span class="text-danger">@error('landmark') {{ $message }} @enderror</span>
                                </div>
                            </div>

                        </div>

                    @endif

                </div>

                <div class="checkout__totals-wrapper">
                    <div class="sticky-content">

                        <div class="checkout__totals">
                            <h3>Your Order</h3>

                            <table class="checkout-cart-items">
                                <thead>
                                <tr>
                                    <th>PRODUCT</th>
                                    <th class="text-right">SUBTOTAL</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach (Cart::instance('cart')->content() as $item)
                                    <tr>
                                        <td>{{ $item->name }} x {{ $item->qty }}</td>
                                        <td class="text-right">${{ $item->subtotal }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            PLACE ORDER
                        </button>

                    </div>
                </div>

            </div>
        </form>

    </section>
</main>
@endsection
