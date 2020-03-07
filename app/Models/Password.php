<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Password
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property string $value
 * @property string $website
 * @property string $username
 * @property string $note
 * @property int $user_id
 * @property User $user
 */
class Password extends Model
{
    protected $guarded = [];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
