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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('tx_id')->unique(); // e.g. NP123456
            $table->enum('type', ['transfer', 'bill', 'load', 'topup']);
            $table->decimal('amount', 15, 2);
            $table->decimal('fee', 10, 2)->default(0.00);
            $table->string('recipient_detail'); // Bank Name/Phone/Ref No.
            $table->enum('status', ['success', 'failed', 'pending'])->default('success');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
