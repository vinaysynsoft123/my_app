<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::latest()->paginate(10);
        return view('rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('rooms.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_number' => 'required|unique:rooms',
            'type' => 'required',
            'price' => 'required|numeric',
            'capacity' => 'required|integer',
        ]);

        Room::create($request->all());

        return redirect()->route('rooms.index')
            ->with('success', 'Room added successfully');
    }

    public function edit(Room $room)
    {
        return view('rooms.form', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'room_number' => 'required|unique:rooms,room_number,' . $room->id,
            'type' => 'required',
            'price' => 'required|numeric',
            'capacity' => 'required|integer',
            'status' => 'required',
        ]);

        $room->update($request->all());

        return redirect()->route('rooms.index')
            ->with('success', 'Room updated successfully');
    }

    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()->route('rooms.index')
            ->with('success', 'Room deleted successfully');
    }
}