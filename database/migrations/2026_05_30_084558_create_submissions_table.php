<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->string('business_name');
            $table->string('whatsapp_number');
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('contact_email')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('submission_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained()->onDelete('cascade');
            $table->string('image_path')->nullable();
            $table->string('product_name')->nullable();
            $table->string('product_price')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submission_products');
        Schema::dropIfExists('submissions');
    }
};
