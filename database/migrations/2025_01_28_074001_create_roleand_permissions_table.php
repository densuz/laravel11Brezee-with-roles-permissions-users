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
        // Pivot table for role and permissions and users
        Schema::create('role_permissions_users', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
            $table->foreignId('permission_id')->constrained('permissions')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->unique(['role_id', 'permission_id', 'user_id']); // Unik untuk mencegah duplikasi
            $table->text('description')->nullable();
            $table->softDeletes();
            $table->timestamp('deleted_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roleand_permissions');
    }
};
