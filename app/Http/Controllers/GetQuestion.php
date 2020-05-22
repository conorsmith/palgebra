<?php
declare(strict_types=1);

namespace ConorSmith\Palgebra\Http\Controllers;

use Carbon\Carbon;
use ConorSmith\Palgebra\Countdown;
use ConorSmith\Palgebra\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class GetQuestion
{
    public function __invoke(Request $request)
    {
        $playerId = $request->route("playerId");
        $questionId = $request->route("questionId");

        $questions = config('game.questions');

        if (!array_key_exists($questionId, $questions)) {
            throw new NotFoundHttpException;
        }

        $player = DB::selectOne("SELECT * FROM players WHERE id = ?", [$playerId]);

        if (is_null($player) ) {
            session()->flash("error", "That player has been removed");
            return redirect("/");
        }

        $game = DB::selectOne("SELECT * FROM games WHERE id = ?", [$player->game_id]);

        if (is_null($game)) {
            session()->flash("error", "There are no active games");
            return redirect("/");
        }

        if ($player->game_id !== $game->id) {
            session()->flash("error", "Your game is no longer active");
            return redirect("/");
        }

        if (!$game->has_started) {
            session()->flash("error", "The game has yet to begin!");
            return redirect("/{$playerId}/waiting-room");
        }

        if ($questionId > count($questions)) {
            return redirect("/{$playerId}/results");
        }

        $playerName = $player->name;
        $playerNumber = $player->number;

        $questionText = Question::interpolateText($playerId, $questions, $questionId);

        $lastQuestionId = strval(array_reduce(array_keys($questions), function ($carry, $input) {
            if (intval($input) > $carry) {
                return intval($input);
            } else {
                return $carry;
            }
        }, 0));

        $timeRemainingViewModel = (new Countdown)->getTimeRemaining($game->started_at);

        return view('question', [
            'hideHeading'    => true,
            'playerId'       => $playerId,
            'questionId'     => $questionId,
            'question'       => $questionText,
            'name'           => $playerName,
            'number'         => $playerNumber,
            'isLastQuestion' => $questionId === $lastQuestionId,
            'timeRemaining'  => $timeRemainingViewModel,
        ]);
    }
}
