<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px;">
    <table align="center" width="600" cellpadding="0" cellspacing="0" style="max-width: 600px; width: 100%; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); overflow: hidden;">
        <tr>
            <td style="background-color: #2CC374; padding: 20px; text-align: center; color: #ffffff;">
                {{-- <img src="{{ asset('assets/images/logoWhite.png') }}" width="100px" alt=""> --}}
                <h1 style="margin: 0; font-size: 24px;">Welcome to Navy Dave Golf!</h1>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px;">
                <p style="font-size: 16px; margin-bottom: 20px;">Hi {{ $user->name }} {{ $user->last_name }},</p>

                <p style="font-size: 16px; margin-bottom: 20px;">We’re excited to let you know that your registration was successful. You are now part of the Navy Dave Golf family!</p>
                <p style="font-size: 16px; margin-bottom: 20px;">To get started, simply click the button below to log in to your account:</p>
                <table cellpadding="0" cellspacing="0" border="0" align="center" style="margin-top: 20px;">
                    <tr>
                        <td align="center" bgcolor="#2CC374" style="border-radius: 5px;">
                            <a href="{{ config('app.url') }}login" style="display: inline-block; padding: 15px 30px; font-size: 16px; color: #ffffff; text-decoration: none; background-color: #2CC374; border-radius: 5px;">Login to Your Account</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding: 10px; text-align: center; font-size: 12px; color: #888888;">
                <p>If you have any questions or need assistance, feel free to reach out to our support team at {{ $settings[0]->email ?? '-' }}.</p>
                <p>Thank you for joining us, and happy golfing!</p>
                <p>Best regards,<br>The Navy Dave Golf Team</p>
            </td>
        </tr>
    </table>
</body>
</html>
