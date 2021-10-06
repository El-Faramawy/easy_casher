<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Model
{
    use HasRoles;
    protected $guard_name = 'admin';
    protected $guarded=[];

    protected $hidden = [
        'password', 'remember_token',
    ];

}//end class
