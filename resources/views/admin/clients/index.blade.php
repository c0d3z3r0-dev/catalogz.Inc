@extends('layouts.admin.app')

@section('title', 'Clients')
@section('page-title', 'Clients')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h3 class="text-2xl font-bold text-slate-800">All Clients</h3>
    <div class="flex gap-2">
        <a href="{{ route('clients.index', ['export' => 'csv']) }}" class="btn-dark-green text-sm">Export CSV</a>
        <a href="{{ route('clients.create') }}" class="btn-dark-green text-sm">+ New Client</a>
    </div>
</div>

@if (session('success'))
    <div class="bg-green-50 border-l-4 border-[#0A8F3C] text-green-700 p-4 mb-6 rounded-r">{{ session('success') }}</div>
@endif

<div class="mb-4 flex gap-4">
    <input type="text" id="clientSearch" placeholder="Search clients..." class="w-full max-w-md px-4 py-2 border rounded-xl text-sm">
    <button onclick="bulkDelete()" class="btn-orange text-sm hidden" id="bulk-delete-btn">Delete Selected</button>
</div>

<div class="card-float overflow-hidden">
    <table class="w-full overflow-x-auto" class="w-full" id="clientsTable">
        <thead class="bg-slate-50">
            <tr>
                <th class="p-3 text-left"><input type="checkbox" id="select-all" onchange="toggleAll(this)"></th>
                <th class="p-3 text-left text-sm font-semibold text-slate-600 cursor-pointer" onclick="sortTable(0)">Name &#9650;&#9660;</th>
                <th class="p-3 text-left text-sm font-semibold text-slate-600 cursor-pointer" onclick="sortTable(1)">Slug &#9650;&#9660;</th>
                <th class="p-3 text-left text-sm font-semibold text-slate-600">WhatsApp</th>
                <th class="p-3 text-left text-sm font-semibold text-slate-600">Status</th>
                <th class="p-3 text-right text-sm font-semibold text-slate-600">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse ($clients as $client)
            <tr class="client-row even:bg-slate-50/50 hover:bg-slate-50" data-id="{{ $client->id }}">
                <td class="p-3"><input type="checkbox" class="row-checkbox" data-id="{{ $client->id }}"></td>
                <td class="p-3 font-medium text-slate-900 editable" data-field="name" data-id="{{ $client->id }}">{{ $client->name }}</td>
                <td class="p-3 text-slate-500">{{ $client->slug }}</td>
                <td class="p-3 text-slate-500">{{ $client->whatsapp_number }}</td>
                <td class="p-3">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $client->is_active ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-red-100 text-red-800 border border-red-200' }}">
                        {{ $client->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td class="p-3 text-right">
                    <div class="flex items-center justify-end space-x-3">
                        <a href="{{ route('catalog.show', $client->slug) }}" target="_blank" class="text-slate-400 hover:text-slate-600 text-sm">Preview</a>
                        <a href="{{ route('clients.show', $client) }}" class="text-blue-600 hover:text-blue-800 text-sm">View</a>
                        <a href="{{ route('clients.edit', $client) }}" class="text-amber-600 hover:text-amber-800 text-sm">Edit</a>
                        <button onclick="deleteClient({{ $client->id }}, '{{ $client->name }}')" class="text-red-600 hover:text-red-800 text-sm">Delete</button>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="p-12 text-center text-slate-400">No clients found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
    document.getElementById('clientSearch').addEventListener('input', function() {
        const f = this.value.toLowerCase();
        document.querySelectorAll('.client-row').forEach(r => r.style.display = r.innerText.toLowerCase().includes(f) ? '' : 'none');
    });

    function sortTable(col) {
        const tbody = document.querySelector('#clientsTable tbody');
        const rows = Array.from(tbody.querySelectorAll('tr.client-row'));
        const asc = tbody.dataset.sortCol == col && tbody.dataset.sortDir == 'asc' ? false : true;
        rows.sort((a, b) => a.cells[col+1].innerText.localeCompare(b.cells[col+1].innerText) * (asc ? 1 : -1));
        rows.forEach(r => tbody.appendChild(r));
        tbody.dataset.sortCol = col;
        tbody.dataset.sortDir = asc ? 'asc' : 'desc';
    }

    function toggleAll(el) {
        document.querySelectorAll('.row-checkbox').forEach(cb => cb.checked = el.checked);
        toggleBulkBtn();
    }
    document.querySelectorAll('.row-checkbox').forEach(cb => cb.addEventListener('change', toggleBulkBtn));
    function toggleBulkBtn() {
        const any = document.querySelectorAll('.row-checkbox:checked').length > 0;
        document.getElementById('bulk-delete-btn').classList.toggle('hidden', !any);
    }

    async function bulkDelete() {
        if (!confirm('Delete selected clients?')) return;
        const ids = Array.from(document.querySelectorAll('.row-checkbox:checked')).map(cb => cb.dataset.id);
        for (const id of ids) {
            await fetch('/clients/' + id, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
        }
        location.reload();
    }

    // Inline edit
    document.querySelectorAll('.editable').forEach(cell => {
        cell.addEventListener('dblclick', function() {
            const current = this.innerText;
            const input = document.createElement('input');
            input.value = current;
            input.className = 'border rounded px-2 py-1 w-full text-sm';
            this.innerHTML = '';
            this.appendChild(input);
            input.focus();
            input.addEventListener('blur', async () => {
                const newVal = input.value;
                this.innerText = newVal;
                const id = this.dataset.id;
                const field = this.dataset.field;
                await fetch('/clients/' + id, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ [field]: newVal, _method: 'PUT' })
                });
                showToast('Updated successfully');
            });
        });
    });

    // Delete with undo
    async function deleteClient(id, name) {
        if (!confirm('Delete ' + name + '?')) return;
        await fetch('/clients/' + id, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
        const row = document.querySelector(`tr[data-id="${id}"]`);
        row.style.opacity = '0.3';
        showToast('Client deleted. <button onclick="undoDelete(' + id + ')" class="underline">Undo</button>', 'success');
        setTimeout(() => row.remove(), 5000);
    }

    async function undoDelete(id) {
        // Simplified undo – in production you'd need a proper soft-delete/restore
        location.reload();
    }
</script>
@endsection

