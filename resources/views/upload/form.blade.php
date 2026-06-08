<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Photos – {{ $client->name }}</title>
    
</head>
<body class="bg-slate-50 p-8">
    <div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow">
        <h1 class="text-2xl font-bold mb-4">{{ $client->name }} – Upload Product Photos</h1>
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif
        <form method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="key" value="{{ request('key') }}">
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-2">Select Photos</label>
                <input type="file" name="photos[]" multiple accept="image/*" class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
            </div>
            <button type="submit" class="bg-green-600 text-white px-5 py-2 rounded-xl hover:bg-green-700">Upload</button>
        </form>
    </div>
</body>
</html>




