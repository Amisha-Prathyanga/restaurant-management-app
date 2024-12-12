<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    protected $fillable = [
        'send_to_kitchen_time',
        'status',
        'total_cost'
    ];

    protected $dates = [
        'send_to_kitchen_time',
        'created_at',
        'updated_at'
    ];

    /**
     * The concessions that belong to the order.
     */
    public function concessions(): BelongsToMany
    {
        return $this->belongsToMany(Concession::class, 'order_concession')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    /**
     * Calculate the total cost of the order
     */
    public function calculateTotalCost(): void
    {
        $this->total_cost = $this->concessions->sum(function ($concession) {
            return $concession->price * $concession->pivot->quantity;
        });
        $this->save();
    }
}
