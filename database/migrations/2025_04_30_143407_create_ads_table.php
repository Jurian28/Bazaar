<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->decimal('price_per_day', 8, 2);
            $table->string('location');
            $table->date('expires_at');
            $table->string('photo_path');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('ads');
    }
};
