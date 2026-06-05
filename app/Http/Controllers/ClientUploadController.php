<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientUploadController extends Controller
{
    public function show($slug, Request $request)
    {
        $client = Client::where('slug', $slug)->firstOrFail();
        // Simple shared key – set in .env or hardcoded for now
        $accessKey = env('UPLOAD_ACCESS_KEY', 'catalog2025');
        if ($request->input('key') !== $accessKey) {
            abort(403, 'Unauthorized');
        }
        return view('upload.form', compact('client'));
    }

    public function store(Request $request, $slug)
    {
        $client = Client::where('slug', $slug)->firstOrFail();
        $accessKey = env('UPLOAD_ACCESS_KEY', 'catalog2025');
        if ($request->input('key') !== $accessKey) {
            abort(403);
        }

        $request->validate([
            'photos.*' => 'image|max:2048',
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $photo->store('uploads/' . $client->id, 'public');
            }
        }

        return back()->with('success', 'Photos uploaded! We will add them to your catalog soon.');
    }
}
