<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalog Directory – Catalog.Inc</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #efeae2;
            background-image: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23d4cdc2' fill-opacity='0.6'%3E%3Ccircle cx='20' cy='20' r='2'/%3E%3Ccircle cx='60' cy='60' r='2'/%3E%3Ccircle cx='40' cy='10' r='1.5'/%3E%3Ccircle cx='10' cy='50' r='1.5'/%3E%3Ccircle cx='70' cy='30' r='1.5'/%3E%3Ccircle cx='30' cy='70' r='1'/%3E%3Ccircle cx='50' cy='40' r='1'/%3E%3Ccircle cx='15' cy='35' r='1'/%3E%3Ccircle cx='65' cy='15' r='1'/%3E%3Ccircle cx='45' cy='55' r='1'/%3E%3C/g%3E%3C/svg%3E");
            background-size: 80px 80px;
            margin: 0;
            color: #1e293b;
        }
        .btn-primary {
            background-color: #0A8F3C;
            color: white;
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-primary:hover { background-color: #047A2D; transform: translateY(-1px); }
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
            text-decoration: none;
        }
        .category-pill.active {
            background: #0A8F3C;
            color: white;
            border-color: #0A8F3C;
        }
        .category-pill:hover { background: #f0fdf4; }
        .category-pill.active:hover { background: #047A2D; }
        .search-input {
            padding: 12px 20px;
            border-radius: 12px;
            border: 1px solid #d1d5db;
            width: 100%;
            max-width: 500px;
            font-size: 1rem;
            outline: none;
            transition: border-color 0.2s;
        }
        .search-input:focus { border-color: #0A8F3C; }
    </style>
</head>
<body class="antialiased">

    <!-- Nav -->
    <nav class="bg-[#1e2a3a] shadow-md sticky top-0 z-30">
        <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
            <span class="text-2xl font-bold tracking-tight">
                <span class="text-white">Catalog.</span><span class="text-green-400">Inc</span>
            </span>
            <a href="/" class="text-sm text-gray-300 hover:text-white font-medium">Home</a>
        </div>
    </nav>

    <!-- Hero -->
    <section class="max-w-4xl mx-auto px-6 py-16 md:py-24 text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Discover local businesses</h1>
        <p class="text-gray-600 text-lg mb-8">Browse product catalogs from shops near you. Pay with EcoCash.</p>
        <form method="GET" action="/catalogs" class="flex justify-center">
            <input type="text" name="search" placeholder="Search by business name..." 
                   class="search-input" value="{{ request('search') }}">
            <button type="submit" class="btn-primary ml-2">Search</button>
        </form>
    </section>

    <!-- Category Filter -->
    <div class="max-w-5xl mx-auto px-6 mb-8">
        <div class="flex flex-wrap justify-center gap-3">
            <a href="/catalogs" class="category-pill {{ !request('category') ? 'active' : '' }}">All</a>
            @foreach ($categories as $cat)
                <a href="/catalogs?category={{ urlencode($cat) }}" class="category-pill {{ request('category') == $cat ? 'active' : '' }}">{{ $cat }}</a>
            @endforeach
        </div>
    </div>

    <!-- Featured Catalogs (top 3 by product count) -->
    @if (isset($featured) && $featured->isNotEmpty())
    <section class="max-w-6xl mx-auto px-6 pb-10">
        <h2 class="text-2xl font-bold mb-6">Featured Catalogs</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($featured as $client)
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
                <p class="text-sm text-gray-500 mb-4 flex-1">{{ $client->products_count }} products</p>
                <a href="/{{ $client->slug }}" class="btn-primary text-center text-sm">Visit Catalog</a>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- All Catalogs -->
    <div class="max-w-6xl mx-auto px-6 pb-16">
        <h2 class="text-2xl font-bold mb-6">All Catalogs</h2>
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
                <a href="/{{ $client->slug }}" class="btn-primary text-center text-sm">Visit Catalog</a>
            </div>
            @empty
            <div class="col-span-full text-center text-gray-500 py-12">No catalogs found.</div>
            @endforelse
        </div>
        <div class="mt-8">
            {{ $clients->links() }}
        </div>
    </div>

    <footer class="text-center py-8 text-gray-400 text-sm border-t">
        &copy; {{ date('Y') }} Catalog.Inc. All rights reserved.
        <a href="/" class="text-green-600 hover:underline ml-2">Home</a>
    </footer>

</body>
</html>
