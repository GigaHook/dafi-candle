<?php

use App\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orderadresses', function (Blueprint $table) {
            $table->foreignIdFor(Order::class)->constrained()->onDelete('cascade');
            $table->enum('type', ['СДЭК', 'Почта РФ'])->default('СДЭК');
            $table->string('city')->max(50);
            $table->string('street')->max(150);
            $table->string('house_number')->max(50);
            $table->string('flat_number')->nullable()->default(null)->max(50);
            $table->string('postal_code')->nullable()->default(null)->max(6);
            $table->string('name')->max(50);
            $table->string('lastname')->max(50);
            $table->string('patronymic')->max(50);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orderadresses');
    }
};
