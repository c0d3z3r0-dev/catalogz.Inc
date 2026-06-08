<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Sent – Catalog.Inc</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4">
    <div class="bg-white rounded-xl shadow-sm p-8 max-w-md w-full text-center">
        <div class="mb-6">
            <h1 class="text-2xl font-bold">
                <span class="text-[#1e2a3a]">Catalog.</span><span class="text-green-500">Inc</span>
            </h1>
        </div>
        <h2 class="text-xl font-bold text-gray-800 mb-4">Application Sent!</h2>
        <p class="text-gray-600 mb-6">Your details have been submitted. Now, send us a WhatsApp message so we can start building your catalog immediately.</p>
        <a href="{{ $waLink }}" target="_blank" class="inline-block bg-green-600 text-white px-6 py-3 rounded-xl hover:bg-green-700 font-medium">
            Open WhatsApp to Send
        </a>
    </div>
</body>
</html>


