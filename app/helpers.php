<?php

use Illuminate\Support\Facades\App;

if (! function_exists('bd_digits')) {
    /**
     * Translate ASCII digits (0-9) to Bangla Unicode digits (০-৯),
     * leaving grouping/separator characters untouched.
     */
    function bd_digits(string $text): string
    {
        $map = [
            '0' => '০', '1' => '১', '2' => '২', '3' => '৩', '4' => '৪',
            '5' => '৫', '6' => '৬', '7' => '৭', '8' => '৮', '9' => '৯',
        ];

        return strtr($text, $map);
    }
}

if (! function_exists('format_amount')) {
    /**
     * Format a number for display, using Bangla digits when the app
     * is running in the Bangla locale. Display-only (never for input values).
     */
    function format_amount(int|float $amount, int $decimals = 0): string
    {
        $formatted = number_format($amount, $decimals);

        if (App::getLocale() === 'bn') {
            return bd_digits($formatted);
        }

        return $formatted;
    }
}