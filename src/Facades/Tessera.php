<?php

namespace Tessera\Facades;

use Illuminate\Support\Facades\Facade;
use Tessera\DTOs\TokenVerifyResponse;
use Tessera\Models\Token;
use Tessera\Services\TesseraManager;

/**
 * @method static Token generate(string $action, string $identifier)
 * @method static TokenVerifyResponse verify(string $action, string $identifier, string $sec, string $code)
 * @method static Token | null getTokenVerified(string $action, string $identifier, string $sec, string $code)
 * @method static Token | null getToken(string $action, string $identifier)
 * @method static void useTokenModel(string $model)
 * @see TesseraManager
 */
class Tessera extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return TesseraManager::class;
    }
}
