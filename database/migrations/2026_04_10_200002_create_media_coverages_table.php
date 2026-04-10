<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('media_coverages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('source_name');               // e.g. "Times of India"
            $table->string('source_url')->nullable();    // link to article
            $table->string('youtube_url')->nullable();   // YouTube video if any
            $table->string('cover_image_url')->nullable(); // uploaded or external
            $table->date('published_date')->nullable();
            $table->string('category')->default('news'); // news | tv | online | magazine
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('media_coverages'); }
};
