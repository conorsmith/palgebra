<?php
declare(strict_types=1);

namespace ConorSmith\Palgebra\Http\Controllers\Admin;

use ConorSmith\Palgebra\Countdown;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class GetGame
{
    public function __invoke(Request $request)
    {
        $gameId = $request->route("gameId");

        $game = DB::selectOne("SELECT * FROM games WHERE id = ?", [$gameId]);

        if (is_null($game)) {
            throw new NotFoundHttpException;
        }

        $players = DB::select("SELECT * FROM players WHERE game_id = ? ORDER BY created_at", [
            $gameId,
        ]);

        foreach ($players as $player) {
            $answers = DB::select("SELECT * FROM answers WHERE player_id = ?", [
                $player->id,
            ]);

            $player->questions_answered = count($answers);
            $player->points = array_reduce($answers, function ($carry, $answer) {
                return $carry + ($answer->is_correct ? 1 : 0);
            }, 0);
        }

        $timeRemainingViewModel = (new Countdown)->getTimeRemaining($game->started_at);

        return view('game', [
            'hideHeading' => true,
            'players' => $players,
            'game' => $game,
            'timeRemaining' => $timeRemainingViewModel,
        ]);
    }
}
