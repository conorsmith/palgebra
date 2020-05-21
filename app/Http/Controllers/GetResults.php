<?php
declare(strict_types=1);

namespace ConorSmith\Palgebra\Http\Controllers;

use ConorSmith\Palgebra\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class GetResults
{
    public function __invoke(Request $request)
    {
        $playerId = $request->route("playerId");

        $player = DB::selectOne("SELECT * FROM players WHERE id = ?", [$playerId]);

        if (is_null($player)) {
            throw new NotFoundHttpException;
        }

        $game = DB::selectOne("SELECT * FROM games WHERE id = ?", [$player->game_id]);

        if (!$game->has_started) {
            session()->flash("error", "The game has yet to begin!");
            return redirect("/{$playerId}/waiting-room");
        }

        $answers = DB::select("SELECT * FROM answers WHERE player_id = ? ORDER BY question", [$playerId]);

        $questions = config('game.questions');

        foreach ($answers as $answer) {
            $answer->question_text = Question::interpolateText($playerId, $questions, strval($answer->question));
        }

        return view('results', [
            'name' => $player->name,
            'number' => $player->number,
            'answers' => $answers,
            'points' => array_reduce($answers, function ($carry, $answer) {
                return $carry + ($answer->is_correct ? 1 : 0);
            }, 0),
        ]);
    }
}
