<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Request</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px;">
    <table align="center" width="600" cellpadding="0" cellspacing="0" style="max-width: 600px; width: 100%; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); overflow: hidden;">
        <tr>
            <td style="background-color: #2CC374; padding: 20px; text-align: center; color: #ffffff;">
                <h1 style="margin: 0; font-size: 24px;">Password Reset Request</h1>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px;">
                <p style="font-size: 16px; margin-bottom: 20px;">Hi {{ $notifiable->name }},</p>
                
                <p style="font-size: 16px; margin-bottom: 20px;">
                    We received a request to reset your password. Click the button below to reset it:
                </p>
                
                <table cellpadding="0" cellspacing="0" border="0" align="center" style="margin-top: 20px;">
                    <tr>
                        <td align="center" bgcolor="#2CC374" style="border-radius: 5px;">
                            <a href="{{ $resetUrl }}" style="display: inline-block; padding: 15px 30px; font-size: 16px; color: #ffffff; text-decoration: none; background-color: #2CC374; border-radius: 5px;">Reset Password</a>
                        </td>
                    </tr>
                </table>
                
                <p style="font-size: 16px; margin-top: 20px;">
                    If you didn’t request a password reset, you can safely ignore this email.
                </p>
            </td>
        </tr>
        <tr>
            <td style="padding: 10px; text-align: center; font-size: 12px; color: #888888;">
                <p>If you need further assistance, please contact our support team at info@navydavegolf.com .</p>
                <p>Thank you,<br>The Navy Dave Golf Team</p>
            </td>
        </tr>
    </table>
</body>
</html>
