<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('principles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('icon')->default('fa-star');           // FontAwesome class e.g. fa-dove
            $table->string('color_theme')->default('orange');     // orange | purple | emerald | blue | teal | red
            $table->string('link_url')->nullable();               // optional "Learn More" URL
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('principles');
    }
};
