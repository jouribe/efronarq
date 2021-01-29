<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var mixed
     */
    protected $fillable = [
        'dni',
        'first_name',
        'last_name',
        'full_name',
        'email',
        'secondary_email',
        'phone',
        'district_id',
        'company_id',
        'address',
        'customer_type',
        'position',
        'single',
        'document_nro'
    ];

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        static::saving(function ($model) {
            $model->full_name = "{$model->first_name} {$model->last_name}";
        });
    }

    /**
     * Visits.
     *
     * @return HasMany
     */
    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class);
    }

    /**
     * Details
     *
     * @return HasMany
     */
    public function details(): HasMany
    {
        return $this->hasMany(CustomerDetail::class);
    }

    /**
     * District
     *
     * @return BelongsTo
     */
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    /**
     * Company
     *
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Related.
     *
     * @return HasMany
     */
    public function related(): HasMany
    {
        return $this->hasMany(CustomerRelated::class);
    }
}
