<?php

namespace Tessera\Tests;

use Tessera\Facades\Tessera;
use Illuminate\Support\Facades\DB;

it('should generate a token', function () {
    $user_id = DB::table('users')->insertGetId([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => bcrypt('password'),
    ]);

    $otp = Tessera::generate(
        action: 'verify_email',
        identifier: (string) $user_id
    );

    expect($otp)->not->toBeNull()
        ->and($otp->code)
        ->toHaveLength(6);
});