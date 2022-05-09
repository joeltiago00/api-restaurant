<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestOrder extends Model
{
    use SoftDeletes;

    protected $table = 'request_orders';

    protected $fillable = [
        'waiter_id', 'cooker_id', 'status', 'price', 'started_at', 'finished_at', 'opened_at', 'table_id'
    ];

    /**
     * @return HasManyThrough
     */
    public function items(): HasManyThrough
    {
        return $this->hasManyThrough(
            MenuItem::class,
            RequestOrderItem::class,
            '',
            'id',
            '',
            'item_id'
        );
    }

    /**
     * @return HasMany
     */
    public function requestOderItem(): HasMany
    {
        return $this->hasMany(RequestOrderItem::class, 'request_order_id');
    }

    /**
     * @return HasOne
     */
    public function waiter(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'waiter_id');
    }
}
