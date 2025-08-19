<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\L4Payment
 *
 * @property int $id
 * @property int $buyer_id
 * @property int|null $invoice_id
 * @property float $amount
 * @property string $type
 * @property string|null $method
 * @property string|null $transaction_id
 * @property string $description
 * @property array|null $metadata
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\L4Buyer $buyer
 * @property-read \App\Models\L4Invoice|null $invoice
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|L4Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|L4Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|L4Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder|L4Payment credits()
 * @method static \Illuminate\Database\Eloquent\Builder|L4Payment debits()
 * @method static \Database\Factories\L4PaymentFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class L4Payment extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'l4_payments';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'buyer_id',
        'invoice_id',
        'amount',
        'type',
        'method',
        'transaction_id',
        'description',
        'metadata',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'metadata' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the buyer this payment belongs to.
     */
    public function buyer(): BelongsTo
    {
        return $this->belongsTo(L4Buyer::class, 'buyer_id');
    }

    /**
     * Get the invoice this payment is for.
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(L4Invoice::class, 'invoice_id');
    }

    /**
     * Scope a query to only include credit payments.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCredits($query)
    {
        return $query->where('type', 'credit');
    }

    /**
     * Scope a query to only include debit payments.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDebits($query)
    {
        return $query->where('type', 'debit');
    }
}