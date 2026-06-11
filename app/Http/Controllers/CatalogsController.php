<?php
namespace App\Http\Controllers;
use App\Models\Client;
use Illuminate\Http\Request;

class CatalogsController extends Controller
{
    public function index(Request $request)
    {
        $query = Client::where('is_active', true);
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        $clients = $query->orderBy('name')->paginate(12);
        $categories = Client::where('is_active', true)
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');
        return view('catalogs.index', compact('clients', 'categories'));
    }
}
