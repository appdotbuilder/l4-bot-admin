<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\L4Number
 *
 * @property int $id
 * @property string $phone_number
 * @property string $country_code
 * @property string $country_name
 * @property int $seller_id
 * @property int|null $buyer_id
 * @property string $status
 * @property float $price
 * @property string|null $service
 * @property string|null $sms_codes
 * @property \Illuminate\Support\Carbon|null $rented_at
 * @property \Illuminate\Support\Carbon|null $expires_at
 * @property \Illuminate\Support\Carbon|null $completed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\L4Seller $seller
 * @property-read \App\Models\L4Buyer|null $buyer
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|L4Number newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|L4Number newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|L4Number query()
 * @method static \Illuminate\Database\Eloquent\Builder|L4Number available()
 * @method static \Illuminate\Database\Eloquent\Builder|L4Number rented()
 * @method static \Illuminate\Database\Eloquent\Builder|L4Number active()
 * @method static \Database\Factories\L4NumberFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class L4Number extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'l4_numbers';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'phone_number',
        'country_code',
        'country_name',
        'seller_id',
        'buyer_id',
        'status',
        'price',
        'service',
        'sms_codes',
        'rented_at',
        'expires_at',
        'completed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'rented_at' => 'datetime',
        'expires_at' => 'datetime',
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the seller that provided this number.
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(L4Seller::class, 'seller_id');
    }

    /**
     * Get the buyer that rented this number.
     */
    public function buyer(): BelongsTo
    {
        return $this->belongsTo(L4Buyer::class, 'buyer_id');
    }

    /**
     * Scope a query to only include available numbers.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    /**
     * Scope a query to only include rented numbers.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRented($query)
    {
        return $query->where('status', 'rented');
    }

    /**
     * Scope a query to only include active numbers (available or rented).
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['available', 'rented']);
    }
}