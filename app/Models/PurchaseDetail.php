<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class,'purchase_id');
    }

    public function one_purchase()
    {
        return $this->belongsTo(Purchase::class,'purchase_id')->select(["id","date"]);
    }

    public function one_product()
    {
        return $this->belongsTo(Product::class,"product_id")->select(["id","title",'product_cost'])->withTrashed();
    }
}
