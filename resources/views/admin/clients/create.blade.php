@extends('layouts.admin.app')

@section('title', 'New Client')

@section('page-title', 'New Client')

@section('content')
<div class="max-w-2xl mx-auto card-float p-6">
    <form method="POST" action="{{ route('clients.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="space-y-4">
            <h4 class="text-lg font-semibold text-slate-800 border-b pb-2">Business Details</h4>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Business Name</label>
                    <input type="text" name="name" value="{{ old('name', $prefill['name'] ?? '') }}" required
                           class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#0A8F3C] focus:border-transparent @error('name') border-red-500 @enderror">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">WhatsApp Number</label>
                    <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $prefill['whatsapp'] ?? '') }}" required
                           class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#0A8F3C] focus:border-transparent @error('whatsapp_number') border-red-500 @enderror">
                    @error('whatsapp_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Logo (optional)</label>
                <input type="file" name="logo" accept="image/*"
                       class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                @error('logo')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $prefill['email'] ?? '') }}"
                       class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#0A8F3C] focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Address (optional)</label>
                <textarea name="address" rows="2" class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#0A8F3C] focus:border-transparent">{{ old('address', $prefill['address'] ?? '') }}</textarea>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">City</label>
                    <input type="text" name="city" value="{{ old('city', $prefill['city'] ?? '') }}"
                           class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#0A8F3C] focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Contact Email (optional)</label>
                    <input type="email" name="contact_email" value="{{ old('contact_email') }}"
                           class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#0A8F3C] focus:border-transparent">
                </div>
            </div>
            <h4 class="text-lg font-semibold text-slate-800 border-b pb-2 mt-6">Catalog Styling (optional)</h4>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Background Colour</label>
                    <input type="text" name="background_color" value="{{ old('background_color') }}" placeholder="#F8FAFC"
                           class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#0A8F3C] focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Font Family</label>
                    <select name="font_family" class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#0A8F3C] focus:border-transparent">
                        <option value="">Default (Inter)</option>
                        <option value="Roboto">Roboto</option>
                        <option value="Poppins">Poppins</option>
                        <option value="Lora">Lora</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Custom CSS</label>
                <textarea name="custom_css" rows="3" class="w-full font-mono text-sm px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#0A8F3C] focus:border-transparent">{{ old('custom_css') }}</textarea>
            </div>
        </div>
        <div class="mt-6 flex items-center justify-end space-x-3">
            <a href="{{ route('clients.index') }}" class="px-4 py-2 border border-slate-300 rounded-xl text-slate-700 hover:bg-slate-50 text-sm">Cancel</a>
            <button type="submit" class="btn-dark-green">Create Client</button>
        </div>
    </form>
</div>
@endsection
