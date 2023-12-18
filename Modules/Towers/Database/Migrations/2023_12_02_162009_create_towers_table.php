<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('towers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('standard_id')->constrained('standards');
            $table->foreignId('operator_id')->constrained('operators');
            $table->unsignedBigInteger('bsn')->nullable();
            $table->unsignedBigInteger('lac')->nullable();
            $table->unsignedBigInteger('cell_id')->nullable();
            $table->unsignedBigInteger('mnc')->nullable();
            $table->unsignedDouble('x')->nullable();
            $table->unsignedDouble('y')->nullable();
            $table->integer('band')->nullable();
            $table->integer('sector')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('towers');
    }
};
