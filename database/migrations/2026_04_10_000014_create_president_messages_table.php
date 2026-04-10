<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('president_messages', function (Blueprint $table) {
            $table->id();
            $table->string('president_name');
            $table->string('president_title');
            $table->text('message');
            $table->string('signature_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('president_messages');
    }
};
