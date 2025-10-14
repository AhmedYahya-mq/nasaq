<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function __invoke(Request $request)
    {
        // التحقق من صحة البيانات
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|phone:AUTO|max:20',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $data = $request->only('full_name', 'phone', 'email', 'subject', 'message');
        // تحقق من تمكين الإشعارات
        if (!config('app.enable_email_notifications')) {
            return response()->json(['message' => 'تم استقبال الرسالة، لكن الإشعارات مغلقة.']);
        }

        // إرسال البريد إلى الإيميل الموجود في .env
        Mail::to(env('CONTACT_EMAIL'))->send(new ContactFormMail($data));

        return response()->json(['message' => 'تم إرسال رسالتك بنجاح! سنتواصل معك قريبًا.']);
    }
}
