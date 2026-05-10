@extends('layouts.app')
@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="contact-us container">
        <div class="mw-930">
            <h2 class="page-title">About MarketNest</h2>
        </div>

        <div class="about-us__content pb-5 mb-5">
            <p class="mb-5">
                <img loading="lazy" class="w-100 h-auto d-block" src="{{ asset('assets/images/about/about-1.jpg') }}" width="1410"
                    height="550" alt="MarketNest Store" />
            </p>
            <div class="mw-930">
                <h3 class="mb-4">OUR STORY</h3>
                <p class="fs-6 fw-medium mb-4">MarketNest was founded in 2024 with a simple belief: fashion should be accessible, comfortable, and sustainable. What started as a small online clothing store has grown into a trusted destination for men, women, and kids who value quality without compromise.</p>
                <p class="mb-4">The name "MarketNest" combines two meaningful words: "Market" – where people gather to discover and shop, and "Nest" – a place of comfort, warmth, and belonging. We believe shopping for clothes should feel like coming home – welcoming, effortless, and enjoyable. Our team carefully selects every piece in our collection to ensure it meets our standards of style, durability, and comfort.</p>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5 class="mb-3">Our Mission</h5>
                        <p class="mb-3">To provide stylish, high-quality clothing that makes you feel confident and comfortable every single day. We're committed to ethical sourcing, sustainable practices, and exceptional customer service.</p>
                    </div>
                    <div class="col-md-6">
                        <h5 class="mb-3">Our Vision</h5>
                        <p class="mb-3">To become the most loved online clothing destination where every customer feels valued, every product brings joy, and every purchase supports a more sustainable future.</p>
                    </div>
                </div>
            </div>
            <div class="mw-930 d-lg-flex align-items-lg-center">
                <div class="image-wrapper col-lg-6">
                    <img class="h-auto" loading="lazy" src="{{ asset('assets/images/about/about-1.jpg') }}" width="450" height="500" alt="Our Team">
                </div>
                <div class="content-wrapper col-lg-6 px-lg-4">
                    <h5 class="mb-3">Why Choose MarketNest?</h5>
                    <p>✓ Premium quality fabrics sourced responsibly</p>
                    <p>✓ Free shipping on orders over $50</p>
                    <p>✓ 30-day easy returns, no questions asked</p>
                    <p>✓ 24/7 dedicated customer support</p>
                    <p>✓ Secure payments with multiple options</p>
                    <p class="mt-3">At MarketNest, we're more than just a clothing store. We're a community of fashion lovers who believe that what you wear should make you feel amazing. From casual everyday essentials to statement pieces, we've got something for everyone.</p>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
