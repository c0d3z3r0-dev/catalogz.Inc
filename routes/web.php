<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\DocumentationController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentWebhookController;
use App\Http\Controllers\ClientUploadController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\MerchantDashboardController;
use Illuminate\Support\Facades\Route;

// Public Landing Page
Route::get('/', function () { return view('welcome'); });

// Auth
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Public Application Form
Route::get('/apply', [SubmissionController::class, 'create'])->name('submission.create');
Route::post('/apply', [SubmissionController::class, 'store'])->name('submission.store');
Route::get('/apply/thanks/{submission}', [SubmissionController::class, 'thanks'])->name('submission.thanks');

// Legal Pages
Route::view('/privacy', 'legal.privacy');
Route::view('/terms', 'legal.terms');

// Protected admin area
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('clients', ClientController::class);
    Route::resource('clients.products', ProductController::class);

    Route::get('clients/{client}/api-config', [ClientController::class, 'apiConfig'])->name('clients.api-config');
    Route::post('clients/{client}/generate-token', [ClientController::class, 'generateToken'])->name('clients.generate-token');
    Route::post('clients/{client}/products/bulk', [ProductController::class, 'bulkStore'])->name('clients.products.bulk');

    // Admin Orders
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::delete('orders/{order}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');

    // Admin Submissions
    Route::get('submissions', [SubmissionController::class, 'index'])->name('admin.submissions.index');
    Route::get('submissions/{submission}', [SubmissionController::class, 'show'])->name('admin.submissions.show');

    // Documentation
    Route::get('documentation', [DocumentationController::class, 'index'])->name('documentation.index');
});

// Public Catalog
Route::prefix('{slug}')->group(function () {
    Route::get('/', [CatalogController::class, 'show'])->name('catalog.show');
    Route::get('/saved', [CatalogController::class, 'saved'])->name('catalog.saved');
    Route::get('/cart', [CatalogController::class, 'cart'])->name('catalog.cart');
    Route::get('/cart/count', [CatalogController::class, 'cartCount'])->name('catalog.cart.count');
    Route::post('/cart/add', [CatalogController::class, 'addToCart'])->name('catalog.cart.add');
        Route::post('/cart/add-ajax', [CatalogController::class, 'addToCartAjax'])->name('catalog.cart.add.ajax');
    Route::post('/cart/update', [CatalogController::class, 'updateCart'])->name('catalog.cart.update');
    Route::get('/cart/remove/{productId}', [CatalogController::class, 'removeFromCart'])->name('catalog.cart.remove');
    Route::middleware('throttle:3,1')->post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/order/{order}/instructions', [OrderController::class, 'instructions'])->name('order.instructions');
    Route::get('/order/{order}/confirmation', [OrderController::class, 'confirmation'])->name('order.confirmation');
    Route::get('/order/{order}/status', [OrderController::class, 'status'])->name('order.status');
    Route::get('/merchant', [MerchantDashboardController::class, 'orders'])->name('merchant.orders');
    Route::post('/merchant/{order}/fulfill', [MerchantDashboardController::class, 'fulfill'])->name('merchant.fulfill');
});

// Paynow webhook
Route::post('/paynow/webhook', [PaymentWebhookController::class, 'handle'])->withoutMiddleware(['web', 'csrf'])->name('paynow.webhook');

// Client upload page
Route::get('/upload/{slug}', [ClientUploadController::class, 'show']);
Route::post('/upload/{slug}', [ClientUploadController::class, 'store']);

// API Routes
Route::prefix('api/v1')->group(function () {
    Route::get('client/{slug}', [\App\Http\Controllers\Api\CatalogApiController::class, 'clientInfo']);
    Route::post('cart/add', [\App\Http\Controllers\Api\CartApiController::class, 'add']);
    Route::get('cart/{token}', [\App\Http\Controllers\Api\CartApiController::class, 'show']);
    Route::post('checkout', [\App\Http\Controllers\Api\CheckoutApiController::class, 'process']);
});


// Public Catalog Directory
Route::get('/catalogs', [App\Http\Controllers\CatalogsController::class, 'index'])->name('catalogs.index');
