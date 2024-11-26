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
            $table->string('fullname');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('profile_pic')->nullable();
            $table->string('profile_cover')->nullable();
            $table->text('about')->nullable();
            $table->string('password');
            $table->boolean('is_admin')->default(false);
            $table->date('date_of_birth')->nullable();
            $table->smallInteger('sex')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_country')->nullable()->default(null);
            $table->string('phone_normalized')->nullable()->default(null);
            $table->string('phone_national')->nullable()->default(null);
            $table->string('phone_e164')->nullable()->default(null);
            $table->string('website')->nullable()->default(null);
            $table->string('location')->nullable()->default(null);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
