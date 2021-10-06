<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $softDelete = true;

    //scopes
    public function scopeSearchCoupon($query,$title){

        if ($title != null){
            $query->where('title', 'LIKE', "%{$title}%");
        }else{
            $query->whereNotNull('id');
        }

    }//end scope

}
