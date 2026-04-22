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
    Schema::create('tasks', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->cascadeOnDelete();
      $table->string('title');
      $table->string('subject')->nullable();
      $table->text('description')->nullable();
      $table->date('due_date')->nullable();
      $table->enum('priority', ['baja', 'media', 'alta'])->default('media');
      $table->enum('status', ['pendiente', 'en_progreso', 'completada'])->default('pendiente');
      $table->integer('estimated_minutes')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('tasks');
  }
};
