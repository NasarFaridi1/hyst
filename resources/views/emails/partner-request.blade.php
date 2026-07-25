<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Partner Request</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f7f7f7; color: #333; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .header { text-align: center; border-bottom: 2px solid #F0F0EC; padding-bottom: 20px; margin-bottom: 20px; }
        .header h2 { color: #C25A2A; margin: 0; font-size: 24px; }
        .badge { display: inline-block; background: #C25A2A; color: #ffffff; padding: 6px 14px; border-radius: 20px; font-weight: bold; font-size: 14px; margin-top: 10px; }
        .details-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .details-table th, .details-table td { text-align: left; padding: 12px 15px; border-bottom: 1px solid #eeeeee; }
        .details-table th { background-color: #fcfcfc; color: #666; font-weight: 600; width: 35%; }
        .footer { margin-top: 30px; text-align: center; font-size: 12px; color: #888; border-top: 1px solid #eeeeee; padding-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>HYST - Partner Request</h2>
            <div class="badge">{{ $data['partner_type'] ?? 'Partner' }}</div>
        </div>

        <p>A new user has submitted a partner request on the HYST platform. Details below:</p>

        <table class="details-table">
            <tr>
                <th>Partner Type</th>
                <td><strong>{{ $data['partner_type'] ?? 'N/A' }}</strong></td>
            </tr>
            <tr>
                <th>Full Name</th>
                <td>{{ $data['name'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Email Address</th>
                <td><a href="mailto:{{ $data['email'] ?? '' }}">{{ $data['email'] ?? 'N/A' }}</a></td>
            </tr>
            <tr>
                <th>Phone Number</th>
                <td><a href="tel:{{ $data['phone_number'] ?? '' }}">{{ $data['phone_number'] ?? 'N/A' }}</a></td>
            </tr>
            <tr>
                <th>Location</th>
                <td>{{ $data['location'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Submitted At</th>
                <td>{{ now()->format('F j, Y, g:i a') }}</td>
            </tr>
        </table>

        <div class="footer">
            <p>This is an automated notification sent from the HYST platform partner request form.</p>
        </div>
    </div>
</body>
</html>
