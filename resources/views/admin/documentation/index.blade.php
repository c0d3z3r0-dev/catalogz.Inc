@extends('layouts.admin.app')

@section('title', 'System Documentation')
@section('page-title', 'System Documentation')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

    {{-- Table of Contents --}}
    <div class="card-float p-6">
        <h2 class="text-xl font-bold text-slate-800 mb-4">Table of Contents</h2>
        <ul class="space-y-1 text-sm text-blue-600">
            <li><a href="#overview" class="hover:underline">1. System Overview</a></li>
            <li><a href="#architecture" class="hover:underline">2. Technical Architecture</a></li>
            <li><a href="#admin-guide" class="hover:underline">3. Admin User Guide</a></li>
            <li><a href="#client-management" class="hover:underline">4. Client Management</a></li>
            <li><a href="#product-management" class="hover:underline">5. Product Management</a></li>
            <li><a href="#order-management" class="hover:underline">6. Order Management</a></li>
            <li><a href="#catalog-flow" class="hover:underline">7. Customer Catalog Flow</a></li>
            <li><a href="#payment-flow" class="hover:underline">8. Payment Flow</a></li>
            <li><a href="#api-reference" class="hover:underline">9. API Reference</a></li>
            <li><a href="#database-schema" class="hover:underline">10. Database Schema</a></li>
            <li><a href="#deployment" class="hover:underline">11. Deployment Guide</a></li>
            <li><a href="#troubleshooting" class="hover:underline">12. Troubleshooting</a></li>
        </ul>
    </div>

    {{-- 1. System Overview --}}
    <div class="card-float p-6" id="overview">
        <h2 class="text-xl font-bold text-slate-800 mb-4">1. System Overview</h2>
        <p class="text-sm text-slate-600 mb-3"><strong>Catalog.Inc</strong> is a platform that creates beautiful, mobile‑friendly product catalogs for small businesses in Zimbabwe. Each catalog includes EcoCash payment instructions, allowing customers to browse products and pay directly to the merchant.</p>
        <p class="text-sm text-slate-600 mb-3">The system has two main interfaces:</p>
        <ul class="list-disc list-inside text-sm text-slate-600 space-y-1 ml-4">
            <li><strong>Admin Panel</strong> – Used by the Catalog.Inc team to manage clients, products, orders, and submissions.</li>
            <li><strong>Public Catalog</strong> – A customer‑facing page where end users browse products, add to basket, and complete checkout.</li>
        </ul>
        <p class="text-sm text-slate-600 mt-3"><strong>Current version:</strong> 1.0 | <strong>Tech stack:</strong> Laravel 13, SQLite, Tailwind CSS, Blade</p>
    </div>

    {{-- 2. Technical Architecture --}}
    <div class="card-float p-6" id="architecture">
        <h2 class="text-xl font-bold text-slate-800 mb-4">2. Technical Architecture</h2>
        <h3 class="font-semibold text-slate-700 mt-4 mb-2">Stack</h3>
        <table class="w-full text-sm border-collapse">
            <tr class="border-b"><td class="py-2 font-medium w-40">Backend</td><td class="py-2">PHP 8.3 / Laravel 13</td></tr>
            <tr class="border-b"><td class="py-2 font-medium">Database</td><td class="py-2">SQLite (file‑based, zero‑config)</td></tr>
            <tr class="border-b"><td class="py-2 font-medium">Frontend</td><td class="py-2">Blade templates + Tailwind CSS (CDN)</td></tr>
            <tr class="border-b"><td class="py-2 font-medium">JavaScript</td><td class="py-2">Vanilla JS, AOS animations, no framework</td></tr>
            <tr class="border-b"><td class="py-2 font-medium">Caching</td><td class="py-2">Laravel Cache (file driver), full‑page HTML caching for catalogs</td></tr>
            <tr class="border-b"><td class="py-2 font-medium">File Storage</td><td class="py-2">Local disk (storage/app/public), symlinked to public/storage</td></tr>
            <tr class="border-b"><td class="py-2 font-medium">Notifications</td><td class="py-2">WhatsApp Cloud API (optional), Email (optional)</td></tr>
            <tr><td class="py-2 font-medium">Deployment</td><td class="py-2">VPS with Nginx + PHP‑FPM, or Laragon for local dev</td></tr>
        </table>

        <h3 class="font-semibold text-slate-700 mt-6 mb-2">Directory Structure (key files)</h3>
        <pre class="bg-slate-900 text-green-400 p-4 rounded-xl text-xs overflow-x-auto">
