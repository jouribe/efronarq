<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VisitTracking extends Model
{
    /**
     * The table associated with the model.
     *
     * @var mixed
     */
    protected $table = 'visit_tracking';

    /**
     * The attributes that are mass assignable.
     *
     * @var mixed
     */
    protected $fillable = [
        'visit_id',
        'action_at',
        'action',
        'comments',
        'status'
    ];

    /**
     * Visit
     *
     * @return BelongsTo
     */
    public function visit(): BelongsTo
    {
        return $this->belongsTo(Visit::class);
    }
}
