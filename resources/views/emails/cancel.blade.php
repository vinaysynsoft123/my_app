<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Cancellation</title>
</head>

<body style="margin:0;padding:0;background-color:#f4f6f8;font-family:Arial, Helvetica, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f8;padding:30px 0;">
    <tr>
        <td align="center">

            <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:8px;overflow:hidden;box-shadow:0 4px 12px rgba(0,0,0,0.08);">

                <!-- HEADER -->
                <tr>
                    <td style="background:#da6c6c;color:#ffffff;padding:20px 30px;">
                        <h2 style="margin:0;font-size:22px;">❌ Booking Cancelled</h2>
                        <p style="margin:5px 0 0;font-size:14px;color:#fecaca;">
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
                            We regret to inform you that your booking has been
                            <strong style="color:#da6c6c;">cancelled</strong>.
                        </p>

                        <table width="100%" cellpadding="10" cellspacing="0" style="margin-top:20px;border-collapse:collapse;">
                            <tr>
                                <td colspan="2" style="background:#f9fafb;font-weight:bold;border:1px solid #e5e7eb;">
                                    📌 Cancellation Details
                                </td>
                            </tr>

                            <tr>
                                <td style="border:1px solid #e5e7eb;background:#f9fafb;">Room Number</td>
                                <td style="border:1px solid #e5e7eb;">{{ $booking->room->room_number }}</td>
                            </tr>

                            <tr>
                                <td style="border:1px solid #e5e7eb;background:#f9fafb;">Check-In</td>
                                <td style="border:1px solid #e5e7eb;">
                                    {{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }}
                                </td>
                            </tr>

                            <tr>
                                <td style="border:1px solid #e5e7eb;background:#f9fafb;">Check-Out</td>
                                <td style="border:1px solid #e5e7eb;">
                                    {{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}
                                </td>
                            </tr>

                            <tr>
                                <td style="border:1px solid #e5e7eb;background:#f9fafb;">Cancellation Reason</td>
                                <td style="border:1px solid #e5e7eb;">
                                    {{ $booking->cancellation_reason }}
                                </td>
                            </tr>

                            <tr>
                                <td style="border:1px solid #e5e7eb;background:#f9fafb;">Refund Amount</td>
                                <td style="border:1px solid #e5e7eb;">
                                    ₹ {{ number_format($booking->refund_amount, 2) }}
                                </td>
                            </tr>
                        </table>

                        <p style="margin-top:20px;font-size:13px;color:#374151;">
                            For any assistance, please contact hotel management.
                        </p>

                        <p style="margin-top:10px;">
                            Regards,<br>
                            <strong>Hotel Management</strong>
                        </p>

                    </td>
                </tr>

                <!-- FOOTER -->
                <tr>
                    <td style="background:#f3f4f6;padding:15px;text-align:center;font-size:12px;color:#6b7280;">
                        © {{ date('Y') }} Hotel Management
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>
