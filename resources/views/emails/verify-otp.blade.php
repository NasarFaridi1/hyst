<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Verify Your Email - HYST</title>
</head>

<body style="margin:0;padding:0;background:#f5f0e8;font-family:Arial,Helvetica,sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 20px;">
        <tr>
            <td align="center">

                <table width="600" cellpadding="0" cellspacing="0"
                    style="background:#ffffff;border-radius:20px;overflow:hidden;box-shadow:0 10px 30px rgba(0,0,0,.08);">

                    <!-- Header -->
                    <tr>
                        <td align="center"
                            style="background:#C25A2A;padding:35px 20px;color:#ffffff;">

                            <div style="font-size:34px;">🍽️</div>

                            <h1 style="margin:10px 0 0;font-size:28px;font-weight:700;">
                                HYST
                            </h1>

                            <p style="margin-top:8px;font-size:15px;opacity:.9;">
                                Email Verification
                            </p>

                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:40px;">

                            <h2 style="margin:0 0 15px;color:#222;">
                                Welcome to HYST 👋
                            </h2>

                            <p style="font-size:16px;color:#555;line-height:28px;margin:0;">
                                Thank you for creating your HYST account.
                                Please use the verification code below to verify your email address.
                            </p>

                            <div
                                style="margin:35px 0;background:#F8F8F8;border:2px dashed #C25A2A;border-radius:16px;padding:22px;text-align:center;">

                                <div style="font-size:13px;color:#888;margin-bottom:10px;">
                                    YOUR VERIFICATION CODE
                                </div>

                                <div
                                    style="font-size:42px;font-weight:700;letter-spacing:10px;color:#C25A2A;">
                                    {{ $otp }}
                                </div>

                            </div>

                            <p style="font-size:15px;color:#555;line-height:26px;">
                                This verification code will expire in
                                <strong>10 minutes</strong>.
                            </p>

                            <p style="font-size:15px;color:#555;line-height:26px;">
                                If you didn't create a HYST account, you can safely ignore this email.
                            </p>

                            <p style="font-size:14px;color:#777;line-height:24px;text-align:center;">
                                If the button doesn't work, copy and paste this link into your browser:
                            </p>

                            <p style="text-align:center;word-break:break-all;">
                                <a href="{{ $verifyUrl }}"
                                    style="color:#C25A2A;text-decoration:none;font-size:14px;">
                                    {{ $verifyUrl }}
                                </a>
                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center"
                            style="background:#fafafa;padding:25px;border-top:1px solid #eee;">

                            <p style="margin:0;color:#888;font-size:14px;">
                                © {{ date('Y') }} HYST. All rights reserved.
                            </p>

                            <p style="margin-top:8px;color:#999;font-size:13px;">
                                This is an automated email. Please do not reply.
                            </p>

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

    

</body>

</html>