<?php

namespace App\Services;

use App\Models\Tarea;
use Carbon\Carbon;

class PriorizacionService
{
    public function calcularScore(Tarea $tarea): float
    {
        $urgencia  = $tarea->due_date ? $this->calcularUrgencia($tarea->due_date) : 0;
        $tipoScore = $this->multiplicadorTipo($tarea->tipo);
        $prioScore = match($tarea->priority) {
            'alta'  => 100,
            'media' => 50,
            'baja'  => 20,
            default => 50,
        };

        $score = ($urgencia  * 0.50)
               + ($prioScore * 0.35)
               + ($tipoScore * 0.15);

        return round($score, 2);
    }

    private function calcularUrgencia(Carbon $fechaLimite): float
    {
        $dias = max(0, now()->diffInDays($fechaLimite, false));
        return max(0, 100 - ($dias / 30) * 100);
    }

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

    public function recalcularTodas(int $userId): void
    {
        Tarea::where('user_id', $userId)
            ->where('status', '!=', 'completada')
            ->each(function (Tarea $tarea) {
                $tarea->update(['score' => $this->calcularScore($tarea)]);
            });
    }

    public function getNivel(float $score): string
    {
        if ($score >= 70) return 'urgente';
        if ($score >= 40) return 'proximo';
        return 'tranquilo';
    }
}