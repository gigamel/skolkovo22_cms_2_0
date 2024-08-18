<?php

declare(strict_types=1);

namespace App\Util;

final class Dumper
{
    /**
     * @param mixed $var
     *
     * @return void
     */
    public static function dump(mixed $var, bool $die = false): void
    {
        echo sprintf(
           '<pre style="padding:15px;border:1px solid #c0f;">%s</pre>',
            var_export($var, true)
        );

        if ($die) {
            die();
        }
    }
}
