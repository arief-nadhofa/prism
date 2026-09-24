<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_problem', function (Blueprint $table) {
            $table->id(); // int auto increment

            // Kolom Foreign Key yang mereferensikan kolom string (npk & line)
            $table->string('npk');
            $table->string('line');

            $table->text('problem');
            $table->text('attachment_1')->nullable();
            $table->text('attachment_2')->nullable();
            $table->text('attachment_3')->nullable();
            $table->text('countermeasure')->nullable();
            $table->integer('status')->default(0);
            $table->dateTime('start_problem')->nullable();
            $table->dateTime('finish_problem')->nullable();
            $table->string('duration')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('created_by')->nullable(); // Sesuai tipe datetime di diagram

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_problem');
    }
};
