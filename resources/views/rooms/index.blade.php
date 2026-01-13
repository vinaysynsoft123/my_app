@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>Room Management</h4>
    <a href="{{ route('rooms.create') }}" class="btn btn-primary">
        <i class="bi bi-plus"></i> Add Room
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Room No</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Capacity</th>
                    <th>Status</th>
                    <th width="150">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rooms as $room)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $room->room_number }}</td>
                    <td>{{ $room->type }}</td>
                    <td>₹{{ $room->price }}</td>
                    <td>{{ $room->capacity }}</td>
                    <td>
                        @if ($room->status == 1)
                            <span class="badge bg-success">Active</span>
                        @elseif ($room->status == 0)
                            <span class="badge bg-warning text-dark">Pending</span>
                        @else
                            <span class="badge bg-danger">Maintenance</span>
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('rooms.edit', $room) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('rooms.destroy', $room) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"
                                onclick="return confirm('Delete this room?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
      <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center px-3 py-3 bg-light border-top">
                <div class="text-muted small">
                    Page {{ $rooms->currentPage() }} of {{ $rooms->lastPage() }}
                </div>
                <div>
                    {{ $rooms->links('pagination::bootstrap-5') }}
                </div>
            </div>
</div>
@endsection
