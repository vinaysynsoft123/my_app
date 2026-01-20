@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="h4 mb-0">Settings</h2>
            </div>
        </div>
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="row mb-4">
                        <!-- Name -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold"> Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $settings->name }}"
                                required>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Email Address</label>
                            <input type="email" name="email" class="form-control" value="{{ $settings->email }}"
                                required>
                        </div>

                        <!-- Mobile -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Mobile Number</label>
                            <input type="tel" name="mobile" class="form-control" value="{{ $settings->mobile }}"
                                required>
                        </div>

                        <!-- City -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">City</label>
                            <input type="text" name="city" class="form-control" value="{{ $settings->city }}"
                                required>
                        </div>

                        <!-- Address -->
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Full Address</label>
                            <textarea name="address" class="form-control" rows="3" required>{{ $settings->address }}</textarea>
                        </div>
                        <!-- Logo -->
                        <div class="col-12 mb-4">
                            <label class="form-label fw-semibold"> Logo</label>
                            <div class="">
                                <img id="logoPreview"
                                    src="{{ $settings->logo ? asset('storage/' . $settings->logo) : 'https://via.placeholder.com/200x100?text=No+Logo' }}"
                                    class="img-fluid mb-3" style="max-height: 100px; border-radius: 8px;">
                                <input type="file" name="logo" class="form-control" accept="image/*"
                                    onchange="previewLogo(event)">
                                <small class="text-muted d-block mt-2">Recommended: 200x100px PNG/JPG/WEBP</small>
                            </div>
                        </div>
                   
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary px-5">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection