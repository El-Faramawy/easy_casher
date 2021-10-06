<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $guarded = [];
    protected $softDelete = true;


    public function purchase_details()
    {
        return $this->hasMany(\App\Models\PurchaseDetail::class,'purchase_id');
    }

    public function trader()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Client::class,'supplier_id');
    }



    public function addedBy()
    {
        return $this->belongsTo(User::class,'added_by_id');
    }
}
