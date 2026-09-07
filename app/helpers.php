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

if (! function_exists('format_count')) {
    /**
     * Format a whole number of countable items. In Bangla the count uses
     * Bangla digits and gets a measure-word classifier appended
     * (জন for people, টি for animals). Display-only, never for input.
     */
    function format_count(int $count, string $classifier = ''): string
    {
        $formatted = number_format($count, 0);

        if (App::getLocale() === 'bn') {
            return bd_digits($formatted).$classifier;
        }

        return $formatted.($classifier !== '' ? ' '.$classifier : '');
    }
}

if (! function_exists('effective_user_id')) {
    /**
     * The user whose data should be scoped for the current request.
     * Returns the impersonated user's ID when the super admin is acting
     * as another user, otherwise the authenticated user's own ID.
     */
    function effective_user_id(): int
    {
        return (int) (session('user_id') ?? auth()->id());
    }
}
