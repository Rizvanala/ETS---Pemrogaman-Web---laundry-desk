<?php

namespace App\Support;

class Money
{
    public static function rupiah($value): string
    {
        return 'Rp ' . number_format((float) $value, 0, ',', '.');
    }
}
