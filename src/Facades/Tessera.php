<?php

namespace Tessera\Facades;

use Illuminate\Support\Facades\Facade;
use Tessera\Models\Token;
use Tessera\Services\TesseraManager;

/**
 * @method static Token generate(string $action, string $identifier)
 * @see TesseraManager
 */
class Tessera extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return TesseraManager::class;
    }
}
