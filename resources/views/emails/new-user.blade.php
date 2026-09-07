<!DOCTYPE html>
<html lang="{{ app()->getLocale() === 'bn' ? 'bn' : 'en' }}">
<head>
<meta charset="UTF-8">
<title>{{ __('mail.new_user_subject') }}</title>
</head>
<body style="margin:0;padding:24px;background:#f3f5f4;font-family:'Hind Siliguri',Arial,sans-serif;">
<div style="max-width:560px;margin:0 auto;background:#fff;border-radius:12px;overflow:hidden;border:1px solid #e5e7eb;">
    <div style="background:#14532d;padding:20px 28px;">
        <h1 style="margin:0;color:#fff;font-size:20px;">{{ __('messages.app_name') }}</h1>
    </div>
    <div style="padding:28px;">
        <p style="font-size:16px;color:#111827;">{{ __('mail.hello', ['name' => $user->name]) }}</p>
        <p style="font-size:14px;color:#374151;">{{ __('mail.new_user_intro') }}</p>

        <table style="width:100%;border-collapse:collapse;margin:20px 0;font-size:14px;">
            <tr>
                <td style="padding:10px 14px;background:#f9fafb;color:#6b7280;width:40%;">{{ __('mail.email') }}</td>
                <td style="padding:10px 14px;background:#f9fafb;color:#111827;font-weight:600;">{{ $user->email }}</td>
            </tr>
            <tr>
                <td style="padding:10px 14px;background:#f9fafb;color:#6b7280;">{{ __('mail.temporary_password') }}</td>
                <td style="padding:10px 14px;background:#f9fafb;color:#111827;font-weight:600;">{{ $password }}</td>
            </tr>
        </table>

        <p style="font-size:14px;color:#374151;">{{ __('mail.new_user_login_hint') }}</p>
        <p style="text-align:center;margin:24px 0;">
            <a href="{{ config('app.url') }}/login" style="background:#16a34a;color:#fff;text-decoration:none;padding:12px 28px;border-radius:8px;font-size:14px;font-weight:600;display:inline-block;">{{ __('mail.login_button') }}</a>
        </p>

        <p style="font-size:12px;color:#9ca3af;">{{ __('mail.new_user_secure_hint') }}</p>
    </div>
</div>
</body>
</html>