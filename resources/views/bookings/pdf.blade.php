<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h2 { margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 8px; border-bottom: 1px solid #ddd; }
    </style>
</head>
<body>

<h2>Booking Details</h2>

<table>
    <tr>
        <td><strong>Guest</strong></td>
        <td>{{ $booking->guest_name }}</td>
    </tr>
    <tr>
        <td><strong>Room</strong></td>
        <td>{{ $booking->room->room_number ?? 'N/A' }}</td>
    </tr>
    <tr>
        <td><strong>Check-in</strong></td>
        <td>{{ $booking->check_in }}</td>
    </tr>
    <tr>
        <td><strong>Check-out</strong></td>
        <td>{{ $booking->check_out }}</td>
    </tr>
    <tr>
        <td><strong>Status</strong></td>
        <td>
            {{ $booking->status == 1 ? 'Confirmed' : ($booking->status == 0 ? 'Pending' : 'Cancelled') }}
        </td>
    </tr>
    <tr>
        <td><strong>Total</strong></td>
        <td>₹ {{ number_format($booking->total_amount, 2) }}</td>
    </tr>
</table>

</body>
</html>
