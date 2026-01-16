<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Confirmation</title>
</head>

<body style="margin:0;padding:0;background-color:#f4f6f8;font-family:Arial, Helvetica, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f8;padding:30px 0;">
    <tr>
        <td align="center">

            <!-- MAIN CARD -->
            <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:8px;overflow:hidden;box-shadow:0 4px 12px rgba(0,0,0,0.08);">

                <!-- HEADER -->
                <tr>
                    <td style="background:#1f2937;color:#ffffff;padding:20px 30px;">
                        <h2 style="margin:0;font-size:22px;">🏨 Room Booking Confirmation</h2>
                        <p style="margin:5px 0 0;font-size:14px;color:#d1d5db;">
                            Booking No: {{ $booking->booking_number }}
                        </p>
                    </td>
                </tr>

                <!-- BODY -->
                <tr>
                    <td style="padding:30px;">

                        <p style="font-size:15px;color:#111827;">
                            Dear <strong>{{ $booking->guest_name }}</strong>,
                        </p>

                        <p style="font-size:14px;color:#374151;line-height:1.6;">
                            Thank you for choosing our hotel. We are pleased to inform you that your room booking has been
                            <strong style="color:#16a34a;">successfully confirmed</strong>.
                        </p>

                        <!-- DETAILS CARD -->
                        <table width="100%" cellpadding="10" cellspacing="0" style="margin-top:20px;border-collapse:collapse;">
                            <tr>
                                <td colspan="2" style="background:#f9fafb;font-weight:bold;color:#111827;border:1px solid #e5e7eb;">
                                    📌 Booking Details
                                </td>
                            </tr>

                            @php
                                $rows = [
                                    'Room Number' => $booking->room->room_number,
                                    'Room Type' => $booking->room->type,
                                    'Check-In' => \Carbon\Carbon::parse($booking->check_in)->format('d M Y'),
                                    'Check-Out' => \Carbon\Carbon::parse($booking->check_out)->format('d M Y'),
                                    'Meal Plan' => $booking->meal_plan ?? 'N/A',
                                    'Total Amount' => '₹ ' . number_format($booking->total_amount, 2),
                                    'Advance Paid' => '₹ ' . number_format($booking->advance, 2),
                                    'Payment Mode' => ucfirst($booking->payment_mode),
                                    'Notes' => $booking->notes ?? '—',
                                ];
                            @endphp

                            @foreach($rows as $label => $value)
                                <tr>
                                    <td width="40%" style="border:1px solid #e5e7eb;background:#f9fafb;font-size:13px;color:#374151;">
                                        {{ $label }}
                                    </td>
                                    <td width="60%" style="border:1px solid #e5e7eb;font-size:13px;color:#111827;">
                                        {{ $value }}
                                    </td>
                                </tr>
                            @endforeach
                        </table>

                        <!-- FOOT NOTE -->
                        <p style="margin-top:25px;font-size:13px;color:#374151;">
                            If you have any questions or special requests, feel free to contact us anytime.
                        </p>

                        <p style="margin-top:15px;font-size:14px;color:#111827;">
                            Regards,<br>
                            <strong>Hotel Management</strong>
                        </p>

                    </td>
                </tr>

                <!-- FOOTER -->
                <tr>
                    <td style="background:#f3f4f6;padding:15px;text-align:center;font-size:12px;color:#6b7280;">
                        © {{ date('Y') }} Hotel Management. All rights reserved.
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>
