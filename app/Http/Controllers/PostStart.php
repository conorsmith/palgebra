<?php
declare(strict_types=1);

namespace ConorSmith\Palgebra\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

final class PostStart
{
    public function __invoke(Request $request)
    {
        $name = trim($request->input("name"));

        if (is_null($name) || $name === "") {
            session()->flash("error", "Your name cannot be blank");
            return redirect("/");
        }

        $game = DB::selectOne("SELECT * FROM games WHERE is_active = 1");

        if (is_null($game)) {
            session()->flash("error", "There are no active games");
            return redirect("/");
        }

        if ($game->has_started) {
            session()->flash("error", "The game has already started");
            return redirect("/");
        }

        $playerWithName = DB::selectOne("SELECT * FROM players WHERE game_id = ? AND name = ?", [
            $game->id,
            $name,
        ]);

        if (!is_null($playerWithName)) {
            session()->flash("error", "Another player has chosen the name '{$name}'");
            return redirect("/");
        }

        $players = DB::select("SELECT * FROM players WHERE game_id = ?", [$game->id]);

        $allocatedNumbers = array_map(function ($player) {
            return $player->number;
        }, $players);

        $playerId = Uuid::uuid4();

        $chooseHighNumber = mt_rand(1, 100) > 90;
        if ($chooseHighNumber) {
            $chooseReallyHighNumber = mt_rand(1, 100) > 60;
            if ($chooseReallyHighNumber) {
                $number = mt_rand(100, 999);
            } else {
                $number = mt_rand(21, 99);
            }
        } else {
            $attempts = 0;
            do {
                $chooseTimesTableNumber = mt_rand(1, 100) > 20;
                if ($chooseTimesTableNumber) {
                    $number = mt_rand(1, 12);
                } else {
                    $number = mt_rand(13, 20);
                }
                $attempts++;
            } while (in_array($number, $allocatedNumbers) && $attempts < 3);
        }

        DB::table("players")->insert([
            'id'         => $playerId->toString(),
            'game_id'    => $game->id,
            'name'       => $name,
            'number'     => $number,
            'created_at' => Carbon::now("Europe/Dublin")->format("Y-m-d H:i:s"),
        ]);

        return redirect("{$playerId}/waiting-room");
    }
}
