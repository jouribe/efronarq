<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectApartment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var mixed
     */
    protected $fillable = [
        'project_id',
        'apartment_type_id',
        'name',
        'availability',
        'start_floor',
        'end_floor',
        'parking_lots',
        'closets',
        'order'
    ];

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     *
     * @noinspection ReturnTypeCanBeDeclaredInspection
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->name = $model->start_floor . $model->apartmentType->type_name;
        });

        static::updating(function ($model) {
            $model->name = $model->start_floor . $model->apartmentType->type_name;
        });
    }

    /**
     * Projects
     *
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Project apartment type.
     *
     * @return BelongsTo
     */
    public function apartmentType(): BelongsTo
    {
        return $this->belongsTo(ProjectApartmentType::class);
    }

    /**
     * Visits
     *
     * @return HasMany
     */
    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class);
    }
}
