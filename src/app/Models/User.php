<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;

    protected $table = 'users';

    protected $fillable = [
        'first_name', 'last_name', 'document_type', 'document_value', 'email', 'password', 'role_id', 'job_function_id'
    ];

    /**
     * @return HasMany
     */
    public function session(): HasMany
    {
        return $this->hasMany(Session::class);
    }

    /**
     * @return HasMany
     */
    public function requestOrders(): HasMany
    {
        return $this->hasMany(RequestOrder::class);
    }
}
