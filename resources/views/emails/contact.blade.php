<!DOCTYPE html>
<html dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>رسالة جديدة من نموذج التواصل</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f6fb;
            font-family: 'Segoe UI', Arial, sans-serif;
            color: #333;
        }

        @media only screen and (max-width: 620px) {
            .container {
                width: 100% !important;
                padding: 10px !important;
            }

            .main-content {
                padding: 15px !important;
            }

            .logo {
                max-width: 100px !important;
            }

            .cta-btn {
                font-size: 15px !important;
                padding: 12px 24px !important;
            }
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .header {
            text-align: center;
            padding: 30px 20px;
            background: linear-gradient(90deg, #e3eafc 0%, #f8f9fb 100%);
        }

        .logo {
            max-width: 120px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07);
            margin-bottom: 10px;
        }

        .site-name {
            font-size: 26px;
            font-weight: 700;
            color: #2d3a4a;
            letter-spacing: 1px;
        }

        .main-content {
            padding: 28px 32px;
        }

        .label {
            font-weight: 700;
            color: #555;
            display: block;
            margin-top: 12px;
        }

        .message-box {
            background: #f0f3f5;
            padding: 15px;
            border-radius: 6px;
            margin-top: 8px;
            white-space: pre-wrap;
        }

        .cta-btn {
            display: inline-block;
            background: #5f662d;
            color: #fff !important;
            font-size: 16px;
            font-weight: 600;
            padding: 14px 32px;
            border-radius: 28px;
            text-decoration: none;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.12);
            transition: background 0.2s;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #888;
            padding: 18px 10px;
            border-top: 1px solid #e3eafc;
            background: #f4f6fb;
        }
    </style>
</head>

<body>
    <table role="presentation" dir="rtl" width="100%" cellspacing="0" cellpadding="0" style="min-height:100vh;">
        <tr>
            <td align="center">
                <table class="container" role="presentation" width="600" cellspacing="0" cellpadding="0">
                    <!-- Header -->
                    <tr>
                        <td class="header">
                            <img src="{{ $community_logo ?? '' }}" alt="Logo" class="logo">
                            <div class="site-name">{{ config('app.name') }}</div>
                        </td>
                    </tr>

                    <!-- Main Content -->
                    <tr>
                        <td class="main-content">
                            <h2 style="color:#3498db; margin-bottom:20px;">رسالة جديدة من نموذج التواصل</h2>

                            <p class="label">الاسم الكامل:</p>
                            <div>{{ $data['full_name'] }}</div>

                            <p class="label">رقم الهاتف:</p>
                            <div>{{ $data['phone'] }}</div>

                            <p class="label">البريد الإلكتروني:</p>
                            <div>{{ $data['email'] }}</div>

                            <p class="label">الموضوع:</p>
                            <div>{{ $data['subject'] }}</div>

                            <p class="label">الرسالة:</p>
                            <div class="message-box">{{ $data['message'] }}</div>

                            @auth
                                <div style="text-align:center; margin-top:25px;">
                                    <a href="{{ route('admin.members.show', ['user' => auth()->user()]) }}" class="cta-btn">
                                        عرض بيانات المستخدم
                                    </a>
                                </div>
                            @endauth

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td class="footer">
                            &copy; {{ date('Y') }} {{ config('app.name') }}. جميع الحقوق محفوظة.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
