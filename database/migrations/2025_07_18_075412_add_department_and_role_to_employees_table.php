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
        Schema::table('employees', function (Blueprint $table) {
            $table->foreignId('department_id')->nullable()->after('status');
            $table->foreign('department_id')->references('id')->on('departments')->onUpdate('cascade')->onDelete('set null');

            $table->foreignId('role_id')->nullable()->after('department_id');
            $table->foreign('role_id')->references('id')->on('roles')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
            $table->dropForeign(['role_id']);

            $table->dropColumn(['department_id', 'role_id']);
        });
    }
};
