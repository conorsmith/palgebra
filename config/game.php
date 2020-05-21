<?php
declare(strict_types=1);

return [
    'variables' => [
        "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t",
    ],
    'questions' => [
        "1" => [
            'text' => "x = {b} + 2",
            'function' => function (array $variables): int
            {
                return $variables['b'] + 2;
            }
        ],
        "2" => [
            'text' => "x = 3&sdot;{c}",
            'function' => function (array $variables): int
            {
                return 3 * $variables['c'];
            }
        ],
        "3" => [
            'text' => "x = {d} + {e}",
            'function' => function (array $variables): int
            {
                return $variables['d'] + $variables['e'];
            }
        ],
        "4" => [
            'text' => "x = {f} - {g} + 10",
            'function' => function (array $variables): int
            {
                return $variables['f'] - $variables['g'] + 10;
            }
        ],
        "5" => [
            'text' => "x = 5&sdot;{h} + 2&sdot;{i}",
            'function' => function (array $variables): int
            {
                return (5 * $variables['h']) + (2 * $variables['i']);
            }
        ],
        "6" => [
            'text' => "x = {j} &times; {k}",
            'function' => function (array $variables): int
            {
                return $variables['j'] * $variables['k'];
            }
        ],
        "7" => [
            'text' => "x = 2&sdot;{l} &times; ({a} + {m})",
            'function' => function (array $variables): int
            {
                return 2 * $variables['l'] * ($variables['a'] + $variables['m']);
            }
        ],
        "8" => [
            'text' => "x = 69&sdot;{q} &divide; (3 &times; (20 + 3))",
            'function' => function (array $variables): int
            {
                return (69 * $variables['q']) / (3 * (20 + 3));
            }
        ],
        "9" => [
            'text' => "x + 3 = {o} + {r}",
            'function' => function (array $variables): int
            {
                $leftHandSide = 3;

                return $variables['o'] + $variables['r'] - $leftHandSide;
            }
        ],
        "10" => [
            'text' => "x + {p} - 2&sdot;{n} = 4&sdot;{s}&sup2; - 9&sdot;{t}&sup2;",
            'function' => function (array $variables): int
            {
                $leftHandSide = $variables['p']
                    - (2 * $variables['n']);

                return (4 * $variables['s'] * $variables['s'])
                    - (9 * $variables['t'] * $variables['t'])
                    - $leftHandSide;
            }
        ],
    ],
];
