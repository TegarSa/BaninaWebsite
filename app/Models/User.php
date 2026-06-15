<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admins';

    const UPDATED_AT = null;

    protected $fillable = [
        'username',
        'password'
    ];
}