<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PullApartComment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var mixed
     */
    protected $fillable = [
        'pull_apart_id',
        'user_id',
        'status',
        'comment'
    ];

    /**
     * Pull apart.
     *
     * @return BelongsTo
     */
    public function pullApart(): BelongsTo
    {
        return $this->belongsTo(PullApart::class);
    }
}
