<?php

namespace App\Utils;
use Illuminate\Support\Str;
class Utils
{
    public static function uuid(): string
    {
        return (string) Str::uuid();
    }
}
