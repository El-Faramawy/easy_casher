<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class,'from_user_id');
    }


}//end class
