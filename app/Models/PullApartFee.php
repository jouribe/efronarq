<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PullApartFee extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var mixed
     */
    protected $fillable = [
        'pull_apart_id',
        'fee',
        'fee_at',
        'milestone',
        'type',
        'pay',
        'payment_at'
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

    /**
     * Pull apart fee payments.
     *
     * @return HasMany
     */
    public function payments(): HasMany
    {
        return $this->hasMany(PullApartFeePayment::class, 'pull_part_fee_id', 'id');
    }
}
