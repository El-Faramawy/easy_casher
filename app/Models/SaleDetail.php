<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class,'sale_id');
    }

    public function one_product()
    {
        return $this->belongsTo(Product::class,"product_id")->select(["id","title",'product_cost'])->withTrashed();
    }

    public function one_sale()
    {
        return $this->belongsTo(Sale::class,'sale_id')->select(["id","date","discount_value"]);
    }
}
