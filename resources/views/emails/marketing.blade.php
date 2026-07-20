<!DOCTYPE html>

<html>

<head>

    <meta charset="UTF-8">

    <title>

        {{ $subjectText }}

    </title>

</head>


<body style="
margin:0;
padding:30px 15px;
background:#F6F1E8;
font-family:Arial,sans-serif;
">


    <table width="100%" cellspacing="0" cellpadding="0">


        <tr>


            <td align="center">


                <table width="600" cellspacing="0" cellpadding="0" style="

max-width:600px;

width:100%;

background:white;

border-radius:18px;

overflow:hidden;

box-shadow:

0 5px 25px

rgba(0,0,0,.08);

">


                    <tr>


                        <td style="

background:

linear-gradient(

135deg,

#C25A2A,

#8C3D1A

);

padding:35px;

text-align:center;

color:white;

">


                            <h1 style="

margin:0;

font-size:26px;

">


                                HYST Restaurant


                            </h1>


                        </td>


                    </tr>



                    <tr>


                        <td style="

padding:35px;

color:#2E2318;

">


                            <h2 style="

margin:0 0 18px;

">


                                Hello

                                {{ $user->name }}


                            </h2>


                            <p style="

font-size:16px;

line-height:1.8;

margin:0;

">


                                {!! nl2br(

    e(

        $messageText

    )

) !!}


                            </p>


                            <p style="

margin-top:

35px;

font-size:

14px;

color:

#8A7A62;

">


                                Thank you for being

                                our valued customer.


                            </p>


                            <p style="

margin-top:

20px;

font-size:

14px;

color:

#2E2318;

">


                                Regards,

                                <br>

                                <strong style="

color:

#C25A2A;

">


                                    HYST Restaurant


                                </strong>


                            </p>


                        </td>


                    </tr>


                    <tr>


                        <td style="

background:

#F6F1E8;

padding:

20px;

text-align:

center;

font-size:

12px;

color:

#8A7A62;

">


                            © {{ date('Y') }}

                            HYST Restaurant


                        </td>


                    </tr>


                </table>


            </td>


        </tr>


    </table>


</body>


</html>