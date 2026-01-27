<?php

namespace App\Actions;

class GenerateColorPaletteAction
{
    public static function make(?int $seed = null): array
    {
        if ($seed !== null) {
            mt_srand($seed);
        }

        $baseHue = mt_rand(0, 360);

        return [
            // Header / Footer – forte
            'color_primary' => self::hslToHex(
                $baseHue,
                85,
                45
            ),

            // Background card – carta
            'color_secondary' => self::hslToHex(
                $baseHue,
                30,
                98
            ),

            // Label – molto leggibili
            'color_label' => self::hslToHex(
                self::shiftHue($baseHue, -20),
                55,
                25
            ),

            // Accent – super evidente
            'color_accent' => self::hslToHex(
                self::shiftHue($baseHue, +20),
                95,
                42
            ),
        ];
    }

    private static function shiftHue(int $hue, int $shift): int
    {
        return ($hue + $shift + 360) % 360;
    }

    private static function hslToHex(int $h, int $s, int $l): string
    {
        $s /= 100;
        $l /= 100;

        $c = (1 - abs(2 * $l - 1)) * $s;
        $x = $c * (1 - abs(fmod($h / 60, 2) - 1));
        $m = $l - $c / 2;

        [$r, $g, $b] = match (true) {
            $h < 60  => [$c, $x, 0],
            $h < 120 => [$x, $c, 0],
            $h < 180 => [0, $c, $x],
            $h < 240 => [0, $x, $c],
            $h < 300 => [$x, 0, $c],
            default  => [$c, 0, $x],
        };

        return sprintf(
            '#%02X%02X%02X',
            ($r + $m) * 255,
            ($g + $m) * 255,
            ($b + $m) * 255
        );
    }
}
