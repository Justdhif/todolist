<?php

namespace App\Helpers;

class ColorHelper
{
    public static function isLightColor($color)
    {
        $color = str_replace('#', '', $color);
        $r = hexdec(substr($color, 0, 2));
        $g = hexdec(substr($color, 2, 2));
        $b = hexdec(substr($color, 4, 2));

        // Formula untuk memeriksa kecerahan
        $brightness = (299 * $r + 587 * $g + 114 * $b) / 1000;

        return $brightness > 155; // Jika brightness lebih besar dari 155, warna terang
    }
}