app/
  Http/Controllers/
    Admin/          – ClientController, ProductController, OrderController, SubmissionController
    Auth/           – LoginController
    Api/            – CatalogApiController, CartApiController, CheckoutApiController
    CatalogController   – Public catalog, cart, saved items
    CheckoutController  – Order creation + notifications
    OrderController     – Order instructions, confirmation, status
    MerchantDashboardController – Merchant self‑service orders
    SubmissionController – Public application form + admin review
  Models/           – Client, Product, Order, OrderItem, Cart, CartItem, Submission
  Services/         – PaynowService (payment integration)
database/
  migrations/       – All table schemas
  database.sqlite   – The entire database (single file)
resources/views/
  admin/            – Dashboard, clients, products, orders, submissions, documentation
  auth/             – Login page
  catalog/          – Public catalog, cart, saved items
  checkout/         – Checkout page
  order/            – Order instructions, confirmation
  layouts/admin/    – Admin sidebar + header layout
  submissions/      – Public application form
  welcome.blade.php – Landing page
routes/
  web.php           – All application routes
        </pre>
    </div>

    {{-- 3. Admin User Guide --}}
    <div class="card-float p-6" id="admin-guide">
        <h2 class="text-xl font-bold text-slate-800 mb-4">3. Admin User Guide</h2>
        <h3 class="font-semibold text-slate-700 mt-4 mb-2">Logging In</h3>
        <p class="text-sm text-slate-600">Access the admin panel at <code class="bg-slate-100 px-1 rounded">/login</code>. Default credentials are set during installation via the seeder. Only one admin account exists. To add more, use Tinker or a database tool.</p>

        <h3 class="font-semibold text-slate-700 mt-4 mb-2">Dashboard</h3>
        <p class="text-sm text-slate-600">Shows total clients, products, orders, orders this week, recent orders, quick actions, and system health (disk usage, database size, PHP/Laravel version).</p>

        <h3 class="font-semibold text-slate-700 mt-4 mb-2">Navigation</h3>
        <p class="text-sm text-slate-600">The sidebar provides links to <strong>Dashboard</strong>, <strong>Clients</strong>, <strong>Orders</strong>, and <strong>Submissions</strong>. The Submissions menu shows a green dot and badge count when new applications arrive.</p>

        <h3 class="font-semibold text-slate-700 mt-4 mb-2">Quick Client Switcher</h3>
        <p class="text-sm text-slate-600">The header dropdown lets you jump directly to any client's detail page.</p>

        <h3 class="font-semibold text-slate-700 mt-4 mb-2">Toast Notifications</h3>
        <p class="text-sm text-slate-600">Success messages appear as toasts in the top‑right corner and auto‑dismiss after 3.5 seconds.</p>
    </div>

    {{-- 4. Client Management --}}
    <div class="card-float p-6" id="client-management">
        <h2 class="text-xl font-bold text-slate-800 mb-4">4. Client Management</h2>
        <h3 class="font-semibold text-slate-700 mt-4 mb-2">Creating a Client</h3>
        <p class="text-sm text-slate-600">Go to <strong>Clients > + New Client</strong>. Fill in business name (required), WhatsApp number (required), optional email, address, city, contact email. A unique slug is auto‑generated from the business name. A merchant token is automatically created for the self‑service dashboard.</p>
        <p class="text-sm text-slate-600 mt-2">You can also upload a logo, set a custom background colour, font family, and custom CSS for the catalog.</p>

        <h3 class="font-semibold text-slate-700 mt-4 mb-2">Editing / Deleting</h3>
        <p class="text-sm text-slate-600">From the clients list, click <strong>Edit</strong> to modify any field. Click <strong>Delete</strong> to remove the client and all associated products and orders. The client list supports <strong>search</strong>, <strong>column sorting</strong>, <strong>bulk delete</strong>, and <strong>CSV export</strong>.</p>

        <h3 class="font-semibold text-slate-700 mt-4 mb-2">Merchant Dashboard</h3>
        <p class="text-sm text-slate-600">Each client has a unique merchant dashboard URL: <code class="bg-slate-100 px-1 rounded">/{slug}/merchant?token={merchant_token}</code>. The merchant can view their orders and mark paid orders as fulfilled. The link is displayed on the client detail page with a copy button.</p>

        <h3 class="font-semibold text-slate-700 mt-4 mb-2">API Configuration</h3>
        <p class="text-sm text-slate-600">Each client can have an API token for connecting external React catalog apps. Generate a token from the client's <strong>API Config</strong> page.</p>
    </div>

    {{-- 5. Product Management --}}
    <div class="card-float p-6" id="product-management">
        <h2 class="text-xl font-bold text-slate-800 mb-4">5. Product Management</h2>
        <h3 class="font-semibold text-slate-700 mt-4 mb-2">Adding Products</h3>
        <p class="text-sm text-slate-600">Go to a client's detail page > <strong>Manage Products > + Add Product</strong>. Fill in name (required), description, price (USD), and upload a photo. You can also bulk‑add products by pasting tab‑delimited data (Name → Price → Description) on the products index page.</p>

        <h3 class="font-semibold text-slate-700 mt-4 mb-2">Product Badges</h3>
        <p class="text-sm text-slate-600">Products can be marked as <strong>New</strong>, <strong>Sale</strong>, or <strong>Best Seller</strong> (via the edit form). These badges appear on the catalog cards.</p>

        <h3 class="font-semibold text-slate-700 mt-4 mb-2">Image Handling</h3>
        <p class="text-sm text-slate-600">Uploaded images are stored in <code class="bg-slate-100 px-1 rounded">storage/app/public/products/</code> and served via the <code class="bg-slate-100 px-1 rounded">/storage/</code> symlink. External URLs (e.g., Unsplash) are also supported and displayed directly.</p>

        <h3 class="font-semibold text-slate-700 mt-4 mb-2">Deleting Products</h3>
        <p class="text-sm text-slate-600">Deleting a product removes its image and any associated order items (to maintain referential integrity). The product is permanently deleted.</p>
    </div>

    {{-- 6. Order Management --}}
    <div class="card-float p-6" id="order-management">
        <h2 class="text-xl font-bold text-slate-800 mb-4">6. Order Management</h2>
        <h3 class="font-semibold text-slate-700 mt-4 mb-2">Order Statuses</h3>
        <table class="w-full text-sm border-collapse mt-2">
            <tr class="border-b"><td class="py-2 font-medium w-32">Pending</td><td class="py-2">Order just placed; payment not yet confirmed.</td></tr>
            <tr class="border-b"><td class="py-2 font-medium">Awaiting Payment</td><td class="py-2">Reserved for future Paynow integration.</td></tr>
            <tr class="border-b"><td class="py-2 font-medium">Paid</td><td class="py-2">Payment confirmed by merchant or admin.</td></tr>
            <tr class="border-b"><td class="py-2 font-medium">Fulfilled</td><td class="py-2">Order collected/delivered to customer.</td></tr>
            <tr><td class="py-2 font-medium">Failed</td><td class="py-2">Payment failed or order cancelled.</td></tr>
        </table>

        <h3 class="font-semibold text-slate-700 mt-4 mb-2">Changing Status</h3>
        <p class="text-sm text-slate-600">Open an order detail page and use the dropdown to change status. The merchant can also mark orders as fulfilled from their self‑service dashboard.</p>

        <h3 class="font-semibold text-slate-700 mt-4 mb-2">Deleting Orders</h3>
        <p class="text-sm text-slate-600">Orders can be deleted from the list or detail page. Deleting an order removes its items but does not affect products or clients.</p>
    </div>

    {{-- 7. Customer Catalog Flow --}}
    <div class="card-float p-6" id="catalog-flow">
        <h2 class="text-xl font-bold text-slate-800 mb-4">7. Customer Catalog Flow</h2>
        <ol class="list-decimal list-inside text-sm text-slate-600 space-y-2 ml-4">
            <li>Customer opens the catalog URL (e.g., <code class="bg-slate-100 px-1 rounded">/lusso-boutique</code>).</li>
            <li>They browse products in a responsive grid (1–5 columns depending on screen size).</li>
            <li>Tapping a product image opens a <strong>quick‑view modal</strong> with larger photo, description, price, and "Add to Basket" button.</li>
            <li>The <strong>cart</strong> stores items in the session with a quantity stepper (+/–).</li>
            <li>Proceeding to checkout creates an <strong>order</strong> with status "pending". The cart is cleared.</li>
            <li>The customer is redirected to the <strong>payment instructions</strong> page showing the merchant's EcoCash number, business name, address, and a WhatsApp confirmation button.</li>
            <li>The customer sends payment directly to the merchant's EcoCash number and taps "Send Payment Confirmation via WhatsApp" to notify the merchant.</li>
            <li>The merchant (or admin) marks the order as <strong>paid</strong> and later <strong>fulfilled</strong>.</li>
        </ol>

        <h3 class="font-semibold text-slate-700 mt-4 mb-2">Additional Features</h3>
        <ul class="list-disc list-inside text-sm text-slate-600 space-y-1 ml-4">
            <li><strong>Search bar</strong> – filters products by name in real time.</li>
            <li><strong>Dark mode</strong> – toggle in the header, preference saved in localStorage.</li>
            <li><strong>Save for later</strong> – bookmark products to a saved list (localStorage).</li>
            <li><strong>Recently viewed</strong> – shows the last 4 products the customer tapped.</li>
            <li><strong>Product badges</strong> – "New", "Sale", "Best Seller" tags on cards.</li>
            <li><strong>Floating WhatsApp button</strong> – quick chat with the merchant.</li>
            <li><strong>Back‑to‑top button</strong> – appears after scrolling.</li>
            <li><strong>Marquee ribbon</strong> – shop info scrolling at the bottom.</li>
            <li><strong>Share button</strong> – uses the Web Share API or copies the link.</li>
        </ul>
    </div>

    {{-- 8. Payment Flow --}}
    <div class="card-float p-6" id="payment-flow">
        <h2 class="text-xl font-bold text-slate-800 mb-4">8. Payment Flow</h2>
        <p class="text-sm text-slate-600 mb-3">Currently, Catalog.Inc uses <strong>manual EcoCash payments</strong>. No payment gateway integration is active.</p>
        <h3 class="font-semibold text-slate-700 mt-4 mb-2">How it works</h3>
        <ul class="list-disc list-inside text-sm text-slate-600 space-y-1 ml-4">
            <li>Customer places an order and sees the merchant's EcoCash number.</li>
            <li>Customer sends money directly via EcoCash (using the order reference number).</li>
            <li>Customer taps "Send Payment Confirmation via WhatsApp" to notify the merchant.</li>
            <li>Merchant verifies payment and marks the order as paid (via admin or self‑service dashboard).</li>
        </ul>
        <h3 class="font-semibold text-slate-700 mt-4 mb-2">Future Paynow Integration</h3>
        <p class="text-sm text-slate-600">The codebase includes a <code class="bg-slate-100 px-1 rounded">PaynowService</code> class, webhook route, and currency field on orders. To activate real payments, set <code class="bg-slate-100 px-1 rounded">PAYNOW_ID</code> and <code class="bg-slate-100 px-1 rounded">PAYNOW_KEY</code> in <code class="bg-slate-100 px-1 rounded">.env</code>. The service supports USSD push and web checkout.</p>
    </div>

    {{-- 9. API Reference --}}
    <div class="card-float p-6" id="api-reference">
        <h2 class="text-xl font-bold text-slate-800 mb-4">9. API Reference</h2>
        <p class="text-sm text-slate-600 mb-3">The API is designed for external React catalog apps. All endpoints return JSON.</p>
        <table class="w-full text-sm border-collapse">
            <thead class="bg-slate-50"><tr><th class="p-2 text-left">Method</th><th class="p-2 text-left">Endpoint</th><th class="p-2 text-left">Description</th></tr></thead>
            <tbody>
                <tr class="border-b"><td class="p-2 font-mono">GET</td><td class="p-2 font-mono">/api/v1/client/{slug}</td><td class="p-2">Client info + available products</td></tr>
                <tr class="border-b"><td class="p-2 font-mono">POST</td><td class="p-2 font-mono">/api/v1/cart/add</td><td class="p-2">Add item to cart (body: client_slug, product_id, quantity, cart_token)</td></tr>
                <tr class="border-b"><td class="p-2 font-mono">GET</td><td class="p-2 font-mono">/api/v1/cart/{token}</td><td class="p-2">View cart by token</td></tr>
                <tr><td class="p-2 font-mono">POST</td><td class="p-2 font-mono">/api/v1/checkout</td><td class="p-2">Create order (body: cart_token, customer_phone, currency)</td></tr>
            </tbody>
        </table>
    </div>

    {{-- 10. Database Schema --}}
    <div class="card-float p-6" id="database-schema">
        <h2 class="text-xl font-bold text-slate-800 mb-4">10. Database Schema</h2>
        <h3 class="font-semibold text-slate-700 mt-4 mb-2">Tables</h3>
        <table class="w-full text-sm border-collapse">
            <tr class="border-b"><td class="py-2 font-medium w-32">users</td><td class="py-2">Admin user(s) – id, name, email, password</td></tr>
            <tr class="border-b"><td class="py-2 font-medium">clients</td><td class="py-2">Businesses – name, slug, whatsapp_number, email, logo_path, address, city, contact_email, background_color, font_family, custom_css, api_token, merchant_token, is_active</td></tr>
            <tr class="border-b"><td class="py-2 font-medium">products</td><td class="py-2">Catalog items – client_id, name, description, price, image_path, is_available, sort_order, is_new, is_sale, is_bestseller</td></tr>
            <tr class="border-b"><td class="py-2 font-medium">orders</td><td class="py-2">Customer orders – client_id, customer_phone, status, total, currency, paynow_poll_url, paynow_reference</td></tr>
            <tr class="border-b"><td class="py-2 font-medium">order_items</td><td class="py-2">Line items – order_id, product_id, product_name, price, quantity</td></tr>
            <tr class="border-b"><td class="py-2 font-medium">carts</td><td class="py-2">API‑based carts – token, client_id</td></tr>
            <tr class="border-b"><td class="py-2 font-medium">cart_items</td><td class="py-2">API cart line items – cart_id, product_id, quantity</td></tr>
            <tr class="border-b"><td class="py-2 font-medium">submissions</td><td class="py-2">Client applications – business_name, whatsapp_number, email, address, city, contact_email, notes, viewed_at</td></tr>
            <tr><td class="py-2 font-medium">submission_products</td><td class="py-2">Application products – submission_id, image_path, product_name, product_price</td></tr>
        </table>
    </div>

    {{-- 11. Deployment Guide --}}
    <div class="card-float p-6" id="deployment">
        <h2 class="text-xl font-bold text-slate-800 mb-4">11. Deployment Guide</h2>
        <h3 class="font-semibold text-slate-700 mt-4 mb-2">Local Development (Laragon)</h3>
        <ol class="list-decimal list-inside text-sm text-slate-600 space-y-1 ml-4">
            <li>Place the project in <code class="bg-slate-100 px-1 rounded">C:\laragon\www\cataloginc</code>.</li>
            <li>Start Laragon (Apache or Nginx).</li>
            <li>Run <code class="bg-slate-100 px-1 rounded">php artisan migrate</code> and <code class="bg-slate-100 px-1 rounded">php artisan db:seed</code>.</li>
            <li>Run <code class="bg-slate-100 px-1 rounded">php artisan storage:link</code>.</li>
            <li>Access at <code class="bg-slate-100 px-1 rounded">http://cataloginc.test</code> or <code class="bg-slate-100 px-1 rounded">http://localhost:8000</code>.</li>
        </ol>
        <h3 class="font-semibold text-slate-700 mt-4 mb-2">Production (VPS)</h3>
        <ol class="list-decimal list-inside text-sm text-slate-600 space-y-1 ml-4">
            <li>Provision a VPS with Ubuntu 22.04/24.04, Nginx, PHP 8.3, and SQLite.</li>
            <li>Clone the project to <code class="bg-slate-100 px-1 rounded">/var/www/cataloginc</code>.</li>
            <li>Run <code class="bg-slate-100 px-1 rounded">composer install --no-dev --optimize-autoloader</code>.</li>
            <li>Copy <code class="bg-slate-100 px-1 rounded">.env.example</code> to <code class="bg-slate-100 px-1 rounded">.env</code>, set <code class="bg-slate-100 px-1 rounded">APP_ENV=production</code>, <code class="bg-slate-100 px-1 rounded">APP_DEBUG=false</code>, generate key.</li>
            <li>Set permissions: <code class="bg-slate-100 px-1 rounded">chown -R www-data:www-data storage bootstrap/cache database</code>.</li>
            <li>Configure Nginx to serve from <code class="bg-slate-100 px-1 rounded">/var/www/cataloginc/public</code>.</li>
            <li>Set up SSL with Certbot or Cloudflare.</li>
        </ol>
        <h3 class="font-semibold text-slate-700 mt-4 mb-2">Environment Variables</h3>
        <table class="w-full text-sm border-collapse">
            <tr class="border-b"><td class="py-2 font-medium w-48">PAYNOW_ID / PAYNOW_KEY</td><td class="py-2">Paynow integration credentials (optional)</td></tr>
            <tr class="border-b"><td class="py-2 font-medium">WHATSAPP_TOKEN / WHATSAPP_PHONE_ID</td><td class="py-2">WhatsApp Cloud API credentials (optional)</td></tr>
            <tr><td class="py-2 font-medium">ADMIN_WHATSAPP</td><td class="py-2">Admin phone number for submission notifications</td></tr>
        </table>
    </div>

    {{-- 12. Troubleshooting --}}
    <div class="card-float p-6" id="troubleshooting">
        <h2 class="text-xl font-bold text-slate-800 mb-4">12. Troubleshooting</h2>
        <div class="space-y-4 text-sm text-slate-600">
            <div>
                <p class="font-semibold text-slate-700">Catalog shows blank page</p>
                <p>Run <code class="bg-slate-100 px-1 rounded">php artisan cache:clear && php artisan view:clear</code>. The catalog HTML is cached; clearing the cache forces regeneration.</p>
            </div>
            <div>
                <p class="font-semibold text-slate-700">Images not showing</p>
                <p>Ensure <code class="bg-slate-100 px-1 rounded">php artisan storage:link</code> has been run. For external URLs, ensure they start with <code class="bg-slate-100 px-1 rounded">http</code>.</p>
            </div>
            <div>
                <p class="font-semibold text-slate-700">Checkout fails with WhatsApp error</p>
                <p>The WhatsApp notification is attempted but fails gracefully if credentials are missing. Set <code class="bg-slate-100 px-1 rounded">WHATSAPP_TOKEN</code> and <code class="bg-slate-100 px-1 rounded">WHATSAPP_PHONE_ID</code> in <code class="bg-slate-100 px-1 rounded">.env</code> to enable.</p>
            </div>
            <div>
                <p class="font-semibold text-slate-700">"Table not found" errors</p>
                <p>Run <code class="bg-slate-100 px-1 rounded">php artisan migrate</code>. Ensure the SQLite file exists at <code class="bg-slate-100 px-1 rounded">database/database.sqlite</code> and is writable.</p>
            </div>
            <div>
                <p class="font-semibold text-slate-700">Foreign key constraint when deleting products</p>
                <p>This has been fixed; order items are deleted before the product. If it still occurs, check that the <code class="bg-slate-100 px-1 rounded">ProductController@destroy</code> method includes <code class="bg-slate-100 px-1 rounded">$product->orderItems()->delete()</code>.</p>
            </div>
            <div>
                <p class="font-semibold text-slate-700">Login redirects to wrong URL</p>
                <p>Ensure <code class="bg-slate-100 px-1 rounded">APP_URL</code> in <code class="bg-slate-100 px-1 rounded">.env</code> matches your actual domain. For local dev, set <code class="bg-slate-100 px-1 rounded">APP_URL=http://localhost:8000</code>.</p>
            </div>
        </div>
    </div>

</div>
@endsection
