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
       Schema::table('users', function (Blueprint $table) {
        $table->unsignedInteger('racha_dias')->default(0);
        $table->date('ultimo_acceso')->nullable();

        // Metas anti-procrastinación
        $table->unsignedInteger('meta_tareas_dia')->default(3);      // Cuántas tareas diarias se compromete a hacer
        $table->unsignedInteger('tareas_completadas_hoy')->default(0); // Progreso del día
        $table->boolean('modo_examen')->default(false); 
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
