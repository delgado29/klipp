<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('employees', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('business_id'); // Relación con el negocio
        $table->string('name');
        $table->string('email')->unique();
        $table->string('phone')->nullable();
        $table->string('position')->nullable();
        $table->timestamps();

        // Clave foránea
        $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
