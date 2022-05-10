<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Table extends Model
{
    use SoftDeletes;

    protected $table = 'tables';

    protected $fillable = [
        'number', 'quantity_seats'
    ];

    /**
     * @return BelongsToMany
     */
    public function requestOrder(): BelongsToMany
    {
        return $this->belongsToMany(RequestOrder::class);
    }
}
