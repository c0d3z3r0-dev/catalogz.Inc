@extends('layouts.admin.app')

@section('title', 'API Config – ' . $client->name)

@section('page-title', 'API Configuration for ' . $client->name)

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow-card border border-slate-200">
    <h3 class="text-lg font-semibold mb-4">API Access</h3>

    @if (session('plain_token'))
        <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-4 rounded-xl mb-4">
            <p class="font-medium">New API Token (copy it now, it won't be shown again):</p>
            <code class="text-sm break-all">{{ session('plain_token') }}</code>
        </div>
    @endif

    <div class="mb-6">
        <p class="text-sm text-slate-600 mb-2">API token status:</p>
        @if ($client->api_token)
            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Active</span>
        @else
            <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Not set</span>
        @endif
    </div>

    <form method="POST" action="{{ route('clients.generate-token', $client) }}" class="mb-6">
        @csrf
        <button type="submit" class="px-4 py-2 bg-[var(--green-primary)] text-white rounded-xl hover:bg-[var(--green-hover)] text-sm">
            {{ $client->api_token ? 'Regenerate Token' : 'Generate Token' }}
        </button>
    </form>

    <h4 class="font-semibold mb-2">React App Configuration</h4>
    <p class="text-sm text-slate-500 mb-2">Use this JSON structure to configure your React catalog app:</p>
    <pre class="bg-slate-900 text-green-400 p-4 rounded-xl text-sm overflow-x-auto">
{
  "apiBaseUrl": "{{ url('/api/v1') }}",
  "clientSlug": "{{ $client->slug }}",
  "clientApiToken": "{{ $client->api_token ?? 'YOUR_TOKEN' }}"
}
    </pre>
    <p class="text-xs text-slate-400 mt-2">Include the API token in the <code>Authorization: Bearer YOUR_TOKEN</code> header for requests.</p>
</div>
@endsection

