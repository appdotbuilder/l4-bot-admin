<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\L4Buyer
 *
 * @property int $id
 * @property string $telegram_id
 * @property string|null $username
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string $status
 * @property float $balance
 * @property int $total_numbers_used
 * @property \Illuminate\Support\Carbon|null $last_activity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\L4Number[] $numbers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\L4Invoice[] $invoices
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\L4Payment[] $payments
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|L4Buyer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|L4Buyer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|L4Buyer query()
 * @method static \Illuminate\Database\Eloquent\Builder|L4Buyer active()
 * @method static \Illuminate\Database\Eloquent\Builder|L4Buyer banned()
 * @method static \Database\Factories\L4BuyerFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class L4Buyer extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'l4_buyers';

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
        'total_numbers_used',
        'last_activity',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'balance' => 'decimal:2',
        'total_numbers_used' => 'integer',
        'last_activity' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the numbers for this buyer.
     */
    public function numbers(): HasMany
    {
        return $this->hasMany(L4Number::class, 'buyer_id');
    }

    /**
     * Get the invoices for this buyer.
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(L4Invoice::class, 'buyer_id');
    }

    /**
     * Get the payments for this buyer.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(L4Payment::class, 'buyer_id');
    }

    /**
     * Scope a query to only include active buyers.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include banned buyers.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBanned($query)
    {
        return $query->where('status', 'banned');
    }

    /**
     * Get the display name for the buyer.
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