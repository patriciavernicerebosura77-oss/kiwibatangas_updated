<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use Illuminate\Http\Request;

class AdController extends Controller
{
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