<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Account Details</title>
</head>
<body style="margin:0;padding:0;background:#F5F0E8;font-family:Arial,Helvetica,sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#F5F0E8;padding:40px 15px;">
        <tr>
            <td align="center">

                <table width="600" cellpadding="0" cellspacing="0" border="0"
                    style="background:#ffffff;border-radius:20px;overflow:hidden;box-shadow:0 4px 15px rgba(0,0,0,0.05);">

                    <!-- Header -->
                    <tr>
                        <td align="center" style="background:#C25A2A;padding:35px 20px;">
                            <h1 style="margin:0;color:#ffffff;font-size:30px;font-weight:700;letter-spacing:1px;">
                                HYST
                            </h1>
                            <p style="margin:8px 0 0;color:#ffeaea;font-size:15px;">
                                Account Created Successfully
                            </p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:40px 35px;">

                            <h2 style="margin:0 0 16px;color:#111;font-size:24px;">
                                Hello {{ $user->name }},
                            </h2>

                            <p style="font-size:15px;line-height:26px;color:#555;margin:0 0 20px;">
                                Thank you for ordering with us! We have automatically created an account for you so you can easily track your order, view past receipts, and reorder anytime.
                            </p>

                            <!-- Credentials Box -->
                            <div style="background:#FAF7F2;border:1px solid #F0E4D8;border-radius:14px;padding:20px 24px;margin:24px 0;">
                                <p style="margin:0 0 10px;font-size:14px;font-weight:bold;color:#C25A2A;text-transform:uppercase;letter-spacing:0.5px;">
                                    Your Login Credentials
                                </p>
                                <p style="margin:6px 0;font-size:15px;color:#333;">
                                    <strong>Email:</strong> {{ $user->email }}
                                </p>
                                <p style="margin:6px 0;font-size:15px;color:#333;">
                                    <strong>Temporary Password:</strong> <span style="background:#fff;padding:3px 10px;border-radius:6px;border:1px solid #E5E7EB;font-family:monospace;font-weight:bold;color:#C25A2A;">{{ $password }}</span>
                                </p>
                            </div>

                            <p style="font-size:14px;line-height:24px;color:#666;margin:0 0 28px;">
                                You can log in using these credentials anytime at <a href="{{ url('/login') }}" style="color:#C25A2A;text-decoration:underline;">{{ url('/login') }}</a>.
                            </p>

                            <table cellpadding="0" cellspacing="0" border="0" align="center">
                                <tr>
                                    <td align="center" style="border-radius:12px;background:#C25A2A;">
                                        <a href="{{ url('/login') }}"
                                            style="
                                                display:inline-block;
                                                padding:14px 32px;
                                                color:#ffffff;
                                                text-decoration:none;
                                                font-size:15px;
                                                font-weight:bold;
                                            ">
                                            Log In To Your Account
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <hr style="border:none;border-top:1px solid #ECECEC;margin:35px 0 25px;">

                            <p style="font-size:13px;line-height:20px;color:#888;margin:0;text-align:center;">
                                If you have any questions or need assistance, feel free to contact our support team.
                            </p>

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>
