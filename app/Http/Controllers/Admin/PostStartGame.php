<?php
declare(strict_types=1);

namespace ConorSmith\Palgebra\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class PostStartGame
{
    public function __invoke(Request $request)
    {
        $gameId = $request->route("gameId");

        $game = DB::selectOne("SELECT * FROM games WHERE id = ?", [$gameId]);

        if (is_null($game)) {
            throw new NotFoundHttpException;
        }

        if (!$game->has_started) {
            DB::table("games")->where([
                'id' => $gameId,
            ])->update([
                'has_started' => true,
                'started_at' => Carbon::now("Europe/Dublin"),
            ]);
        }

        return redirect("/game/{$gameId}");
    }
}
