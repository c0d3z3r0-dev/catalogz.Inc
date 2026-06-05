@extends('layouts.admin.app')

@section('title', 'Submissions')

@section('page-title', 'Client Applications')

@section('content')
<div class="card-float p-4 overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="p-3 text-left text-sm font-semibold text-gray-600">Business</th>
                <th class="p-3 text-left text-sm font-semibold text-gray-600">WhatsApp</th>
                <th class="p-3 text-left text-sm font-semibold text-gray-600">Products</th>
                <th class="p-3 text-left text-sm font-semibold text-gray-600">Date</th>
                <th class="p-3 text-right text-sm font-semibold text-gray-600">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach ($submissions as $submission)
            <tr>
                <td class="p-3">{{ $submission->business_name }}</td>
                <td class="p-3">{{ $submission->whatsapp_number }}</td>
                <td class="p-3">{{ $submission->products_count }}</td>
                <td class="p-3 text-sm text-gray-500">{{ $submission->created_at->format('d M Y') }}</td>
                <td class="p-3 text-right space-x-2">
                    <a href="{{ route('admin.submissions.show', $submission) }}" class="text-blue-600 hover:underline text-sm">View</a>
                    <a href="{{ route('clients.create', ['name' => $submission->business_name, 'whatsapp' => $submission->whatsapp_number, 'email' => $submission->email, 'address' => $submission->address, 'city' => $submission->city]) }}" class="btn-dark-green text-xs px-3 py-1 inline-block">Create Catalog</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">
    {{ $submissions->links() }}
</div>
@endsection
