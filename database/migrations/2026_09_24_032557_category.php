<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('category', function (Blueprint $table) {
            $table->id(); // int auto increment
            $table->string('category')->unique(); // Dibuat unique karena dijadikan rujukan relasi
            $table->dateTime('created_at')->nullable();
            $table->dateTime('created_by')->nullable(); // Sesuai tipe datetime di diagram
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category');
    }
};
