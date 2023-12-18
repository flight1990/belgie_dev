<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('web_resources', function (Blueprint $table) {
            $table->id();
            $table->string('address_site_1')->nullable();
            $table->string('address_site_2')->nullable();
            $table->string('address_site_3')->nullable();
            $table->string('address_video')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('web_resources');
    }
};
