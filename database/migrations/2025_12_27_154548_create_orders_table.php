<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
       Schema::create('orders', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('order_number')->unique(); // bill number
    $table->decimal('total_amount', 10, 2);
    $table->enum('status', ['pending','completed','cancelled']);
    $table->timestamps(); // created_at will store purchase date & time
});

    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
