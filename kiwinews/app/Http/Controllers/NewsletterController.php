<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use App\Mail\WelcomeNewsletterMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        // 1. I-validate na tamang email address ang inilagay
        $request->validate([
            'email' => 'required|email',
        ]);

        // 2. I-save sa database kung bago, o kunin ang umiiral na record
        $subscriber = NewsletterSubscriber::firstOrCreate([
            'email' => $request->email,
        ]);

        // 3. Magpadala ng Thank You Email
        Mail::to($request->email)->send(new WelcomeNewsletterMail());

        // 4. I-redirect pabalik sa home kasama ang success message
        return redirect()->route('home')->with('success', 'Salamat sa pag-subscribe sa Kiwi Batangas!');
    }
}