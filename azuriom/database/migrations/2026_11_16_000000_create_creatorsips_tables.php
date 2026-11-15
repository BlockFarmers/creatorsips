<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('creatorsips_ips', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hostname')->unique();
            $table->unsignedInteger('user_id')->nullable();
            $table->string('minecraft_name', 32)->nullable();
            $table->string('description')->nullable();
            $table->boolean('is_enabled')->default(true);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });

        Schema::create('creatorsips_ip_players', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('creator_ip_id');
            $table->string('player_uuid', 32);
            $table->string('player_name', 32);
            $table->boolean('is_new')->default(false);
            $table->unsignedInteger('joins_count')->default(0);
            $table->timestamp('first_joined_at')->nullable();
            $table->timestamp('last_joined_at')->nullable();
            $table->timestamps();

            $table->unique(['creator_ip_id', 'player_uuid']);
            $table->index('player_uuid');
            $table->foreign('creator_ip_id')->references('id')->on('creatorsips_ips')->cascadeOnDelete();
        });

        Schema::create('creatorsips_players', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid', 32)->unique();
            $table->string('name', 32);
            $table->timestamp('first_seen_at')->nullable();
            $table->timestamp('last_seen_at')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('creatorsips_ip_players');
        Schema::dropIfExists('creatorsips_players');
        Schema::dropIfExists('creatorsips_ips');
    }
};
