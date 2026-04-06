<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('advertisement_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('advertisement_id')->constrained('advertisements')->onDelete('cascade');
            $table->foreignId('linked_advertisement_id')->constrained('advertisements')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['advertisement_id', 'linked_advertisement_id'], 'ad_links_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('advertisement_links');
    }
};
