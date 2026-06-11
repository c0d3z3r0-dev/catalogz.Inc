<?php
namespace App\Http\Controllers;
use App\Models\Client;
use Illuminate\Http\Request;

class CatalogsController extends Controller
{
    public function index(Request $request)
    {
        $query = Client::where('is_active', true);

        // Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $clients = $query->orderBy('name')->paginate(12);

        // Featured catalogs: top 3 by product count
        $featured = Client::where('is_active', true)
            ->withCount('products')
            ->orderByDesc('products_count')
            ->take(3)
            ->get();

        // Get distinct categories
        $categories = Client::where('is_active', true)
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');

        return view('catalogs.index', compact('clients', 'featured', 'categories'));
    }
}
