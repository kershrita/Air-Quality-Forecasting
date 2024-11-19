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
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->dateTime('from_date');
            $table->foreignId('state_id')->constrained()->onDelete("cascade");
            $table->float('pm25')->nullable();
            $table->float('pm10')->nullable();
            $table->float('No')->nullable();
            $table->float('No2')->nullable();
            $table->float('NOx')->nullable();
            $table->float('NH3')->nullable();
            $table->float('SO2')->nullable();
            $table->float('CO')->nullable();
            $table->float('AT')->nullable();
            $table->float('Temp')->nullable();
            $table->float('CO2')->nullable();
            $table->float('CH4')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
