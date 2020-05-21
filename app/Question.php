<?php
declare(strict_types=1);

namespace ConorSmith\Palgebra;

final class Question
{
    public static function interpolateText(string $playerId, array $questions, string $questionId): string
    {
        $questionText = $questions[$questionId]['text'];

        $playersByVariable = (new PlayerRepository(config("game.variables")))->byVariable($playerId);

        foreach ($playersByVariable as $variable => $player) {
            $questionText = str_replace("{{$variable}}", $player->name, $questionText);
        }

        return $questionText;
    }
}
