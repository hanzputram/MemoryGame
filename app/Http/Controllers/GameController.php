<?php

namespace App\Http\Controllers;

use App\Models\GameScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GameController extends Controller
{
    // ========== LANDING PAGE ==========
    public function landing()
    {
        $bestEasy = GameScore::with('user')
            ->where('level', 'easy')
            ->orderByDesc('points')
            ->orderBy('time_seconds')
            ->limit(5)
            ->get();

        $bestMedium = GameScore::with('user')
            ->where('level', 'medium')
            ->orderByDesc('points')
            ->orderBy('time_seconds')
            ->limit(5)
            ->get();

        $bestHard = GameScore::with('user')
            ->where('level', 'hard')
            ->orderByDesc('points')
            ->orderBy('time_seconds')
            ->limit(5)
            ->get();

        return view('memory-landing', [
            'bestEasy'   => $bestEasy,
            'bestMedium' => $bestMedium,
            'bestHard'   => $bestHard,
        ]);
    }

    // ========== HALAMAN GAME ==========
    public function index(string $level)
    {
        $totalCards = match ($level) {
            'easy'   => 20,
            'medium' => 30,
            'hard'   => 50,
            default  => 20,
        };

        $cards = $this->generateCards($totalCards);

        return view('memory', [
            'level'      => $level,
            'cards'      => $cards,
            'totalCards' => $totalCards,
        ]);
    }

    private function generateCards(int $totalCards): array
    {
        $pairCount = (int) ($totalCards / 2);
        $values    = range(1, $pairCount);

        $deck = [];
        foreach ($values as $v) {
            $deck[] = $v;
            $deck[] = $v;
        }

        shuffle($deck);

        return $deck;
    }

    // ========== FINISH GAME ==========
    public function finish(Request $request)
    {
        try {
            $data = $request->validate([
                'elapsed_seconds' => 'required|numeric|min:0',
                'level'           => 'required|in:easy,medium,hard',
            ]);

            $level   = $data['level'];
            $elapsed = (float) $data['elapsed_seconds'];

            // Formula poin
            $base = match ($level) {
                'easy'   => 1000,
                'medium' => 2000,
                'hard'   => 3000,
                default  => 1000,
            };

            $points = max(0, (int) round($base - ($elapsed * 10)));

            // NOTE:
            // Kalau kamu mau WAJIB login → pastikan route pakai middleware('auth')
            // dan biarkan user_id TIDAK nullable di DB.
            // Kalau mau boleh guest, buat user_id nullable di migration.
            $score = GameScore::create([
                'user_id'      => Auth::id(),   // bisa null kalau guest + kolom nullable
                'level'        => $level,
                'time_seconds' => $elapsed,
                'points'       => $points,
            ]);

            return response()->json([
                'success'         => true,
                'level'           => $level,
                'elapsed_seconds' => $elapsed,
                'points'          => $points,
                'saved_id'        => $score->id,
            ]);
        } catch (\Throwable $e) {
            // log error ke storage/logs/laravel.log
            Log::error('MemoryGame finish error', [
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
                'user_id' => Auth::id(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
