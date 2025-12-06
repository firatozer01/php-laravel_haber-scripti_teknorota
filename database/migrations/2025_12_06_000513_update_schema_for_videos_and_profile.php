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
        // Change Question content to LONGTEXT
        Schema::table('questions', function (Blueprint $table) {
            $table->longText('content')->change();
        });

        // Add Avatar to Users
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable()->after('email');
        });

        // Create Videos Table
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('youtube_id');
            $table->string('image')->nullable(); // Custom thumbnail
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->text('content')->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('avatar');
        });

        Schema::dropIfExists('videos');
    }
};
