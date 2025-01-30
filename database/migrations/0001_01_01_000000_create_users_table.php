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
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->bigInteger('role_id')->nullable()->default('1');
            $table->enum('role', ['super admin', 'admin', 'user'])->default('user');
            $table->string('username')->unique();
            $table->integer('failed_login_attempts')->default(0);
            $table->timestamp('last_login_attempt_at')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->timestamp('last_password_changed_at')->nullable();
            $table->timestamp('last_password_reset_at')->nullable();
            $table->timestamp('last_failed_login_at')->nullable();
            $table->timestamp('last_failed_login_attempt_at')->nullable();
            $table->timestamp('last_failed_password_reset_at')->nullable();
            $table->timestamp('last_failed_password_change_at')->nullable();
            $table->timestamp('last_successful_password_change_at')->nullable();
            $table->timestamp('last_successful_password_reset_at')->nullable();
            // $table->string('phone_number')->unique();
            // $table->string('profile_photo_path', 2048)->nullable();
            // $table->string('address')->nullable();
            // $table->string('city')->nullable();
            // $table->string('province')->nullable();
            // $table->string('country')->nullable();
            // $table->string('postal_code')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->softDeletes();
            $table->timestamp('deleted_by')->nullable();

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
