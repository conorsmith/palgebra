<?php
declare(strict_types=1);

namespace ConorSmith\Palgebra\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

final class PostRemovePlayer
{
    public function __invoke(Request $request)
    {
        $gameId = $request->route("gameId");
        $playerId = $request->route("playerId");

        DB::table("players")->delete($playerId);

        DB::table("answers")->delete([
            'player_id' => $playerId,
        ]);

        return redirect("/game/{$gameId}");
    }
}
