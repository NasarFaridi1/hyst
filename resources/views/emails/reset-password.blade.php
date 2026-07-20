<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>

<body style="margin:0;padding:0;background:#F5F0E8;font-family:Arial,Helvetica,sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#F5F0E8;padding:40px 15px;">
        <tr>
            <td align="center">

                <table width="600" cellpadding="0" cellspacing="0" border="0"
                    style="background:#ffffff;border-radius:20px;overflow:hidden;">

                    <!-- Header -->
                    <tr>
                        <td align="center"
                            style="background:#E63946;padding:35px 20px;">

                            <h1
                                style="margin:0;color:#ffffff;font-size:30px;font-weight:700;">
                                HYST
                            </h1>

                            <p
                                style="margin:12px 0 0;color:#ffeaea;font-size:15px;">
                                Password Reset Request
                            </p>

                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:45px 40px;">

                            <h2
                                style="margin:0 0 20px;color:#111;font-size:28px;">
                                Hello {{ $user->name }},
                            </h2>

                            <p
                                style="font-size:16px;line-height:30px;color:#555;margin:0 0 20px;">
                                We received a request to reset your account
                                password.
                            </p>

                            <p
                                style="font-size:16px;line-height:30px;color:#555;margin:0 0 35px;">
                                Click the button below to create a new password.
                                This secure link will expire in
                                <strong>30 minutes</strong>.
                            </p>

                            <table cellpadding="0" cellspacing="0" border="0" align="center">
                                <tr>
                                    <td align="center"
                                        style="border-radius:12px;background:#E63946;">

                                        <a href="{{ $url }}"
                                            style="
                                                display:inline-block;
                                                padding:16px 38px;
                                                color:#ffffff;
                                                text-decoration:none;
                                                font-size:17px;
                                                font-weight:bold;
                                            ">
                                            Reset Password
                                        </a>

                                    </td>
                                </tr>
                            </table>

                            <p
                                style="margin:40px 0 15px;font-size:15px;color:#777;">
                                If the button doesn't work, copy and paste this
                                link into your browser:
                            </p>

                            <p
                                style="word-break:break-all;font-size:13px;color:#E63946;">
                                {{ $url }}
                            </p>

                            <hr
                                style="border:none;border-top:1px solid #ECECEC;margin:40px 0;">

                            <p
                                style="font-size:14px;line-height:28px;color:#777;margin:0;">
                                If you did not request a password reset, you can
                                safely ignore this email. Your password will
                                remain unchanged.
                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td
                            style="background:#F8F8F8;padding:25px;text-align:center;">

                            <p
                                style="margin:0;font-size:14px;color:#777;">
                                © {{ date('Y') }} HYST. All rights reserved.
                            </p>

                            <p
                                style="margin:10px 0 0;font-size:13px;color:#999;">
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