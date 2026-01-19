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
            
            //step1
            $table->string('propertyName');
            $table->decimal('propertyCost', 10, 2);
            $table->enum('propertyType', ['apartment','condominium', 'dormitory', 'studio', 'bedspace', 'house']);
            $table->longText('propertyDescription')->nullable();
            
            //step2
            $table->string('address');  
            $table->decimal('latitude', 10, 7);   // or double
            $table->decimal('longitude', 10, 7);  // or double
            
            //step3
            $table->json('propertyFeatures');

            //step4
            $table->json('propertyRestrictions');
            
            //step5
            $table->enum('tenantGender', ['male','female', 'all']);
            $table->enum('tenantType', ['employee', 'student', 'family', 'groups', 'single', 'couple', 'all']);
            
            //step6
            $table->json('images');
            
            //step7
            $table->longText('terms');
            
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
