<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    
    
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') – Catalog.Inc</title>
    <link rel="manifest" href="/manifest.json">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .card-float {
            background: white; border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card-float:hover { transform: translateY(-3px); box-shadow: 0 8px 30px rgba(0,0,0,0.10); }
        .btn-dark-green {
            background-color: #0A8F3C; color: white; border-radius: 12px;
            padding: 8px 16px; font-weight: 500; transition: all 0.2s ease;
            display: inline-flex; align-items: center; justify-content: center;
        }
        .btn-dark-green:hover { background-color: #047A2D; transform: translateY(-1px); }
        .btn-orange {
            background-color: #F57C00; color: white; border-radius: 12px;
            padding: 8px 16px; font-weight: 500; transition: all 0.2s ease;
        }
        .btn-orange:hover { background-color: #E06B00; transform: translateY(-1px); }
        .notification-dot {
            width: 8px; height: 8px; background-color: #10b981; border-radius: 50%;
            display: inline-block; margin-left: 6px; animation: pulse-dot 2s infinite;
        }
        .notification-badge {
            background: #ef4444; color: white; font-size: 0.65rem; border-radius: 10px;
            padding: 1px 6px; margin-left: 6px; font-weight: 600;
        }
        @keyframes pulse-dot { 0%,100%{opacity:1} 50%{opacity:0.4} }
        .admin-bg {
            background-color: #efeae2;
            background-image: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23d4cdc2' fill-opacity='0.6'%3E%3Ccircle cx='20' cy='20' r='2'/%3E%3Ccircle cx='60' cy='60' r='2'/%3E%3Ccircle cx='40' cy='10' r='1.5'/%3E%3Ccircle cx='10' cy='50' r='1.5'/%3E%3Ccircle cx='70' cy='30' r='1.5'/%3E%3Ccircle cx='30' cy='70' r='1'/%3E%3Ccircle cx='50' cy='40' r='1'/%3E%3Ccircle cx='15' cy='35' r='1'/%3E%3Ccircle cx='65' cy='15' r='1'/%3E%3Ccircle cx='45' cy='55' r='1'/%3E%3C/g%3E%3C/svg%3E");
            background-size: 80px 80px;
        }
        .main-content { animation: fadeIn 0.3s ease; }
        @keyframes fadeIn { from{opacity:0;transform:translateY(8px)} to{opacity:1;transform:translateY(0)} }
        .sidebar-collapsed #sidebar { width: 64px; }
        .sidebar-collapsed #sidebar .nav-text { display: none; }
        .sidebar-collapsed #sidebar .brand-text { display: none; }
        .sidebar-collapsed #sidebar { padding-left: 4px; padding-right: 4px; }
        #sidebar { transition: width 0.3s ease; }
        .toast-container { position: fixed; top: 16px; right: 16px; z-index: 999; display: flex; flex-direction: column; gap: 8px; }
        .toast {
            background: white; border-radius: 12px; padding: 12px 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15); font-size: 0.9rem;
            display: flex; align-items: center; gap: 8px;
            animation: slideIn 0.3s ease;
        }
        .toast.removing { animation: slideOut 0.3s ease forwards; }
        @keyframes slideIn { from{opacity:0;transform:translateX(100px)} to{opacity:1;transform:translateX(0)} }
        @keyframes slideOut { from{opacity:1;transform:translateX(0)} to{opacity:0;transform:translateX(100px)} }
        .sticky-header { position: sticky; top: 0; z-index: 10; transition: box-shadow 0.3s; }
        .sticky-header.shadowed { box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
    .shadow-card { box-shadow: 0 4px 20px rgba(0,0,0,0.06); } .shadow-card:hover { box-shadow: 0 8px 30px rgba(0,0,0,0.10); }
input:focus, select:focus, textarea:focus, button:focus { outline: none; ring: 2px solid #0A8F3C; border-color: transparent; }
</style>
</head>
<body class="flex h-screen overflow-hidden" id="admin-body">
    <aside id="sidebar" class="w-48 lg:w-60 bg-[#1e2a3a] text-gray-300 flex flex-col flex-shrink-0 h-screen">
        <div class="p-5 border-b border-gray-700 flex items-center justify-between">
            <span class="text-lg lg:text-xl font-bold brand-text">
                <span class="text-white">Catalog.</span><span class="text-green-500">Inc</span>
            </span>
            <button onclick="toggleSidebar()" class="text-gray-400 hover:text-white p-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('dashboard')?'bg-[#0A8F3C] text-white':'hover:bg-gray-700 hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1h-4z"/></svg>
                <span class="nav-text">Dashboard</span>
            </a>
            <a href="{{ route('clients.index') }}" class="flex items-center gap-2 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('clients.*')?'bg-[#0A8F3C] text-white':'hover:bg-gray-700 hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                <span class="nav-text">Clients</span>
            </a>
            <a href="{{ route('orders.index') }}" class="flex items-center gap-2 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('orders.*')?'bg-[#0A8F3C] text-white':'hover:bg-gray-700 hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                <span class="nav-text">Orders</span>
            </a>
            @php $unviewed = \App\Models\Submission::whereNull('viewed_at')->count(); @endphp
            <a href="{{ route('admin.submissions.index') }}" class="flex items-center gap-2 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('admin.submissions.*')?'bg-[#0A8F3C] text-white':'hover:bg-gray-700 hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span class="nav-text">Submissions</span>
                @if($unviewed > 0) <span class="notification-badge">{{ $unviewed }}</span> @endif
            </a>
            <a href="{{ route('documentation.index') }}" class="flex items-center gap-2 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('documentation.*')?'bg-[#0A8F3C] text-white':'hover:bg-gray-700 hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span class="nav-text">Documentation</span>
            </a>
        </nav>
        <div class="p-4 border-t border-gray-700 flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-[#0A8F3C] flex items-center justify-center text-white text-xs font-bold">
                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0 nav-text">
                <p class="text-sm truncate text-white">{{ Auth::user()->name ?? 'Admin' }}</p>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-xs text-gray-400 hover:text-white">Sign out</button>
                </form>
            </div>
        </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white p-4 flex items-center justify-between border-b border-gray-200 flex-shrink-0 sticky-header" id="main-header">
            <div class="flex items-center gap-4">
                <h2 class="text-lg font-semibold text-gray-700">@yield('page-title', 'Overview')</h2>
            </div>
            <div class="flex items-center gap-4">
                <select onchange="if(this.value) window.location.href=this.value" class="border rounded-xl px-3 py-1 text-sm">
                    <option value="">Quick switch client...</option>
                    @foreach(\App\Models\Client::orderBy('name')->get() as $c)
                        <option value="{{ route('clients.show', $c) }}">{{ $c->name }}</option>
                    @endforeach
                </select>
                <span class="text-sm text-gray-500">{{ now()->format('l, j M Y') }}</span>
            </div>
        </header>
        <main class="flex-1 overflow-y-auto admin-bg">
            <div class="p-4 lg:p-6 max-w-7xl mx-auto w-full main-content">
                @yield('content')
            </div>
        </main>
    </div>

    <div class="toast-container" id="toast-container"></div>

    <script>
        function toggleSidebar() {
            document.getElementById('admin-body').classList.toggle('sidebar-collapsed');
        }
        const main = document.querySelector('main');
        const header = document.getElementById('main-header');
        main.addEventListener('scroll', () => {
            header.classList.toggle('shadowed', main.scrollTop > 10);
        });
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = 'toast';
            const icon = type === 'success' ? '&#10003;' : '&#10007;';
            const bgColor = type === 'success' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700';
            toast.innerHTML = `<span class="${bgColor} rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold">${icon}</span> ${message}`;
            container.appendChild(toast);
            setTimeout(() => {
                toast.classList.add('removing');
                setTimeout(() => toast.remove(), 300);
            }, 3500);
        }
        @if(session('success'))
            showToast('{{ session('success') }}', 'success');
        @endif
    </script>
</body>
</html>








