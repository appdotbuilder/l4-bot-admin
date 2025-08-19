<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\L4Seller
 *
 * @property int $id
 * @property string $telegram_id
 * @property string|null $username
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string $status
 * @property float $balance
 * @property int $total_numbers_sold
 * @property float $commission_rate
 * @property \Illuminate\Support\Carbon|null $last_activity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\L4Number[] $numbers
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|L4Seller newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|L4Seller newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|L4Seller query()
 * @method static \Illuminate\Database\Eloquent\Builder|L4Seller active()
 * @method static \Illuminate\Database\Eloquent\Builder|L4Seller banned()
 * @method static \Database\Factories\L4SellerFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class L4Seller extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'l4_sellers';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'telegram_id',
        'username',
        'first_name',
        'last_name',
        'status',
        'balance',
        'total_numbers_sold',
        'commission_rate',
        'last_activity',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'balance' => 'decimal:2',
        'total_numbers_sold' => 'integer',
        'commission_rate' => 'decimal:2',
        'last_activity' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the numbers for this seller.
     */
    public function numbers(): HasMany
    {
        return $this->hasMany(L4Number::class, 'seller_id');
    }

    /**
     * Scope a query to only include active sellers.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include banned sellers.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBanned($query)
    {
        return $query->where('status', 'banned');
    }

    /**
     * Get the display name for the seller.
     *
     * @return string
     */
    public function getDisplayNameAttribute(): string
    {
        if ($this->first_name && $this->last_name) {
            return $this->first_name . ' ' . $this->last_name;
        }
        
        return $this->username ?: 'User #' . $this->telegram_id;
    }
}