<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\AdInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdController extends Controller
{
    public function rejectInquiry($id)
    {
        $inquiry = AdInquiry::findOrFail($id);
        
        $inquiry->update([
            'status' => 'rejected'
        ]);

        return redirect()->back()->with('success', 'Nai-reject na ang ad inquiry.');
    }

    /**
     * Magpadala ng email (Form man o Mensahe) sa nag-inquire.
     */
    public function sendInquiryEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'inquiry_id' => 'nullable|exists:ad_inquiries,id',
            'action_type' => 'nullable|string',
        ]);

        // Kapag nagpadala ng Ad Form, i-update ang status ng inquiry sa 'form_sent'
        if ($request->filled('inquiry_id') && $request->action_type === 'send_form') {
            $inquiry = AdInquiry::find($request->inquiry_id);
            if ($inquiry) {
                $inquiry->update(['status' => 'form_sent']);
            }
        }

        // Pagpapadala ng Email Gamit ang Mail Facade ng Laravel
        try {
            Mail::raw($request->message, function ($mail) use ($request) {
                $mail->to($request->email)
                     ->subject($request->subject);
            });

            return redirect()->back()->with('success', 'Matagumpay na naipadala ang email!');
        } catch (\Exception $e) {
            // Kung may problema sa mailer config (.env), magbabalik ng notification
            return redirect()->back()->with('success', 'Na-update ang status ng inquiry (Pakitiyak lang ang SMTP/Mail settings sa .env para sa actual email delivery).');
        }
    }
    public function index()
    {
        $ads = Ad::latest()->get();
        return view('admin.ads.index', compact('ads'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image_url' => 'required|url',
            'button_link' => 'required|url',
            'badge_text' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'promo_code' => 'nullable|string|max:100',
            'button_text' => 'nullable|string|max:100',
            'expires_at' => 'nullable|date',
        ]);

        $data = $request->all();
        // Siguraduhing ang checkbox ng is_active ay magiging boolean (true/false o 1/0)
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        Ad::create($data);

        return redirect()->back()->with('success', 'Ad successfully created!');
    }

    // Idinagdag ang edit method para sa JSON fetch ng Modal
    public function edit(Ad $ad)
    {
        return response()->json($ad);
    }

    public function update(Request $request, Ad $ad)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image_url' => 'required|url',
            'button_link' => 'required|url',
            'badge_text' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'promo_code' => 'nullable|string|max:100',
            'button_text' => 'nullable|string|max:100',
            'expires_at' => 'nullable|date',
        ]);

        $data = $request->all();
        // Para sa update, kung naka-uncheck ang checkbox, magiging 0 ito
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        $ad->update($data);

        return redirect()->back()->with('success', 'Ad successfully updated!');
    }

    public function destroy(Ad $ad)
    {
        $ad->delete();
        return redirect()->back()->with('success', 'Ad deleted successfully!');
    }
}