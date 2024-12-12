<?php

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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->dateTime('send_to_kitchen_time');
            $table->enum('status', ['Pending', 'In-Progress', 'Completed'])->default('Pending');
            $table->decimal('total_cost', 10, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('order_concession', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('concession_id');
            $table->integer('quantity')->default(1);
            
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('concession_id')->references('id')->on('concessions')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_concession');
        Schema::dropIfExists('orders');
    }
};
