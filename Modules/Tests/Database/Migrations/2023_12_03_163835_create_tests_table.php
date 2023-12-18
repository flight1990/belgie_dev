<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->unsignedDouble('x')->nullable();
            $table->unsignedDouble('y')->nullable();
            $table->unsignedDouble('distance')->nullable();
            $table->unsignedDouble('max_speed_download')->nullable();
            $table->unsignedDouble('medium_speed_download')->nullable();
            $table->unsignedDouble('max_speed_upload')->nullable();
            $table->unsignedDouble('min_speed_upload')->nullable();
            $table->unsignedDouble('max_ping')->nullable();
            $table->unsignedDouble('medium_ping')->nullable();
            $table->unsignedDouble('time_start')->nullable();
            $table->unsignedDouble('time_download_web_1')->nullable();
            $table->unsignedDouble('time_download_web_2')->nullable();
            $table->unsignedDouble('time_download_web_3')->nullable();
            $table->unsignedDouble('loss_ping')->nullable();
            $table->string('model_phone')->nullable();
            $table->string('version_os')->nullable();
            $table->string('level_signal')->nullable();
            $table->string('address_site_1')->nullable();
            $table->string('address_site_2')->nullable();
            $table->string('address_site_3')->nullable();
            $table->string('address_youtube')->nullable();
            $table->string('screen_resolution')->nullable();
            $table->string('load_web_1')->nullable();
            $table->string('load_web_2')->nullable();
            $table->string('load_web_3')->nullable();
            $table->string('data_used')->nullable();
            $table->boolean('complaint')->default(false);
            $table->boolean('is_room')->default(false);
            $table->foreignId('operator_id')->constrained('operators');
            $table->foreignId('standard_id')->constrained('standards');
            $table->foreignId('connection_type_id')->constrained('connection_types');
            $table->foreignId('server_id')->constrained('servers');
            $table->foreignId('tower_id')->constrained('towers');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->unsignedBigInteger('band')->nullable();
            $table->unsignedBigInteger('sector')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tests');
    }
};
