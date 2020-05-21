<?php
declare(strict_types=1);

namespace ConorSmith\Palgebra\Http\Controllers;

use Illuminate\Http\Request;

final class GetStart
{
    public function __invoke(Request $request)
    {
        return view('start');
    }
}
