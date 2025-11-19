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
        Schema::create('claim_files', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('claim_id')->unsigned();
            $table->uuid('file_uuid')->unique();
            $table->string('type');
            $table->string('file_path');
            $table->string('file_name');
            $table->string('file_ext');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('claim_files');
    }
};