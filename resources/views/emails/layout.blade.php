<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification — HA Tech</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #0c0c12; color: #ffffff; margin: 0; padding: 0; -webkit-font-smoothing: antialiased; }
        .wrapper { width: 100%; table-layout: fixed; background-color: #0c0c12; padding-top: 50px; padding-bottom: 50px; }
        .main { background-color: #111118; margin: 0 auto; width: 100%; max-width: 600px; border-radius: 24px; border: 1px solid rgba(255,255,255,0.05); overflow: hidden; box-shadow: 0 20px 50px rgba(0,0,0,0.5); }
        .header { text-align: center; padding: 45px 20px 25px; background: linear-gradient(to bottom, rgba(212,168,83,0.05) 0%, transparent 100%); }
        .header img { width: 70px; height: auto; filter: drop-shadow(0 0 10px rgba(212,168,83,0.3)); }
        .content { padding: 40px; font-size: 16px; line-height: 1.7; color: #b0b0b8; }
        h1 { color: #ffffff; font-size: 24px; font-weight: 800; margin-top: 0; margin-bottom: 24px; text-align: center; letter-spacing: -0.02em; }
        .custom-content b { color: #D4A853; }
        .custom-content a { color: #D4A853; font-weight: bold; text-decoration: none; border-bottom: 1px solid rgba(212,168,83,0.3); }
        .btn { display: inline-block; padding: 16px 32px; background: linear-gradient(135deg, #A67C3A, #D4A853); color: #000000 !important; text-decoration: none; font-weight: 900; border-radius: 12px; margin-top: 25px; margin-bottom: 25px; font-size: 13px; text-transform: uppercase; letter-spacing: 2px; box-shadow: 0 10px 20px rgba(212,168,83,0.2); }
        .footer { text-align: center; padding: 40px; background-color: #050508; border-top: 1px solid rgba(255,255,255,0.03); font-size: 11px; color: #3f3f46; line-height: 1.8; }
        .footer .thank-you { font-size: 14px; font-weight: bold; color: #71717a; margin-bottom: 15px; letter-spacing: 1px; }
        .footer a { color: #A67C3A; text-decoration: none; }
        .address { margin-top: 15px; color: #27272a; font-style: normal; text-transform: uppercase; letter-spacing: 1px; }
        .unsubscribe { margin-top: 20px; font-size: 10px; color: #18181b; }
    </style>
</head>
<body>
    <center class="wrapper">
        <!--[if mso]>
        <table role="presentation" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
        <tr>
        <td>
        <![endif]-->
        <table class="main" width="100%" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td class="header">
                    <img src="{{ asset('HA-Tech.png') }}" alt="HA Tech Premium">
                </td>
            </tr>
            <tr>
                <td class="content">
                    @yield('content')
                </td>
            </tr>
            <tr>
                <td class="footer">
                    <div class="thank-you">THE NEXT GENERATION OF TECH</div>
                    &copy; {{ date('Y') }} HA Tech Portfolio Generator. All rights reserved.<br>
                    You are receiving this because you are an authorized agent on our platform.
                    
                    <div class="address">
                        HA TECH HQ • KARACHI CENTRAL • PAKISTAN<br>
                        SECURE CLOUD INFRASTRUCTURE • RSA-4096 ENCRYPTED
                    </div>

                    <div class="unsubscribe">
                        This is a transactional message sent to <span style="color:#505058;">{{ $user->email ?? 'authorized user' }}</span>.<br>
                        Manage your notification preferences in your <a href="{{ url('/profile') }}">Account Settings</a>.
                    </div>
                </td>
            </tr>
        </table>
        <!--[if mso]>
        </td>
        </tr>
        </table>
        <![endif]-->
    </center>
</body>
</html>
