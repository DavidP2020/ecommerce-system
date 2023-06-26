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
            $table->integer("user_id");
            $table->string("name");
            $table->string("phoneNum");
            $table->string("email");
            $table->string("address");
            $table->string("city");
            $table->string("state");
            $table->string("zip");
            $table->string("payment_mode");
            $table->string('transaction_id');
            $table->string('order_id');
            $table->string('gross_amount');
            $table->string('ongkir')->nullable();
            $table->string('cancelBy')->nullable();
            $table->string('paidBy')->nullable();
            $table->string('acceptBy')->nullable();
            $table->string('pdf_url')->nullable();
            $table->string("status");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
