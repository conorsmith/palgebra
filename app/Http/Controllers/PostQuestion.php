<?php
declare(strict_types=1);

namespace ConorSmith\Palgebra\Http\Controllers;

use Carbon\Carbon;
use ConorSmith\Palgebra\PlayerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

final class PostQuestion
{
    public function __invoke(Request $request)
    {
        $playerId = $request->route("playerId");
        $questionId = $request->route("questionId");

        $game = DB::selectOne("SELECT * FROM games WHERE is_active = 1");

        if (is_null($game)) {
            session()->flash("error", "There are no active games.");
            return redirect("/");
        }

        $startTime = new Carbon($game->started_at, "Europe/Dublin");

        $endTime = $startTime->clone();
        $endTime->addSeconds(intval(config("game.time")));

        if ($endTime->lessThanOrEqualTo(Carbon::now("Europe/Dublin"))) {
            session()->flash("error", "Your time is up");
            return redirect("/{$playerId}/results");
        }

        $answer = DB::selectOne("SELECT * FROM answers WHERE player_id = ? AND question = ?", [
            $playerId,
            $questionId,
        ]);

        if (!is_null($answer)) {
            session()->flash("questionAnswered", true);
            return redirect("/{$playerId}/question/{$questionId}");
        }

        if (is_null($request->input("answer"))) {
            session()->flash("error", "Your answer cannot be blank");
            return redirect("/{$playerId}/question/{$questionId}");
        }

        $givenAnswer = intval($request->input("answer"));

        $questions = config('game.questions');

        $correctAnswer = $questions[$questionId]['function'](
            $this->findVariableValues($playerId)
        );

        $formattedCorrectAnswer = number_format($correctAnswer);

        if ($givenAnswer === $correctAnswer) {
            session()->flash("correct", "The answer was {$formattedCorrectAnswer}");
        } else {
            session()->flash("incorrect", "The answer was {$formattedCorrectAnswer}");
        }

        DB::table("answers")->insert([
            'id'             => Uuid::uuid4(),
            'game_id'        => $game->id,
            'player_id'      => $playerId,
            'question'       => intval($questionId),
            'given_answer'   => $givenAnswer,
            'correct_answer' => $correctAnswer,
            'is_correct'     => $givenAnswer === $correctAnswer,
            'created_at'     => Carbon::now("Europe/Dublin"),
        ]);

        $nextQuestionId = strval(intval($questionId) + 1);

        if (array_key_exists($nextQuestionId, $questions)) {
            return redirect("/{$playerId}/question/{$nextQuestionId}");
        } else {
            return redirect("/{$playerId}/results");
        }
    }

    private function findVariableValues(string $playerId): array
    {
        $playersByVariable = (new PlayerRepository(config("game.variables")))->byVariable($playerId);

        $valuesByVariable = [];

        foreach ($playersByVariable as $variable => $player) {
            $valuesByVariable[$variable] = $player->number;
        }

        return $valuesByVariable;
    }
}
