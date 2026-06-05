<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->string('customer_phone')->nullable();
            $table->string('status')->default('pending');
            $table->decimal('total', 10, 2);
            $table->string('paynow_poll_url')->nullable();
            $table->string('paynow_reference')->nullable();
            $table->string('pin_hash');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
