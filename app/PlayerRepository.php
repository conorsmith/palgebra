<?php
declare(strict_types=1);

namespace ConorSmith\Palgebra;

use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class PlayerRepository
{
    /** @var array */
    private $variables;

    public function __construct(array $variables)
    {
        $this->variables = $variables;
    }

    public function byVariable(string $playerId): array
    {
        $game = DB::selectOne("SELECT * FROM games WHERE is_active = 1");

        if (is_null($game)) {
            throw new NotFoundHttpException;
        }

        $players = DB::select(
            "SELECT * FROM players WHERE game_id = ? ORDER BY created_at",
            [$game->id]
        );

        $playerOffset = 0;

        foreach ($players as $i => $player) {
            if ($player->id === $playerId) {
                $playerOffset = $i;
            }
        }

        $playersByVariable = [];
        $position = $playerOffset;

        foreach ($this->variables as $variable) {
            $playersByVariable[$variable] = $players[$position];
            if ($position === count($players) - 1) {
                $position = 0;
            } else {
                $position++;
            }
        }

        return $playersByVariable;
    }
}
