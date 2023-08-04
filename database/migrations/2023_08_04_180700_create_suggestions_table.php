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
        Schema::create('suggestions', function (Blueprint $table) {
            $table->id('suggestion_id');
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('suggested_by_user_id');
            $table->text('suggestion_text');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

            $table->foreign('location_id')->references('location_id')->on('locations')->onDelete('cascade');
            $table->foreign('suggested_by_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suggestions');
    }
};
