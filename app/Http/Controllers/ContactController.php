<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

final class ContactController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $recipient = config('home.contact.recipient');

        abort_unless(filled($recipient) && !in_array(config('mail.default'), ['log', 'array'], true), 503);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:30', 'regex:/^[+0-9\s()\-]+$/'],
            'subject' => ['required', 'in:consultation,pricing,services'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $subjects = [
            'consultation' => 'مشاوره و راه‌اندازی',
            'pricing' => 'تعرفه‌ها',
            'services' => 'خدمات',
        ];

        $body = implode("\n", [
            'نام: '.$data['name'],
            'تلفن: '.$data['phone'],
            'موضوع: '.$subjects[$data['subject']],
            '',
            'پیام:',
            $data['message'],
        ]);

        Mail::raw($body, static function ($message) use ($recipient): void {
            $message->to($recipient)->subject('درخواست جدید از وب‌سایت بیلدینو');
        });

        return redirect(route('home').'#contact')->with('contact_success', 'درخواست شما ثبت شد. به‌زودی با شما تماس می‌گیریم.');
    }
}
