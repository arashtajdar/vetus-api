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
        Schema::create('locations', function (Blueprint $table) {
            $table->id('id');
            $table->string('name');
            $table->string('latitude', 20);
            $table->string('longitude', 20);
            $table->text('description')->nullable();
            $table->string('website')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->integer('points')->default(0);
            $table->unsignedBigInteger('user_id')->nullable();

            $table->foreign('category_id')->references('category_id')->on('categories')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
