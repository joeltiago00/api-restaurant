<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Costumer extends Authenticatable
{
    use SoftDeletes;

    protected $table = 'costumers';

    protected $fillable = [
        'first_name', 'last_name', 'role', 'email', 'document_type', 'document_value'
    ];

}
