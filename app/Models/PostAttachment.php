<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PostAttachment extends Model
{
    use HasFactory;

    CONST UPDATED_AT = null;

    protected $guarded = false;

    protected static function boot()
    {
        parent::boot();

        static::deleted(function (self $model) {
            Storage::disk('public')->delete($model->path);
        });
    }
}
