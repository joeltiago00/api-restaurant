<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use SoftDeletes;

    protected $table = 'customers';

    protected $fillable = [
        'first_name', 'last_name', 'role', 'email', 'document_type', 'document_value'
    ];

    /**
     * @return HasMany
     */
    public function requestOrders(): HasMany
    {
        return $this->hasMany(RequestOrder::class, 'costumer_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function firstRequestOrder(): HasMany
    {
        return $this->hasMany(RequestOrder::class, 'costumer_id', 'id')
            ->orderBy('created_at', 'asc');
    }
}
