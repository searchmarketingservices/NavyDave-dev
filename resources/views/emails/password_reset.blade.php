<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <table align="center" width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px;">
        <tr>
            <td style="background-color: #2CC374; padding: 20px; color: #ffffff; text-align: center;">
                <h1>Reset Your Password</h1>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px;">
                <p>Click the button below to reset your password:</p>
                <p><a href="{{ $resetUrl }}" style="padding: 10px 20px; background-color: #2CC374; color: #ffffff; text-decoration: none; border-radius: 5px;">Reset Password</a></p>
                <p>If you did not request a password reset, please ignore this email.</p>
            </td>
        </tr>
    </table>
</body>
</html>
