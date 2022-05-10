<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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

    /**
     * @return HasOne
     */
    public function role(): HasOne
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    /**
     * @return HasOne
     */
    public function jobFunction(): HasOne
    {
        return $this->hasOne(JobFunction::class, 'id', 'job_function_id');
    }
}
