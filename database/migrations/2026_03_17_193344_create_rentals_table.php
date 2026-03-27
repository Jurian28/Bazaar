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
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('advertisement_id')
                ->unique()
                ->constrained()
                ->onDelete('cascade');
            $table->decimal('price_per_day', 10, 2);
            $table->decimal('deposit', 10, 2)->default(0); // added deposit
            $table->unsignedTinyInteger('max_rentals')->default(4); // added max_rentals
            $table->date('start_date');
            $table->date('end_date');
            $table->string('photo_returned')->nullable();
            $table->decimal('wear_level', 5, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
