<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = false;

    function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    function attachments(): HasMany
    {
        return $this->hasMany(PostAttachment::class);
    }
}
