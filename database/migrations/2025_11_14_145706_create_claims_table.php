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
        Schema::create('claims', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no')->unique();
            $table->bigInteger('staff_id')->unsigned();
            $table->string('type')->nullable();
            $table->date('duty_date')->nullable();
            
            $table->time('duty_start_time')->nullable();
            $table->time('duty_end_time')->nullable();
            $table->string('work_location')->nullable();
            
            $table->time('travel_start_time')->nullable();
            $table->time('travel_end_time')->nullable();
            $table->string('travel_origin')->nullable();
            $table->string('travel_destination')->nullable();
            $table->text('travel_purpose')->nullable();
            
            $table->string('status')->default('draft'); // draft, pending, approved, rejected, processed, paid

            $table->bigInteger('approver_id')->unsigned()->nullable();
            $table->dateTime('approved_at')->nullable();
            
            $table->dateTime('rejected_at')->nullable();
            $table->text('rejection_reason')->nullable();

            $table->bigInteger('proccessor_id')->unsigned()->nullable();
            $table->dateTime('processed_at')->nullable();

            $table->bigInteger('payer_id')->unsigned()->nullable();
            $table->dateTime('paid_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('claims');
    }
};