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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->enum('type', ['room', 'bedspace', 'apartment', 'condo', 'house']);
            $table->decimal('cost', 10, 2);
            $table->enum('tenant', ['student', 'professional', 'family', 'any']);
            $table->string('description');
            $table->string('address');
            $table->decimal('latitude', 10, 7);   // or double
            $table->decimal('longitude', 10, 7);  // or double
            $table->json('amenities')->nullable();
            $table->json('images')->nullable();
            $table->json('captions')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
