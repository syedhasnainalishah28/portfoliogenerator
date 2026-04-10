<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #050505; color: #ffffff; margin: 0; padding: 0; }
        .wrapper { width: 100%; table-layout: fixed; background-color: #050505; padding-top: 40px; padding-bottom: 40px; }
        .main { background-color: #111111; margin: 0 auto; width: 100%; max-width: 600px; border-radius: 16px; border: 1px solid #333333; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.8); }
        .header { text-align: center; padding: 40px 20px 20px; }
        .header img { width: 60px; height: auto; }
        .content { padding: 30px; font-size: 15px; line-height: 1.6; color: #dddddd; }
        h1 { color: #ffffff; font-size: 22px; font-weight: bold; margin-top: 0; margin-bottom: 20px; text-align: center; }
        .btn { display: inline-block; padding: 14px 28px; background-color: #f2b311; color: #000000; text-decoration: none; font-weight: bold; border-radius: 8px; margin-top: 20px; margin-bottom: 20px; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; }
        .footer { text-align: center; padding: 30px; border-top: 1px solid #222222; font-size: 12px; color: #666666; }
        .footer .thank-you { font-size: 16px; font-weight: bold; color: #ffffff; margin-bottom: 10px; }
        .panel { background-color: #1a1a1a; border: 1px solid #333333; border-radius: 8px; padding: 20px; margin-bottom: 20px; }
        .key-display { font-family: monospace; font-size: 20px; color: #f2b311; text-align: center; padding: 15px; background-color: #0a0a0a; border: 1px solid #333333; border-radius: 6px; letter-spacing: 3px; font-weight: bold; }
    </style>
</head>
<body>
    <center class="wrapper">
        <table class="main" width="100%">
            <tr>
                <td class="header">
                    <!-- Absolute Path using URL facade for Email rendering -->
                    <img src="{{ url('HA-Tech.png') }}" alt="HA Tech Logo">
                </td>
            </tr>
            <tr>
                <td class="content">
                    @yield('content')
                </td>
            </tr>
            <tr>
                <td class="footer">
                    <div class="thank-you">Thank you for trusting HA Tech!</div>
                    &copy; {{ date('Y') }} HA Tech. All rights reserved.<br>
                    Automated System Message - Please do not reply directly to this email.
                </td>
            </tr>
        </table>
    </center>
</body>
</html>
