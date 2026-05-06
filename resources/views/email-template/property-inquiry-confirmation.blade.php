<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Inquiry Confirmation</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 20px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .header { background: #113D48; color: #ffffff; padding: 20px; text-align: center; }
        .header h1 { margin: 0; font-size: 22px; }
        .content { padding: 25px; }
        .content h2 { color: #113D48; font-size: 18px; margin-top: 0; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        table td { padding: 10px 12px; border-bottom: 1px solid #eee; }
        table td:first-child { font-weight: bold; width: 40%; color: #555; }
        .message-box { background: #f9f9f9; padding: 15px; border-left: 3px solid #113D48; margin: 15px 0; border-radius: 4px; }
        .footer { background: #f4f4f4; padding: 15px; text-align: center; font-size: 12px; color: #999; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Inquiry Confirmation</h1>
        </div>
        <div class="content">
            <p>Dear {{ $inquiryData['first_name'] }} {{ $inquiryData['last_name'] }},</p>
            <p>Thank you for your inquiry regarding <strong>{{ $inquiryData['property_name'] }}</strong>. The property owner has been notified and will get back to you shortly.</p>

            <h3 style="color: #113D48;">Your Inquiry Details</h3>
            <table>
                <tr>
                    <td>Property</td>
                    <td>{{ $inquiryData['property_name'] }}</td>
                </tr>
                @if(!empty($inquiryData['checkin']))
                <tr>
                    <td>Check In</td>
                    <td>{{ $inquiryData['checkin'] }}</td>
                </tr>
                @endif
                @if(!empty($inquiryData['checkout']))
                <tr>
                    <td>Check Out</td>
                    <td>{{ $inquiryData['checkout'] }}</td>
                </tr>
                @endif
                @if($inquiryData['adults'] > 0)
                <tr>
                    <td>Adults</td>
                    <td>{{ $inquiryData['adults'] }}</td>
                </tr>
                @endif
                @if($inquiryData['children'] > 0)
                <tr>
                    <td>Children</td>
                    <td>{{ $inquiryData['children'] }}</td>
                </tr>
                @endif
            </table>

            @if(!empty($inquiryData['message']))
            <h3 style="color: #113D48;">Your Message</h3>
            <div class="message-box">
                {{ $inquiryData['message'] }}
            </div>
            @endif

            <p style="margin-top: 20px;">If you have any questions, feel free to reach out to us.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
