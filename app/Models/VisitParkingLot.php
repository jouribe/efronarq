<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VisitParkingLot extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var mixed
     */
    protected $fillable = [
        'visit_id',
        'project_parking_lot_id'
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

    /**
     * Project parking lot.
     *
     * @return BelongsTo
     */
    public function parkingLot(): BelongsTo
    {
        return $this->belongsTo(ProjectParkingLot::class, 'project_parking_lot_id', 'id');
    }
}
