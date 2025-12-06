<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('social_medias', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Facebook, Twitter etc.
            $table->string('url');
            $table->string('icon')->nullable(); // FontAwesome class or internal identifier
            $table->string('color')->nullable(); // Tailwind class or Hex
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_medias');
    }
};
