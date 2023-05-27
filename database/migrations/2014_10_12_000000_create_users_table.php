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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string("password");
            $table->string("gender")->default("");
            $table->string("phoneNum")->default("");
            $table->string("place_of_birth")->default("");
            $table->string("date_of_birth")->default("");
            $table->text("address")->default("");
            $table->string("state")->default("");
            $table->string("city")->default("");
            $table->string("zip")->default("");
            $table->string('role')->default("USER");
            $table->tinyInteger("status")->default(1);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
