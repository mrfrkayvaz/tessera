<?php

namespace Tessera\DTOs;

readonly class TokenVerifyResponse
{
    public function __construct(
        public bool $verified,
        public ?string $error = null
    ) {
    }
}