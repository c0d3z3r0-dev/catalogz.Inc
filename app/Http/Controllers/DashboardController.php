<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $totalClients = Client::count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $ordersThisWeek = Order::where('created_at', '>=', now()->startOfWeek())->count();

        return view('admin.dashboard', compact('totalClients', 'totalProducts', 'totalOrders', 'ordersThisWeek'));
    }
}
