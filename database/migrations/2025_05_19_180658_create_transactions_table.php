<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('reservation_id')->nullable()->constrained()->nullOnDelete();
            $table->string('transaction_code')->unique();
            $table->enum('payment_method', ['credit', 'dana', 'none'])->default('none');
            $table->enum('status', ['pending', 'paid'])->default('pending');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('service_charge', 10, 2);
            $table->decimal('tax', 10, 2);
            $table->decimal('total', 10, 2);
            $table->json('temp_reservation')->nullable(); // <-- tambahkan ini
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
