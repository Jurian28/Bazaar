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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // wie schrijft de review
            $table->foreignId('advertisement_id')->constrained()->onDelete('cascade'); // voor welk product
            $table->foreignId('company_id')->nullable()->constrained()->onDelete('cascade'); // review van adverteerder (optioneel)
            $table->tinyInteger('rating'); // 1-5 sterren
            $table->text('comment'); // tekst
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
