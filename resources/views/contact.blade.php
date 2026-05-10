@extends('layouts.app')
@section('content')

<div class="container py-5">
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card shadow border-0 rounded-4">
                <div class="card-header bg-white border-0 pt-4 text-center">
                    <h3 class="fw-bold">Contact Us</h3>
                    <p class="text-muted">We'd love to hear from you!</p>
                </div>
                <div class="card-body p-4">
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form action="{{ route('home.contact.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Your Name *</label>
                            <input type="text" class="form-control rounded-pill" id="name" name="name" value="{{ old('name') }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address *</label>
                            <input type="email" class="form-control rounded-pill" id="email" name="email" value="{{ old('email') }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number (Optional)</label>
                            <input type="text" class="form-control rounded-pill" id="phone" name="phone" value="{{ old('phone') }}">
                        </div>
                        
                        <div class="mb-3">
                            <label for="message" class="form-label">Your Message *</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 w-100">
                            <i class="bi bi-send"></i> Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
