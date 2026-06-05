<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class SubmissionController extends Controller
{
    // ---------- Public ----------
    public function create()
    {
        return view('submissions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'whatsapp_number' => 'required|string|max:20',
            'email' => 'nullable|email',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'contact_email' => 'nullable|email',
            'products' => 'array|max:10',
            'products.*.photo' => 'nullable|image|max:2048',
            'products.*.name' => 'nullable|string|max:255',
            'products.*.price' => 'nullable|string|max:50',
        ]);

        $submission = Submission::create($validated);

        if ($request->has('products')) {
            foreach ($request->products as $productData) {
                $path = null;
                if (isset($productData['photo']) && $productData['photo'] instanceof \Illuminate\Http\UploadedFile) {
                    $path = $productData['photo']->store('submissions/'.$submission->id, 'public');
                }
                if (!empty($productData['name']) || !empty($productData['price']) || $path) {
                    $submission->products()->create([
                        'image_path' => $path,
                        'product_name' => $productData['name'] ?? null,
                        'product_price' => $productData['price'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('submission.thanks', ['submission' => $submission->id]);
    }

    public function thanks(Submission $submission)
    {
        $adminWhatsApp = config('services.admin_whatsapp', '0715670833');
        $message = "New catalog application from {$submission->business_name}.\nWhatsApp: {$submission->whatsapp_number}\n";
        $message .= "View details: ". route('admin.submissions.show', $submission);
        $waLink = "https://wa.me/{$adminWhatsApp}?text=" . urlencode($message);
        return view('submissions.thanks', compact('submission', 'waLink', 'message'));
    }

    // ---------- Admin ----------
    public function index()
    {
        $submissions = Submission::withCount('products')->latest()->paginate(20);

        // Mark all unviewed submissions as viewed
        Submission::whereNull('viewed_at')->update(['viewed_at' => Carbon::now()]);

        return view('admin.submissions.index', compact('submissions'));
    }

    public function show(Submission $submission)
    {
        // Mark this submission as viewed if not already
        if (!$submission->viewed_at) {
            $submission->update(['viewed_at' => Carbon::now()]);
        }

        $submission->load('products');
        return view('admin.submissions.show', compact('submission'));
    }
}
