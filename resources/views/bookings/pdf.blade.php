<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Invoice</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .header {
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .hotel-name {
            font-size: 20px;
            font-weight: bold;
            color: #2c3e50;
        }

        .invoice-title {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
        }

        .sub-text {
            color: #777;
            font-size: 11px;
        }

        .section {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f5f5f5;
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }

        td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        .text-right {
            text-align: right;
        }

        .total-box {
            margin-top: 15px;
            width: 40%;
            float: right;
        }

        .total-box td {
            font-size: 13px;
            font-weight: bold;
        }

        .badge {
            padding: 4px 8px;
            font-size: 11px;
            color: #fff;
            border-radius: 4px;
        }

        .badge-success { background: #28a745; }
        .badge-warning { background: #f0ad4e; }
        .badge-danger  { background: #dc3545; }

        .footer {
            position: fixed;
            bottom: 20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #999;
        }
        .policy-box {
            margin-top: 50px;
            padding: 10px;
            border: 1px dashed #ccc;
            background: #fafafa;
            font-size: 11px;
        }

        .policy-title {
            font-weight: bold;
            margin-bottom: 5px;
            color: #2c3e50;
        }

    </style>
</head>

<body>

    <!-- HEADER -->
    <div class="header">
        <table width="100%">
            <tr>
                <td>
                    <div class="hotel-name">{{ $setting->name }}</div>
                    <div class="sub-text">
                       {{ $setting->address  }},    {{ $setting->city  }} <br>
                        Phone: {{ $setting->mobile }}<br>
                        Email: {{ $setting->email  }}
                    </div>
                </td>
                <td class="invoice-title">
                    INVOICE<br>
                    <span class="sub-text">
                        Booking #{{ $booking->booking_number }}
                    </span>
                </td>
            </tr>
        </table>
    </div>

    <!-- GUEST & BOOKING INFO -->
    <div class="section">
        <table>
            <tr>
                <th width="25%">Guest Name</th>
                <td width="25%">{{ $booking->guest_name }}</td>

                <th width="25%">Room No</th>
                <td width="25%">{{ $booking->room->room_number ?? 'N/A' }}</td>
            </tr>

            <tr>
                <th>Email</th>
                <td>{{ $booking->email }}</td>

                <th>Phone</th>
                <td>{{ $booking->phone }}</td>
            </tr>

            <tr>
                <th>Check-in</th>
                <td>{{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }}</td>

                <th>Check-out</th>
                <td>{{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}</td>
            </tr>

            <tr>
                <th>Status</th>
                <td colspan="3">
                    @php
                        $statusText = match($booking->status) {
                            1 => 'Confirmed',
                            0 => 'Pending',
                            default => 'Cancelled',
                        };

                        $statusClass = match($booking->status) {
                            1 => 'badge-success',
                            0 => 'badge-warning',
                            default => 'badge-danger',
                        };
                    @endphp

                    <span class="badge {{ $statusClass }}">
                        {{ $statusText }}
                    </span>
                </td>
            </tr>
        </table>
    </div>

    <!-- BILLING DETAILS -->
    <div class="section">
        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th class="text-right">Amount (₹)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        Room Charges
                        <br>
                        <span class="sub-text">
                            {{ \Carbon\Carbon::parse($booking->check_in)->diffInDays($booking->check_out) }} Nights
                        </span>
                    </td>
                    <td class="text-right">
                        {{ number_format($booking->total_amount, 2) }}
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- TOTAL -->
        <table class="total-box">
            <tr>
                <td>Total Amount</td>
                <td class="text-right">₹ {{ number_format($booking->total_amount, 2) }}</td>
            </tr>
        </table>
    </div>
<!-- CANCELLATION POLICY -->
<div class="section">
    <div class="policy-box">
        <div class="policy-title">Cancellation Policy</div>

        <ul style="margin:0; padding-left:15px;">
            <li>Free cancellation up to <strong>24 hours</strong> before check-in.</li>
            <li>Cancellations within 24 hours of check-in will be charged <strong>1 night stay</strong>.</li>
            <li>No refund in case of <strong>No-Show</strong>.</li>
            <li>Refund (if applicable) will be processed within <strong>5–7 working days</strong>.</li>
        </ul>
    </div>
</div>

    <!-- FOOTER -->
    <div class="footer">
        Thank you for choosing {{ $setting->name }}.<br>
        This is a system-generated invoice.
    </div>
</body>
</html>
