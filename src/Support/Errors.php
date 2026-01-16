<?php

namespace Tessera\Support;

class TesseraErrors {
    public const TOKEN_NOT_FOUND = 'token_not_found';
    public const TOKEN_EXPIRED = 'token_expired';
    public const TOKEN_CODE_MISMATCH = 'token_code_mismatch';
    public const TOKEN_MAX_ATTEMPTS_REACHED = 'token_max_attempts_reached';
}