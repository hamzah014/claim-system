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
        Schema::create('claim_detail', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('claim_id')->unsigned();
            
            $table->decimal('normal_rate')->nullable();
            $table->decimal('weekend_rate')->nullable();
            $table->decimal('holiday_rate')->nullable();
            $table->decimal('meal_rate')->nullable();
        
            $table->decimal('total_ot')->nullable();
            $table->decimal('total_allowance')->nullable();
            $table->decimal('overall')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('claim_detail');
    }
};