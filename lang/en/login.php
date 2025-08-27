<?php
// resources/lang/en/register.php

return [
    // Main section texts
    'title'         => 'Login',
    'subtitle'      => 'Welcome back! Please log in to continue.',
    'create_button' => 'Login',
    'register_prompt'  => 'Don’t have an account?',
    'forgit_password' => 'Forgot your password?',
    'register_link'    => 'Create a new account here',

    // Forgot password texts
    'forgot_password_title' => 'Forgot Password?',
    'forgot_password_subtitle' => 'Don’t worry. Enter your email and we’ll send you a reset link.',
    'send_reset_link_button' => 'Send Reset Link',
    'back_to_login_link' => 'Back to Login',

    // Success message texts
    'link_sent_title' => 'Link Sent!',
    'link_sent_subtitle' => 'Please check your inbox (and spam folder) to continue.',

    // Form fields
    'email' => 'Email',
    'email_placeholder' => 'email@example.com',
    'password' => 'Password',
    'password_placeholder' => '********',
    // ...
    // Reset password texts
    'reset_password_title'     => 'Reset Password',
    'reset_password_subtitle'  => 'Enter a new password for your account.',

    'new_password'             => 'New Password',
    'new_password_placeholder' => '********',

    'confirm_new_password'     => 'Confirm New Password',
    'update_password_button'   => 'Update Password',

    // --- Two-Factor Authentication (2FA) Texts ---
    '2fa_title' => 'Verify Your Identity',
    '2fa_subtitle' => 'To protect your account, please complete the following verification step.',
    '2fa_app_code_label' => 'Authenticator App Code',
    '2fa_recovery_code_label' => 'Recovery Key',
    '2fa_code_placeholder' => '· · · · · ·', // Using dots for a secure feel
    '2fa_recovery_code_placeholder' => 'Enter a recovery key',
    '2fa_verify_button' => 'Verify & Continue',
    '2fa_use_recovery_code' => 'Use a recovery key instead',
    '2fa_use_app_code' => 'Use an authenticator app',
];
