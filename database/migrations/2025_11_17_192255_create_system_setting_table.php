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
        Schema::create('system_setting', function (Blueprint $table) {
            $table->id();
            $table->integer('submit_day_allow')->nullable();
            $table->integer('date_salary')->nullable();

            $table->time('working_start')->nullable();
            $table->time('working_end')->nullable();

            $table->decimal('meal_allowance')->nullable();

            $table->decimal('ot_rate')->nullable();
            $table->decimal('ot_weekend_rate')->nullable();
            $table->decimal('ot_holiday_rate')->nullable();

            $table->integer('first_ot_meal_hrs')->nullable();
            $table->time('first_ot_meal_time')->nullable();
            $table->integer('extra_ot_meal_hrs')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_setting');
    }
};