<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalog Directory – Catalog.Inc</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #efeae2;
            background-image: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23d4cdc2' fill-opacity='0.6'%3E%3Ccircle cx='20' cy='20' r='2'/%3E%3Ccircle cx='60' cy='60' r='2'/%3E%3Ccircle cx='40' cy='10' r='1.5'/%3E%3Ccircle cx='10' cy='50' r='1.5'/%3E%3Ccircle cx='70' cy='30' r='1.5'/%3E%3Ccircle cx='30' cy='70' r='1'/%3E%3Ccircle cx='50' cy='40' r='1'/%3E%3Ccircle cx='15' cy='35' r='1'/%3E%3Ccircle cx='65' cy='15' r='1'/%3E%3Ccircle cx='45' cy='55' r='1'/%3E%3C/g%3E%3C/svg%3E");
            background-size: 80px 80px;
            margin: 0;
            color: #1e293b;
        }
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            transition: transform 0.2s, box-shadow 0.2s;
            overflow: hidden;
        }
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.10);
        }
        .btn {
            background-color: #0A8F3C;
            color: white;
            border-radius: 12px;
            padding: 8px 16px;
            font-weight: 500;
            transition: all 0.2s;
            display: inline-block;
            text-decoration: none;
        }
        .btn:hover { background-color: #047A2D; }
        .category-pill {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            border: 1px solid #d1d5db;
            background: white;
            color: #374151;
        }
        .category-pill.active {
            background: #0A8F3C;
            color: white;
            border-color: #0A8F3C;
        }
    </style>
</head>
<body class="antialiased">

    <nav class="bg-[#1e2a3a] shadow-md sticky top-0 z-30">
        <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
            <span class="text-2xl font-bold tracking-tight">
                <span class="text-white">Catalog.</span><span class="text-green-400">Inc</span>
            </span>
            <a href="/" class="text-sm text-gray-300 hover:text-white font-medium">Home</a>
        </div>
    </nav>

    <section class="max-w-5xl mx-auto px-6 py-16 text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Catalog Directory</h1>
        <p class="text-gray-600 text-lg">Browse all businesses using Catalog.Inc</p>
    </section>

    <div class="max-w-5xl mx-auto px-6 mb-8">
        <div class="flex flex-wrap justify-center gap-3">
            <a href="/catalogs" class="category-pill {{ !request('category') ? 'active' : '' }}">All</a>
            @foreach ($categories as $cat)
                <a href="/catalogs?category={{ urlencode($cat) }}" class="category-pill {{ request('category') == $cat ? 'active' : '' }}">{{ $cat }}</a>
            @endforeach
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-6 pb-16">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($clients as $client)
            <div class="card p-6 flex flex-col">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold text-xl">
                        {{ substr($client->name, 0, 1) }}
                    </div>
                    <div>
                        <h3 class="font-semibold text-lg">{{ $client->name }}</h3>
                        @if ($client->category)
                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full">{{ $client->category }}</span>
                        @endif
                    </div>
                </div>
                @if ($client->address)
                    <p class="text-sm text-gray-500 mb-4 flex-1">{{ $client->address }}{{ $client->city ? ', '.$client->city : '' }}</p>
                @endif
                <a href="/{{ $client->slug }}" class="btn text-center text-sm mt-2">Visit Catalog</a>
            </div>
            @empty
            <div class="col-span-full text-center text-gray-500 py-12">No catalogs found in this category.</div>
            @endforelse
        </div>
        <div class="mt-8">
            {{ $clients->links() }}
        </div>
    </div>

    <footer class="text-center py-8 text-gray-400 text-sm border-t">
        &copy; {{ date('Y') }} Catalog.Inc. All rights reserved.
    </footer>
</body>
</html>
