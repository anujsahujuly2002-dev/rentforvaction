<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome to RentforVacations</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 20px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .header { background: #113D48; color: #ffffff; padding: 30px 20px; text-align: center; }
        .header h1 { margin: 0; font-size: 28px; }
        .content { padding: 30px; }
        .content h2 { color: #113D48; font-size: 20px; margin-top: 0; margin-bottom: 15px; }
        .content p { font-size: 14px; line-height: 1.8; margin-bottom: 15px; }
        .welcome-box { background: #f0f8f9; padding: 20px; border-left: 4px solid #113D48; margin: 20px 0; border-radius: 4px; }
        .welcome-box h3 { color: #113D48; margin-top: 0; font-size: 16px; }
        .welcome-box ul { margin: 10px 0; padding-left: 20px; }
        .welcome-box li { margin-bottom: 8px; }
        .cta-button { display: inline-block; background: #113D48; color: #ffffff; padding: 12px 30px; text-decoration: none; border-radius: 4px; margin-top: 20px; font-weight: bold; }
        .footer { background: #f4f4f4; padding: 20px; text-align: center; font-size: 12px; color: #999; }
        .footer a { color: #113D48; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to RentforVacations! 🎉</h1>
        </div>
        <div class="content">
            <h2>Hello {{ $user->name }},</h2>
            <p>Thank you for registering with RentforVacations! We're excited to have you as a property owner on our platform.</p>

            <div class="welcome-box">
                <h3>Your Registration is Complete!</h3>
                <p>Your account has been successfully created with the following details:</p>
                <table style="width: 100%; font-size: 14px;">
                    <tr>
                        <td style="padding: 8px; color: #666;"><strong>Name:</strong></td>
                        <td style="padding: 8px;">{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; color: #666;"><strong>Email:</strong></td>
                        <td style="padding: 8px;">{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; color: #666;"><strong>Password:</strong></td>
                        <td style="padding: 8px;">{{ $password }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; color: #666;"><strong>Account Type:</strong></td>
                        <td style="padding: 8px;">Property Owner</td>
                    </tr>
                </table>
            </div>

            <h3 style="color: #113D48;">What's Next?</h3>
            <p>Now that you're registered, you can:</p>
            <ul>
                <li>Log in to your owner dashboard</li>
                <li>Add your properties to our platform</li>
                <li>Manage bookings and reservations</li>
                <li>View analytics and reports</li>
                <li>Respond to guest inquiries</li>
            </ul>

            <p>We recommend completing your profile and uploading your first property to get started with earning!</p>

            <a href="{{ route('frontend.log-in') }}" class="cta-button">Go to Login</a>
        </div>
        <div class="footer">
            <p>If you did not register for this account, please contact us immediately at <a href="mailto:support@rentforvacations.com">support@rentforvacations.com</a></p>
            <p style="margin-top: 10px; font-size: 11px; color: #bbb;">© {{ date('Y') }} RentforVacations. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
