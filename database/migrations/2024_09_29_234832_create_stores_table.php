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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->unsignedBigInteger('admin_id');
            $table->string('store_name');
            $table->string('branch')->nullable();
            $table->string('username')->unique();
            $table->string('password');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('admins')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
