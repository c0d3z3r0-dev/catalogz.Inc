<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('export') && $request->export === 'csv') {
            $clients = Client::all();
            $csv = "Name,Slug,WhatsApp,Email,City,Status\n";
            foreach ($clients as $c) {
                $csv .= "{$c->name},{$c->slug},{$c->whatsapp_number},{$c->email},{$c->city}," . ($c->is_active ? 'Active' : 'Inactive') . "\n";
            }
            return response($csv, 200, ['Content-Type' => 'text/csv', 'Content-Disposition' => 'attachment; filename="clients.csv"']);
        }
        $clients = Client::orderBy('name')->get();
        return view('admin.clients.index', compact('clients'));
    }

    public function create(Request $request)
    {
        $prefill = $request->only(['name', 'whatsapp', 'email', 'address', 'city']);
        return view('admin.clients.create', compact('prefill'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp_number' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'contact_email' => 'nullable|email|max:255',
            'background_color' => 'nullable|string|max:50',
            'font_family' => 'nullable|string|max:100',
            'custom_css' => 'nullable|string',
            'primary_color' => 'nullable|string|max:7',
            'logo' => 'nullable|image|max:2048',
        ]);

        $validated['background_color'] = $validated['background_color'] ?? '#FFFFFF';
        $validated['font_family'] = $validated['font_family'] ?? 'Inter';
        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = true;

        if ($request->hasFile('logo')) {
            $validated['logo_path'] = $request->file('logo')->store('logos', 'public');
        }

        $client = Client::create($validated);
        $client->generateMerchantToken();

        $catalogUrl = route('catalog.show', $client->slug);
        $waMessage = urlencode("Your catalog is live! 🎉\nVisit: {$catalogUrl}\nShare this link with your customers.");
        $waLink = "https://wa.me/{$client->whatsapp_number}?text={$waMessage}";

        return redirect()->route('clients.index')->with('success', "Client created. <a href='{$waLink}' target='_blank' class='underline'>Send WhatsApp welcome</a>");
    }

    public function show(Client $client) { $products = $client->products()->orderBy('sort_order')->get(); return view('admin.clients.show', compact('client', 'products')); }
    public function edit(Client $client) { return view('admin.clients.edit', compact('client')); }

    public function update(Request $request, Client $client)
    {
        if ($request->wantsJson() || $request->ajax()) {
            $client->update($request->only(['name', 'whatsapp_number', 'email', 'address', 'city', 'is_active']));
            return response()->json(['success' => true]);
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255', 'whatsapp_number' => 'required|string|max:20',
            'email' => 'nullable|email|max:255', 'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100', 'contact_email' => 'nullable|email|max:255',
            'background_color' => 'nullable|string|max:50', 'font_family' => 'nullable|string|max:100',
            'custom_css' => 'nullable|string', 'primary_color' => 'nullable|string|max:7',
            'is_active' => 'boolean', 'logo' => 'nullable|image|max:2048',
        ]);
        $validated['slug'] = Str::slug($validated['name']);
        if ($request->hasFile('logo')) {
            if ($client->logo_path) Storage::disk('public')->delete($client->logo_path);
            $validated['logo_path'] = $request->file('logo')->store('logos', 'public');
        }
        $client->update($validated);
        return redirect()->route('clients.index')->with('success', 'Client updated.');
    }

    public function destroy(Client $client) { $client->delete(); return redirect()->route('clients.index')->with('success', 'Client deleted.'); }
    public function apiConfig(Client $client) { return view('admin.clients.api-config', compact('client')); }
    public function generateToken(Client $client) { $t = $client->generateApiToken(); return back()->with('plain_token', $t); }
}
