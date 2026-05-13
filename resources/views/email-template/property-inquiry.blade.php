<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Property Inquiry</title>
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
            <h1>New Property Inquiry</h1>
        </div>
        <div class="content">
            <h2>Property: {{ $inquiryData['property_name'] }}</h2>
            <p>You have received a new inquiry for your property (ID: {{ $inquiryData['property_id'] }}).</p>

            <table>
                <tr>
                    <td>Name</td>
                    <td>{{ $inquiryData['first_name'] }} {{ $inquiryData['last_name'] }}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>{{ $inquiryData['email'] }}</td>
                </tr>
                <tr>
                    <td>Phone</td>
                    <td>{{ $inquiryData['phone'] }}</td>
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
            <h3 style="color: #113D48;">Message</h3>
            <div class="message-box">
                {{ $inquiryData['message'] }}
            </div>
            @endif
        </div>
        <div class="footer">
            <p>This inquiry was sent from your property listing on {{ config('app.name') }}.</p>
        </div>
    </div>
</body>
</html>
