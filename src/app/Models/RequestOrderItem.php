<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestOrderItem extends Model
{
    use SoftDeletes;

    protected $table = 'request_order_items';

    protected $fillable = [
        'request_order_id', 'menu_id', 'item_id'
    ];

    /**
     * @return BelongsTo
     */
    public function requestOrder(): BelongsTo
    {
        return $this->belongsTo(RequestOrder::class);
    }

    /**
     * @return HasOne
     */
    public function menu(): HasOne
    {
        return $this->hasOne(Menu::class);
    }

    /**
     * @return HasOne
     */
    public function item(): HasOne
    {
        return $this->hasOne(MenuItem::class, 'id', 'item_id');
    }
}
