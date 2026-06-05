<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add columns if they don't already exist
        Schema::table('clients', function (Blueprint $table) {
            if (!Schema::hasColumn('clients', 'address')) {
                $table->text('address')->nullable();
            }
            if (!Schema::hasColumn('clients', 'city')) {
                $table->string('city')->nullable();
            }
            if (!Schema::hasColumn('clients', 'contact_email')) {
                $table->string('contact_email')->nullable();
            }
            if (!Schema::hasColumn('clients', 'background_color')) {
                $table->string('background_color')->nullable();
            }
            if (!Schema::hasColumn('clients', 'font_family')) {
                $table->string('font_family')->nullable();
            }
            if (!Schema::hasColumn('clients', 'custom_css')) {
                $table->text('custom_css')->nullable();
            }
            if (!Schema::hasColumn('clients', 'api_token')) {
                $table->string('api_token', 80)->unique()->nullable();
            }
        });

        // Apply default values to existing clients
        \App\Models\Client::query()->update([
            'background_color' => '#FFFFFF',
            'font_family' => 'Inter',
        ]);
    }

    public function down(): void
    {
        // No rollback needed for this safe migration
    }
};
