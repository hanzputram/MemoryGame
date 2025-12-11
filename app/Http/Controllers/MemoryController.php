<?php

namespace App\Http\Controllers;

use App\Models\GameScore;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MemoryController extends Controller
{
    public function finish(Request $request)
    {
        // Validasi data dari fetch (JSON)
        $data = $request->validate([
            'elapsed_seconds' => 'required|numeric',
            'level'           => 'required|string',
        ]);

        $elapsed = (float) $data['elapsed_seconds'];
        $level   = (string) $data['level'];

        // Hitung points
        $points = $this->calculatePoints($elapsed, $level);

        // Simpan ke database
        $score = GameScore::create([
            'user_id'      => Auth::id(),   // null kalau user belum login
            'level'        => $level,
            'time_seconds' => $elapsed,
            'points'       => $points,
        ]);

        return response()->json([
            'success'         => true,
            'level'           => $score->level,
            'elapsed_seconds' => $score->time_seconds,
            'points'          => $score->points,
        ]);
    }

    /**
     * Hitung points berdasarkan waktu & level.
     * Silakan ubah rumus sesuai keinginanmu.
     */
    private function calculatePoints(float $elapsedSeconds, string $level): int
    {
        switch ($level) {
            case 'easy':
                $base = 1000;
                break;
            case 'medium':
                $base = 2000;
                break;
            case 'hard':
                $base = 3000;
                break;
            default:
                $base = 1000;
        }

        // Semakin lama, poin berkurang (10 poin per detik)
        $penalty = (int) round($elapsedSeconds * 10);

        return max($base - $penalty, 0);
    }
}
