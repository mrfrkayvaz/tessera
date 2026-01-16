<?php

namespace Tessera\Services;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Random\RandomException;
use Tessera\Models\Token;

class TesseraManager {
    /**
     * @throws RandomException
     */
    public function generate(string $action, string $identifier): Token {
        $code = $this->generateCode();
        $max_attempts = $this->getMaxAttempts();
        $attempts = 0;
        $sec = $this->generateSec();
        $expires_at = $this->getExpiredAt();

        return Token::create([
            'action' => $action,
            'identifier' => $identifier,
            'code' => $code,
            'max_attempts' => $max_attempts,
            'attempts' => $attempts,
            'sec' => $sec,
            'expires_at' => $expires_at
        ]);
    }

    /**
     * @throws RandomException
     */
    public function generateCode(): string {
        return (string) random_int(100000, 999999);
    }

    public function generateSec(): string {
        return Str::lower(Str::random(50));
    }

    public function getMaxAttempts(): int {
        return config('tessera.max_attempts', 5);
    }

    public function getExpiredAt(): Carbon {
        $expiration_minutes = config('tessera.expiration_minutes', 5);
        return now()->addMinutes($expiration_minutes);
    }
}