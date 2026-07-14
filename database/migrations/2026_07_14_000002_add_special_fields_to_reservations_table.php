<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->string('event_type', 100)->nullable()->after('reserved_at');
            $table->string('decoration_request')->nullable()->after('event_type');
            $table->text('special_request')->nullable()->after('decoration_request');
            $table->string('phone', 20)->nullable()->after('special_request');
            $table->string('menu_preference', 50)->nullable()->after('phone');
            $table->boolean('is_special')->default(false)->after('menu_preference');
        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn(['event_type', 'decoration_request', 'special_request', 'phone', 'menu_preference', 'is_special']);
        });
    }
};
