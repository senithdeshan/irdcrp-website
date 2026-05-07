<?php

namespace App\Http\Controllers;

use App\Models\GrmComplaint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GrmComplaintController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:5000',
        ]);

        GrmComplaint::create($data + [
            'status' => 'new',
        ]);

        return redirect()
            ->to('/grm')
            ->with('success', 'Your GRM complaint was submitted successfully. We will respond soon.');
    }
}

