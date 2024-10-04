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
        Schema::create('compostagems', function (Blueprint $table) {
            $table->id();
            $table->dateTime('data')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('material_id')->nullable()->constrained('materials');
            $table->string('descricao')->nullable();
            $table->integer('tipo')->default(0);
            $table->double('volume');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compostagems');
    }
};