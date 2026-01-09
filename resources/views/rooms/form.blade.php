@extends('layouts.app')

@section('content')
<h4>{{ isset($room) ? 'Edit Room' : 'Add Room' }}</h4>

<form method="POST"
      action="{{ isset($room) ? route('rooms.update', $room) : route('rooms.store') }}">
    @csrf
    @isset($room) @method('PUT') @endisset

    <div class="row">
        <div class="col-md-4 mb-3">
            <label>Room Number</label>
            <input type="text" name="room_number" class="form-control"
                   value="{{ $room->room_number ?? old('room_number') }}">
        </div>

        <div class="col-md-4 mb-3">
            <label>Type</label>
            <select name="type" class="form-control">
                @foreach(['Standard','Deluxe','Suite'] as $type)
                    <option value="{{ $type }}"
                        {{ ($room->type ?? '') == $type ? 'selected' : '' }}>
                        {{ $type }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4 mb-3">
            <label>Price</label>
            <input type="number" name="price" class="form-control"
                   value="{{ $room->price ?? old('price') }}">
        </div>

        <div class="col-md-4 mb-3">
            <label>Capacity</label>
            <input type="number" name="capacity" class="form-control"
                   value="{{ $room->capacity ?? old('capacity') }}">
        </div>

        @isset($room)
        <div class="col-md-4 mb-3">    
            <label>Status</label>
                <select name="status" class="form-control">
                    <option value="1" {{ (isset($room) && $room->status == 1) ? 'selected' : '' }}>
                        Active
                    </option>
                    <option value="0" {{ (isset($room) && $room->status == 0) ? 'selected' : '' }}>
                        Pending
                    </option>
                    <option value="2" {{ (isset($room) && $room->status == 2) ? 'selected' : '' }}>
                        Maintenance
                    </option>
                </select>
        </div>

        @endisset
    </div>

    <button class="btn btn-primary">
        {{ isset($room) ? 'Update' : 'Save' }}
    </button>
</form>
@endsection