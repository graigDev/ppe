<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Role extends Model
{
    use HasFactory;

    public static function booted(): void
    {
        static::creating(fn ($model) => $model->slug = Str::slug($model->name));
    }

    protected $fillable = [
        'name',
        'slug'
    ];


    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
