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
    Schema::create('tareas', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->cascadeOnDelete();
      $table->string('title');
      $table->string('subject')->nullable();
      $table->text('description')->nullable();
      $table->integer('score')->default(0);
      $table->date('due_date')->nullable();
      $table->enum('tipo', ['examen','proyecto','tarea','presentacion','lectura']);
      $table->enum('priority', ['baja', 'media', 'alta'])->default('media');
      $table->enum('status', ['pendiente', 'en_progreso', 'completada'])->default('pendiente');
      $table->integer('estimated_minutes')->nullable();
      $table->timestamps();

      // $table->id();
      //   $table->foreignId('user_id')->constrained()->onDelete('cascade');
      //   $table->string('nombre');
      //   $table->string('materia');
      //   $table->date('fecha_limite');
      //   $table->integer('score')->default(0);
      //   $table->unsignedTinyInteger('dificultad');
      //   $table->enum('tipo', ['examen','proyecto','tarea','presentacion','lectura']);
      //   $table->text('notas')->nullable();
      //   $table->boolean('completada')->default(false);
      //   $table->timestamp('completada_en')->nullable();
      //   $table->timestamps();
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
