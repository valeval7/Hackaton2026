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
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('nombre');
        $table->string('materia');
        $table->date('fecha_limite');
        $table->unsignedTinyInteger('porcentaje');
        $table->unsignedTinyInteger('dificultad');
        $table->enum('tipo', ['examen','proyecto','tarea','presentacion','lectura']);
        $table->text('notas')->nullable();
        $table->boolean('completada')->default(false);
        $table->timestamp('completada_en')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
