<?php

namespace Tessera\Services;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Random\RandomException;
use Tessera\DTOs\TokenVerifyResponse;
use Tessera\Models\Token;
use Tessera\Support\TesseraErrors;

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
            'secret' => $sec,
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

    public function getToken(
        string $action,
        string $identifier,
    ): Token | null {
        return Token::where([
            'identifier' => $identifier,
            'action' => $action,
        ])->latest()->first();
    }

    public function getTokenVerified(
        string $action,
        string $identifier,
        string $sec,
        string $code
    ): Token | null {
        return Token::where([
            'identifier' => $identifier,
            'action' => $action,
            'secret' => $sec,
            'code' => $code
        ])->latest()->first();
    }

    public function verify(
        string $action,
        string $identifier,
        string $sec,
        string $code
    ): TokenVerifyResponse {
        $token = Token::where([
            'identifier' => $identifier,
            'action' => $action,
            'secret' => $sec
        ])->latest()->first();

        $response = $this->check($token, $code);
        $token->increment('attempts');

        return $response;
    }

    public function check(Token | null $token, string $code): TokenVerifyResponse {
        if (!$token) {
            return new TokenVerifyResponse(
                verified: false,
                error: TesseraErrors::TOKEN_NOT_FOUND
            );
        }

        if ($token->attempts >= $token->max_attempts) {
            return new TokenVerifyResponse(
                verified: false,
                error: TesseraErrors::TOKEN_MAX_ATTEMPTS_REACHED
            );
        }

        if ($token->expires_at <= now()) {
            return new TokenVerifyResponse(
                verified: false,
                error: TesseraErrors::TOKEN_EXPIRED
            );
        }

        if ($token->code !== $code) {
            return new TokenVerifyResponse(
                verified: false,
                error: TesseraErrors::TOKEN_CODE_MISMATCH
            );
        }

        return new TokenVerifyResponse(
            verified: true
        );
    }
}