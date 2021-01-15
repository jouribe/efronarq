<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PullApartFee extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pull_apart_id',
        'fee',
        'fee_at',
        'milestone'
    ];

    /**
     * Pull apart
     *
     * @return BelongsTo
     */
    public function pullApart(): BelongsTo
    {
        return $this->belongsTo(PullApart::class);
    }
}
