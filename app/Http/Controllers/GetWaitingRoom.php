<?php
declare(strict_types=1);

namespace ConorSmith\Palgebra\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

final class GetWaitingRoom
{
    public function __invoke(Request $request)
    {
        $playerId = $request->route("playerId");

        $player = DB::selectOne("SELECT * FROM players WHERE id = ?", [$playerId]);

        if (is_null($player)) {
            session()->flash("error", "That player has been removed");
            return redirect("/");
        }

        $game = DB::selectOne("SELECT * FROM games WHERE id = ?", [$player->game_id]);

        if ($player->game_id !== $game->id) {
            session()->flash("error", "Your game is no longer active");
            return redirect("/");
        }

        if ($game->has_started) {
            return redirect("/{$playerId}/question/1");
        }

        return view('waiting', [
            'playerId' => $playerId,
            'name' => $player->name,
            'number' => $player->number,
            'colour' => $this->getColour($playerId),
        ]);
    }

    private function getColour(string $playerId): array
    {
        $playerId = Uuid::fromString($playerId);

        $colours = config("colors");

        $colourKey = crc32($playerId->toString()) % count($colours);

        $colour = $colours[$colourKey];

        return [
            'label' => str_replace(" ", "&nbsp;", ucfirst($colour)),
            'value' => str_replace(" ", "", strtolower($colour)),
        ];
    }
}
