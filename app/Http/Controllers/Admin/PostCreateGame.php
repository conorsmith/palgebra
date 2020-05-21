<?php
declare(strict_types=1);

namespace ConorSmith\Palgebra\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

final class PostCreateGame
{
    public function __invoke(Request $request)
    {
        $gameId = Uuid::uuid4();

        DB::table("games")->insert([
            'id'          => $gameId,
            'has_started' => false,
            'started_at'  => null,
            'is_active'   => false,
            'created_at'  => Carbon::now("Europe/Dublin"),
        ]);

        return redirect("/dashboard");
    }
}
