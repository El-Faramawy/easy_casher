<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $guarded = [];
    protected $softDelete = true;

    public function sale_details()
    {
        return $this->hasMany(SaleDetail::class,'sale_id');
    }
    public function trader()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class,'client_id');
    }
    public function one_client()
    {
        return $this->belongsTo(Client::class,'client_id')->withTrashed();
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class,'coupon_id');
    }

    public function addedBy()
    {
        return $this->belongsTo(User::class,'added_by_id');
    }

}
