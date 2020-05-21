<?php
declare(strict_types=1);

namespace ConorSmith\Palgebra\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

final class PostActivateGame
{
    public function __invoke(Request $request)
    {
        $gameId = $request->route("gameId");

        DB::table("games")->update([
            'is_active' => false,
        ]);

        DB::table("games")->where([
            'id' => $gameId,
        ])->update([
            'is_active' => true,
        ]);

        return redirect("/dashboard");
    }
}
