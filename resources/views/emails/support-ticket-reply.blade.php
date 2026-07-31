<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Support Ticket Reply</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; background: #f5f5f5; padding: 30px; margin: 0;">

    <table width="600" align="center" style="background: #ffffff; border-radius: 8px; padding: 30px; border: 1px solid #e2e8f0; font-size: 14px; line-height: 1.6; color: #333333;">

        <tr>
            <td>
                <div style="text-align: center; margin-bottom: 20px;">
                    <h2 style="color: #C25A2A; margin: 0; font-size: 22px;">Support Ticket Update</h2>
                    <p style="color: #64748b; font-size: 13px; margin-top: 5px;">Ticket #{{ $ticket->ticket_number }}</p>
                </div>

                <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 20px 0;">

                <p>Hello <strong>{{ $ticket->name ?? ($ticket->user->name ?? 'Customer') }}</strong>,</p>

                <p>Our support team has posted a reply to your ticket regarding: <strong>{{ $ticket->subject ?? 'General Support Inquiry' }}</strong></p>

                <div style="background: #f8fafc; border-left: 4px solid #C25A2A; border-radius: 6px; padding: 16px; margin: 20px 0;">
                    <p style="margin: 0; font-weight: bold; color: #475569; font-size: 13px; text-transform: uppercase; margin-bottom: 8px;">Support Team Response:</p>
                    <div style="color: #1e293b; white-space: pre-line;">{!! nl2br(e($messageContent)) !!}</div>
                </div>

                <div style="background: #f1f5f9; border-radius: 6px; padding: 12px 16px; margin-bottom: 20px;">
                    <span style="color: #64748b; font-size: 13px;">Current Ticket Status: </span>
                    <strong style="color: #0f172a; text-transform: capitalize;">{{ str_replace('_', ' ', $ticket->status) }}</strong>
                </div>

                <p style="color: #64748b; font-size: 13px; margin-top: 30px; border-top: 1px solid #e2e8f0; padding-top: 15px;">
                    If you have further questions, please feel free to reply or visit the support portal.
                </p>

                <p style="color: #94a3b8; font-size: 12px; margin: 0; text-align: center;">
                    &copy; {{ date('Y') }} {{ config('app.name', 'Support Team') }}. All rights reserved.
                </p>
            </td>
        </tr>

    </table>

</body>
</html>
