<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Document extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var mixed
     */
    protected $fillable = [
        'name',
        'type'
    ];

    /**
     * Pull aparts.
     *
     * @return HasMany
     */
    public function pullAparts(): HasMany
    {
        return $this->hasMany(PullApartDocument::class);
    }
}
