<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PullApartBill extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var mixed
     */
    protected $fillable = [
        'pull_apart_id',
        'proprietorship',
        'damages',
        'damages_str',
        'unemployment',
        'unemployment_str',
        'changes',
        'sanitation',
        'delivery_apartment_at',
        'delivery_term',
        'delivery_term_amount',
        'delivery_term_amount_str',
        'additional_term',
        'additional_term_at',
        'additional_term_penalty',
        'additional_term_penalty_str',
        'footer'
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
