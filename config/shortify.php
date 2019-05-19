<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Shortify Defaults Options
    |--------------------------------------------------------------------------
    |
    |
    |
    */
    'perpage' => env('SHORTIFY_PERPAGE', 10),
    'blacklist' => env('SHORTIFY_BLACKLIST', ['.xxx', 'xxx', 'porn', 'sex']),
];