<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <title>{{ __('mails.Membership_Request_Status') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Responsive styles for email clients */
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

            .site-name {
                font-size: 22px !important;
            }

            .status-badge {
                font-size: 15px !important;
                padding: 10px 18px !important;
            }

            .cta-btn {
                font-size: 15px !important;
                padding: 12px 24px !important;
            }
        }
    </style>
</head>

<body
    style="margin:0; padding:0; background-color:#f4f6fb; font-family: 'Segoe UI', Arial, sans-serif; direction: {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0"
        style="background-color:#f4f6fb; min-height:100vh;">
        <tr>
            <td align="center">
                <table class="container" role="presentation" width="600" cellspacing="0" cellpadding="0"
                    style="background-color:#fff; border-radius:16px; box-shadow:0 4px 24px rgba(0,0,0,0.08); overflow:hidden; margin:40px auto; width:600px; max-width:95%;">

                    <!-- Header: Logo & Site Name -->
                    <tr>
                        <td align="center"
                            style="padding: 32px 20px 12px 20px; background: linear-gradient(90deg,#e3eafc 0%,#f8f9fb 100%);">
                            <img class="logo" src="{{ $community_logo }}" alt="{{ __('mails.Community_Logo') }}"
                                style="max-width:120px; height:auto; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.07); margin-bottom:10px;">
                            <div class="site-name"
                                style="font-size:26px; font-weight:700; color:#2d3a4a; letter-spacing:1px; margin-top:8px;">
                                {{ config('app.name') }}</div>
                        </td>
                    </tr>

                    <!-- Main Content -->
                    <tr>
                        <td class="main-content" style="padding: 28px 32px 18px 32px;">
                            <!-- Greeting -->
                            <div
                                style="font-size:18px; color:#2d3a4a; font-weight:500; margin-bottom:18px; line-height:1.5;">
                                {{ __('mails.Hello') }} <span style="font-weight:700;">{{ $user->name }}</span>,
                            </div>

                            <!-- Status Badge -->
                            <div align="center" style="margin-bottom:22px;">
                                @php
                                    $statusLabel = app()->getLocale() === 'ar' ? $status->getLabelArabic() : $status->getLabel();
                                    $badgeColors = $status->getBadgeColors();
                                    $badgeBg = $badgeColors['background'];
                                    $badgeColor = $badgeColors['color'];
                                @endphp
                                <span class="status-badge"
                                    style="display:inline-block; padding:14px 28px; border-radius:32px; font-weight:700; font-size:17px; background:{{ $badgeBg }}; color:{{ $badgeColor }}; box-shadow:0 2px 8px rgba(0,0,0,0.07); letter-spacing:0.5px;">
                                    {{ $statusLabel }}
                                </span>
                            </div>

                            <!-- Status Message -->
                            <div
                                style="font-size:16px; color:#444; line-height:1.7; margin-bottom:18px; background-color:#f8f9fb; border-radius:10px; padding:16px 18px;">
                                {{ app()->getLocale() === 'ar' ? $status->getStatusMessageArabic() : $status->getStatusMessage() }}
                            </div>

                            <!-- Admin Notes -->
                            @if (!empty($admin_notes))
                                <div
                                    style="font-size:15px; color:#2d3a4a; background:#f3f7fa; border-radius:8px; padding:12px 16px; margin-bottom:18px; border-left:4px solid #a3bffa;">
                                    <strong>{{ __('mails.Admin_Notes') }}:</strong>
                                    <span style="color:#444;">{{ $admin_notes }}</span>
                                </div>
                            @endif

                            <!-- Submission Date -->
                            <div style="font-size:13px; color:#888; margin-bottom:24px;">
                                {{ __('mails.Submission_Date') }}: <span
                                    style="color:#2d3a4a;">{{ $submitted_at->format('Y-m-d H:i') }}</span>
                            </div>

                            <!-- Call to Action Button -->
                            <div align="center" style="margin-bottom:24px;">
                                <a href="{{ url('/') }}" class="cta-btn"
                                    style="display:inline-block; background:#5f662d; color:#fff !important; font-size:16px; font-weight:600; padding:14px 32px; border-radius:28px; text-decoration:none; box-shadow:0 2px 8px rgba(59,130,246,0.12); transition:background 0.2s;">
                                    {{ __('mails.Visit_Community') }}
                                </a>
                            </div>

                            <!-- Thank You Message -->
                            <div
                                style="font-size:14px; color:#7a869a; text-align:center; margin-top:18px; line-height:1.6;">
                                {{ __('mails.Thank_you_for_submitting_your_request!_We_are_happy_to_have_you_interested_or_joining_the_community.') }}
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center"
                            style="padding:18px 10px; background-color:#f4f6fb; color:#b0b8c1; font-size:12px; border-top:1px solid #e3eafc;">
                            &copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('mails.All_rights_reserved') }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
