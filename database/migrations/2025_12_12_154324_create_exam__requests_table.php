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
        Schema::create('exam__requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment')->constrained()->onDelete('cascade');
            $table->string('exam_type')->nullable();
            $table->string('archive')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam__requests');
    }
};
