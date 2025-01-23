<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px;">
    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="background-color: #f4f4f4; margin: 0; padding: 0;">
        <tr>
            <td align="center" style="padding: 20px;">
                <table cellpadding="0" cellspacing="0" border="0" width="600" style="background-color: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td align="center" style="background-color: #2CC374; padding: 20px; color: white;">
                            <h1 style="margin: 0;">Appointment Rescheduled Successfully</h1>
                        </td>
                    </tr>
                    <!-- Body -->
                    <tr>
                        <td style="padding: 20px;">
                            <p style="margin: 0 0 15px 0;">Hello @if($role == 'user') {{ $appointment->first_name }} {{ $appointment->last_name }} @elseif($role == 'staff') {{ $appointment->staff->user->name }} @else Admin @endif,</p>
                            


                            @if($role == 'user')
                            <p style="margin: 0 0 20px 0;">Your appointment has been successfully rescheduled!</p>
                            @elseif($role == 'staff' || $role == 'admin')
                            <p style="margin: 0 0 20px 0;">An appointment has been successfully rescheduled!</p>
                            @endif

                            <!-- Appointment Details -->
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="border: 1px solid #2CC374; border-radius: 5px; padding: 15px; background-color: #f9f9f9;">
                                <tr>
                                    <td style="padding: 8px 0; border-bottom: 1px solid #ddd;"><strong style="color: #2CC374;">Appointment ID:</strong></td>
                                    <td style="padding: 8px 0; border-bottom: 1px solid #ddd; text-align: right;">{{ $appointment->id }}</td>
                                </tr>
                                @if ($role == 'admin' || $role == 'staff')
                                <tr>
                                    <td style="padding: 8px 0; border-bottom: 1px solid #ddd;"><strong style="color: #2CC374;">Name:</strong></td>
                                    <td style="padding: 8px 0; border-bottom: 1px solid #ddd; text-align: right;">{{ $appointment->first_name }} {{ $appointment->last_name }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td style="padding: 8px 0; border-bottom: 1px solid #ddd;"><strong style="color: #2CC374;">Date:</strong></td>
                                    <td style="padding: 8px 0; border-bottom: 1px solid #ddd; text-align: right;">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y') }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; border-bottom: 1px solid #ddd;"><strong style="color: #2CC374;">Service:</strong></td>
                                    <td style="padding: 8px 0; border-bottom: 1px solid #ddd; text-align: right;">{{ $appointment->service->name }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; border-bottom: 1px solid #ddd;"><strong style="color: #2CC374;">Staff:</strong></td>
                                    <td style="padding: 8px 0; border-bottom: 1px solid #ddd; text-align: right;">{{ $appointment->staff->user->name }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; border-bottom: 1px solid #ddd;"><strong style="color: #2CC374;">Slot Time:</strong></td>
                                    <td style="padding: 8px 0; border-bottom: 1px solid #ddd; text-align: right;">{{ \Carbon\Carbon::parse($appointment->slot->available_from)->format('h:i A') }} to {{ \Carbon\Carbon::parse($appointment->slot->available_to)->format('h:i A') }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; border-bottom: 1px solid #ddd;"><strong style="color: #2CC374;">Location:</strong></td>
                                    <td style="padding: 8px 0; border-bottom: 1px solid #ddd; text-align: right;">{{ $appointment->location }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; border-bottom: 1px solid #ddd;"><strong style="color: #2CC374;">Notes:</strong></td>
                                    <td style="padding: 8px 0; border-bottom: 1px solid #ddd; text-align: right;">{{ $appointment->notes }}</td>
                                </tr>
                            </table>
                            <!-- Call to Action Button -->
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-top: 20px;">
                                <tr>
                                    <td align="center">
                                        {{-- <a href="{{ route('user.dashboard') }}" style="background-color: #2CC374; color: white; padding: 15px 30px; text-align: center; text-decoration: none; border-radius: 5px; font-size: 16px; display: inline-block;">View All Appointments</a> --}}
                                        <a href="{{ config('app.url') }}user/dashboard" style="background-color: #2CC374; color: white; padding: 15px 30px; text-align: center; text-decoration: none; border-radius: 5px; font-size: 16px; display: inline-block;">View All Appointments</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td style="padding: 10px; text-align: center; font-size: 12px; color: #888;">
                            <p style="margin: 0 0 5px 0;">If you have any questions or need assistance, feel free to reach out to our support team at [support email].</p>
                            <p style="margin: 0;">Thank you!</p>
                            <p style="margin: 5px 0 0 0;">Best regards,<br>The Navy Dave Golf Team</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>