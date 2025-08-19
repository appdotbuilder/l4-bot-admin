<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\L4Invoice
 *
 * @property int $id
 * @property string $invoice_number
 * @property int $buyer_id
 * @property \Illuminate\Support\Carbon $invoice_date
 * @property float $total_amount
 * @property int $numbers_count
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $paid_at
 * @property string|null $description
 * @property array|null $line_items
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\L4Buyer $buyer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\L4Payment[] $payments
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|L4Invoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|L4Invoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|L4Invoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|L4Invoice pending()
 * @method static \Illuminate\Database\Eloquent\Builder|L4Invoice paid()
 * @method static \Illuminate\Database\Eloquent\Builder|L4Invoice overdue()
 * @method static \Database\Factories\L4InvoiceFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class L4Invoice extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'l4_invoices';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'invoice_number',
        'buyer_id',
        'invoice_date',
        'total_amount',
        'numbers_count',
        'status',
        'paid_at',
        'description',
        'line_items',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'invoice_date' => 'date',
        'total_amount' => 'decimal:2',
        'numbers_count' => 'integer',
        'paid_at' => 'datetime',
        'line_items' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the buyer this invoice belongs to.
     */
    public function buyer(): BelongsTo
    {
        return $this->belongsTo(L4Buyer::class, 'buyer_id');
    }

    /**
     * Get the payments for this invoice.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(L4Payment::class, 'invoice_id');
    }

    /**
     * Scope a query to only include pending invoices.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include paid invoices.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    /**
     * Scope a query to only include overdue invoices.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', 'overdue');
    }
}