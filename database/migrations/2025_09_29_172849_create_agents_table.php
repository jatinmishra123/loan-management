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
    Schema::create('agents', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('bank_id');
        $table->unsignedBigInteger('branch_id');
        $table->string('designation');
        $table->string('name');
        $table->string('email')->unique();
        $table->string('password');
        $table->string('image')->nullable();
        $table->boolean('is_active')->default(true);
        $table->timestamps();

        $table->foreign('bank_id')->references('id')->on('banks')->onDelete('cascade');
        $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
    });
}

    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
