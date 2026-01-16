<?php

namespace Tessera\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

/**
 * @property Carbon $expires_at
 * @property int $attempts
 * @property int $max_attempts
 * @property string $code
 */
class Token extends Model
{
    use HasFactory;

    public function getTable() {
        return config('tessera.table_name', parent::getTable());
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function isMaxAttemptsReached(): bool
    {
        return $this->attempts >= $this->max_attempts;
    }

    protected $fillable = [
        'identifier',
        'code',
        'secret',
        'action',
        'attempts',
        'max_attempts',
        'expires_at',
        'params',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'params' => 'json',
        'attempts' => 'integer',
        'max_attempts' => 'integer',
    ];
}