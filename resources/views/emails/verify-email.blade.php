<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('mails.Verify_Email_Address') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            color: #4a4a4a;
            direction: rtl;
        }

        .container {
            height: 100%;
            width: 100%;
            background-color: #edf2f7;
            padding: 20px 0;
            margin: auto;
        }

        .email-container {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);

        }

        .email-header {
            font-size: 24px;
            font-weight: bold;
            color: #4a4a4a;
            padding: 10px 0 30px 0;
        }

        .email-content {
            margin-top: 20px;
            font-size: 16px;
            line-height: 1.6;
            color: #4a4a4a;
        }

        .email-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #00ff37;
            color: #ffffff;
            text-decoration: none;
            font-size: 16px;
            border-radius: 4px;
        }

        .email-footer {
            margin-top: 20px;
            font-size: 14px;
            color: #9b9b9b;
        }

        .email-copyrit {
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
            line-height: 1.5em;
            margin-top: 0;
            color: #b0adc5;
            font-size: 12px;
            text-align: center;
            padding: 30px 0 10px 0;
        }

    </style>
</head>

<body>
    <div class="container" dir="rtl">
        <center>
            <div class="email-header">
                {{ config('app.name', 'Nasaq') }}
            </div>
        </center>
        <div class="email-container">
            <div class="email-content">
                <h3>{{ __('mails.Hello') }}</h3>
                <p>{{ __('mails.Click_the_button_below_to_verify_your_email_address.') }}</p>
                <center>
                    <a href="{{ $url ?? "" }}" class="email-button" style="color:#ffffff">
                        {{ __('mails.Verify_Email_Address') }}
                    </a>
                </center>
                <p>{{ __('mails.This_verification_link_will_expire_in_60_minutes.') }}</p>
                <p>{{ __('mails.If_you_did_not_create_an_account,_no_further_action_is_required.') }}</p>
                <p>{{ __('mails.Regards,_Team') }}</p>
            </div>
            <hr>
            <div class="email-footer">
                <p>
                    {{ __('mails.If_you’re_having_trouble_clicking_the_"Verify_Email_Address"_button,_copy_and_paste_the_URL_below_into_your_web_browser:') }}
                    <a href="{{ $url ?? "" }}">{{ $url ?? "" }}</a>
                </p>
            </div>
        </div>
        <center>
            <div class="email-copyrit">© 2024 Core. {{ __('mails.All_rights_reserved.') }}</div>
        </center>
    </div>
</body>

</html>
