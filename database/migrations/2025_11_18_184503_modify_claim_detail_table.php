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
        Schema::table('claim_detail', function(Blueprint $table){
            $table->text('total_ot_hrs')->nullable()->after('total_ot');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('claim_detail', function(Blueprint $table){
            $table->dropColumn(['total_ot_hrs']);
        });
    }
};