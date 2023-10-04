<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Team extends Model
{
    use HasFactory;

    public static function booted(): void
    {
        static::creating(fn ($model) => $model->slug = Str::slug($model->name));
        static::created(function ($team) {
            $object = $team->objects()->make(['parent_id' => null]);
            $object->objectable()->associate($team->folders()->create(['name' => $team->name]));
            $object->save();
        });

        static::deleting(function ($model){
            $model->objects->each->delete();
        });
    }

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'personal_team'
    ];

    protected $with = ['folders', 'files'];

    public function objects(): HasMany
    {
        return $this->hasMany(Obj::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }

    public function folders(): HasMany
    {
        return $this->hasMany(Folder::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
