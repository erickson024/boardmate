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
            $table->decimal('cost', 10, 2);
            $table->enum('type', ['Apartment','Condominium', 'Dormitory', 'Studio', 'Bedspace', 'House']);
            $table->longText('description');

            $table->string('address');  
            $table->decimal('latitude', 10, 7);   // or double
            $table->decimal('longitude', 10, 7);  // or double
            
            $table->json('feature')->nullable();

            $table->json('images')->nullable();

            $table->enum('tenantType', ['Employee', 'Student', 'Family', 'Groups', 'Single', 'Couple', 'Any']);
            $table->enum('tenantGender', ['Male','Female', 'Any']);
            $table->text('tenantRestriction')->nullable();

            $table->longText('terms')->nullable();
            $table->longText('payment')->nullable();
            $table->boolean('agree');
            
        

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
