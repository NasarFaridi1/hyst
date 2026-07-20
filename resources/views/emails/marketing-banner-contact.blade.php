<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Marketing Banner Enquiry</title>
</head>

<body style="font-family:Arial,Helvetica,sans-serif;background:#f5f5f5;padding:30px;">

    <table width="600" align="center"
        style="background:#fff;border-radius:8px;padding:30px;border:1px solid #ddd;">

        <tr>
            <td>
                <h2 style="color:#C25A2A;">
                    New Marketing Banner Enquiry
                </h2>

                <hr>

                <p>
                    <strong>Banner:</strong>
                    {{ $banner->title }}
                </p>

                <p>
                    <strong>Name:</strong>
                    {{ $data->name }}
                </p>

                <p>
                    <strong>Email:</strong>
                    {{ $data->email }}
                </p>

                <p>
                    <strong>Phone:</strong>
                    {{ $data->phone }}
                </p>

                <p>
                    <strong>Message:</strong>
                </p>

                <div
                    style="background:#f8f8f8;padding:15px;border-radius:6px;border-left:4px solid #C25A2A;">
                    {!! nl2br(e($data->message)) !!}
                </div>

            </td>
        </tr>

    </table>

</body>

</html>