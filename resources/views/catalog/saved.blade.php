<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saved Items - {{ $client->name }}</title>
    <link rel="stylesheet" href="/css/tailwind.min.css">
</head>
<body class="bg-slate-50">
    <header class="bg-white shadow-sm p-4 flex items-center">
        <a href="{{ route('catalog.show', $client->slug) }}" class="text-blue-600 hover:underline">&larr; Back to store</a>
        <h1 class="text-xl font-bold ml-4">Saved Items</h1>
    </header>
    <main class="p-4 max-w-3xl mx-auto">
        <div id="saved-list" class="grid grid-cols-1 gap-4"></div>
        <p id="empty-message" class="text-center text-slate-500 py-10 hidden">No saved items yet.</p>
    </main>
    <script>
        const saved = JSON.parse(localStorage.getItem('savedItems') || '[]');
        const list = document.getElementById('saved-list');
        const empty = document.getElementById('empty-message');
        if (saved.length === 0) {
            empty.classList.remove('hidden');
        } else {
            saved.forEach(item => {
                const div = document.createElement('div');
                div.className = 'bg-white p-4 rounded shadow flex items-center gap-4';
                div.innerHTML = `
                    <div class="w-20 h-20 bg-slate-200 rounded flex-shrink-0">
                        ${item.image ? `<img src="${item.image}" class="h-full w-full object-cover rounded max-w-full">` : '<div class="h-full w-full flex items-center justify-center text-slate-400">No img</div>'}
                    </div>
                    <div class="flex-1">
                        <h3 class="font-semibold">${item.name}</h3>
                        <p class="text-green-700 font-bold">$${item.price.toFixed(2)}</p>
                        <form method="POST" action="{{ route('catalog.cart.add', $client->slug) }}" class="mt-2 inline">
                            @csrf
                            <input type="hidden" name="product_id" value="${item.id}">
                            <input type="hidden" name="quantity" value="1">
                            <button class="text-sm bg-green-600 text-white px-3 py-1 rounded">Move to Basket</button>
                        </form>
                        <button onclick="removeSaved(${item.id})" class="text-sm text-red-600 ml-2">Remove</button>
                    </div>`;
                list.appendChild(div);
            });
        }
        function removeSaved(id) {
            let saved = JSON.parse(localStorage.getItem('savedItems') || '[]');
            saved = saved.filter(i => i.id !== id);
            localStorage.setItem('savedItems', JSON.stringify(saved));
            location.reload();
        }
    </script>
</body>
</html>


