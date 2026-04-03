<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('virtual_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('card_number')->unique();
            $table->string('card_holder_name');
            $table->string('expiry_date');
            $table->string('cvv'); // Virtual cards mein CVV zaroori hota hai
            $table->enum('status', ['active', 'inactive', 'blocked'])->default('active');
            $table->decimal('spending_limit', 15, 2)->default(0.00); // Har card ki apni limit
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('virtual_cards');
    }
};
