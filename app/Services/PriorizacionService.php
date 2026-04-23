<?php
namespace App\Services;

use App\Models\Tarea;
use Carbon\Carbon;

class PriorizacionService
{
    /**
     * FÓRMULA PRINCIPAL
     * Score = (Urgencia × 40%) + (Peso × 35%) + (Dificultad × 15%) + (Tipo × 10%)
     * Resultado: número entre 0 y 100
     */
    public function calcularScore(Tarea $tarea): float
    {
        $urgencia    = $this->calcularUrgencia($tarea->fecha_limite);
        $pesoScore   = min(100, $tarea->peso);
        $difScore    = (($tarea->dificultad - 1) / 4) * 100;
        $tipoScore   = $this->multiplicadorTipo($tarea->tipo);

        $score = ($urgencia * 0.40)
               + ($pesoScore * 0.35)
               + ($difScore  * 0.15)
               + ($tipoScore * 0.10);

        return round($score, 2);
    }

    /**
     * Urgencia basada en días restantes.
     * 0 días  → 100 puntos
     * 30 días → 0 puntos
     */
    private function calcularUrgencia(Carbon $fechaLimite): float
    {
        $dias = max(0, now()->diffInDays($fechaLimite, false));
        return max(0, 100 - ($dias / 30) * 100);
    }

    /**
     * Cada tipo de tarea tiene un peso base diferente.
     * Los exámenes siempre son más urgentes.
     */
    private function multiplicadorTipo(string $tipo): float
    {
        return match($tipo) {
            'examen'       => 100,
            'proyecto'     => 80,
            'presentacion' => 70,
            'tarea'        => 50,
            'lectura'      => 30,
            default        => 50,
        };
    }

    /**
     * Recalcula y guarda el score de todas las tareas pendientes de un usuario.
     * Se llama al guardar una tarea nueva o cuando cambia la fecha.
     */
    public function recalcularTodas(int $userId): void
    {
        Tarea::where('user_id', $userId)
->where('status', '!=', 'completada')
            ->each(function (Tarea $tarea) {
                $tarea->update(['score' => $this->calcularScore($tarea)]);
            });
    }

    /**
     * Devuelve el nivel de urgencia como texto para las vistas.
     */
    public function getNivel(float $score): string
    {
        if ($score >= 70) return 'urgente';
        if ($score >= 40) return 'proximo';
        return 'tranquilo';
    }
}