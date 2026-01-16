<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Database Table Name
    |--------------------------------------------------------------------------
    |
    | This value determines the name of the table that will be used to store
    | one-time passwords. You can change this if you have an existing
    | table with the same name.
    |
    */
    'table_name' => 'tokens',

    /*
    |--------------------------------------------------------------------------
    | Maximum Attempts
    |--------------------------------------------------------------------------
    |
    | Here you may specify the maximum number of failed verification attempts
    | allowed before the token becomes invalid. This helps prevent
    | brute-force attacks.
    |
    */
    'max_attempts' => 5,

    /*
    |--------------------------------------------------------------------------
    | Token Expiration (Minutes)
    |--------------------------------------------------------------------------
    |
    | This value defines the lifetime of the generated tokens in minutes.
    | After this period, the token will be considered expired and
    | cannot be used for verification.
    |
    */
    'expiration_minutes' => 5,

];