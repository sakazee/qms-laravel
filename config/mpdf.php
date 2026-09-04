<?php

return [
    /*
    |--------------------------------------------------------------------------
    | mPDF Configuration for Bengali Language Support
    |--------------------------------------------------------------------------
    |
    | Bengali (Bangla) fonts must be placed in:
    | public/fonts/bengali/
    |
    | Required font files:
    | - SolaimanLipi.ttf
    | - SolaimanLipi_Bold.ttf
    | - Kalpurush.ttf
    |
    | Download from: https://www.omicronlab.com/bangla-fonts.html
    |
    */

    'mode'           => 'utf-8',
    'format'         => 'A4',
    'orientation'    => 'P',
    'default_font'   => 'solaimanlipi',

    'margin_left'   => 15,
    'margin_right'  => 15,
    'margin_top'    => 20,
    'margin_bottom' => 20,

    'fonts' => [
        'solaimanlipi' => [
            'R'  => 'SolaimanLipi.ttf',
            'B'  => 'SolaimanLipi_Bold.ttf',
            'useOTL'    => 0xFF,
            'useKashida' => 75,
        ],
        'kalpurush' => [
            'R'      => 'Kalpurush.ttf',
            'useOTL' => 0xFF,
        ],
    ],

    'font_dir' => public_path('fonts/bengali'),
];
