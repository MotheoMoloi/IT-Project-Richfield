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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('book_name');
            $table->string('book_author');
            $table->string('category')->nullable();
            $table->string('isbn')->unique();
            $table->integer('year');
            $table->decimal('price', 8, 2)->nullable();
            $table->enum('status', ['available', 'checked_out', 'reserved'])->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};