<?php
declare(strict_types=1);

namespace ConorSmith\Palgebra\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

final class GetDashboard
{
    public function __invoke(Request $request)
    {
        $games = DB::select("SELECT * FROM games ORDER BY created_at DESC");

        foreach ($games as $game) {
            $players = DB::select("SELECT * FROM players WHERE game_id = ?", [$game->id]);

            $game->players = count($players);
        }

        return view("dashboard", [
            'games' => $games,
        ]);
    }
}
