@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">
                <i class="bi bi-door-closed me-2"></i>
                {{ isset($room) ? 'Edit Room' : 'Add Room' }}
            </h4>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">

                <form method="POST" action="{{ isset($room) ? route('rooms.update', $room) : route('rooms.store') }}">
                    @csrf
                    @isset($room)
                        @method('PUT')
                    @endisset

                    <div class="row g-3">

                        <!-- Room Number -->
                        <div class="col-md-6">
                            <label class="form-label">
                                Room Number <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="room_number" class="form-control" placeholder="e.g. 101"
                                value="{{ $room->room_number ?? old('room_number') }}">
                            @error('room_number')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror

                        </div>

                        <!-- Type -->
                        <div class="col-md-6">
                            <label class="form-label">
                                Room Type <span class="text-danger">*</span>
                            </label>
                            <select name="type" class="form-select">
                                <option value="">Select Type</option>
                                @foreach (['Standard', 'Deluxe', 'Suite'] as $type)
                                    <option value="{{ $type }}"
                                        {{ ($room->type ?? old('type')) == $type ? 'selected' : '' }}>
                                        {{ $type }}
                                    </option>
                                @endforeach
                            </select>

                            @error('type')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div class="col-md-6">
                            <label class="form-label">
                                Price (₹) <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="price" class="form-control" placeholder="Enter price"
                                min="100" value="{{ $room->price ?? old('price') }}">

                            @error('price')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Capacity -->
                        <div class="col-md-6">
                            <label class="form-label">
                                Capacity <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="capacity" class="form-control" placeholder="No. of guests"
                                min="1" value="{{ $room->capacity ?? old('capacity') }}">
                            @error('capacity')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Status (Edit Only) -->
                        @isset($room)
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="1" {{ $room->status == 1 ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option value="0" {{ $room->status == 0 ? 'selected' : '' }}>
                                        Pending
                                    </option>
                                    <option value="2" {{ $room->status == 2 ? 'selected' : '' }}>
                                        Maintenance
                                    </option>
                                </select>
                            </div>
                        @endisset

                    </div>

                    <!-- Footer Buttons -->
                    <div class="mt-4 d-flex justify-content-end gap-2">
                        <a href="{{ route('rooms.index') }}" class="btn btn-light">
                            Cancel
                        </a>
                        <button class="btn btn-primary px-4">
                            {{ isset($room) ? 'Update Room' : 'Save Room' }}
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection
