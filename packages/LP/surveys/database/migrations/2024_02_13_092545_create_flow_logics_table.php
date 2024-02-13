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
        Schema::create('flow_logics', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('current_module_id')->unsigned()->nullable();
            $table->foreign('current_module_id')->references('id')->on('modules')->onDelete('cascade');

            $table->bigInteger('next_module_id')->unsigned()->nullable();
            $table->foreign('next_module_id')->references('id')->on('modules')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flow_logics');
    }
};
