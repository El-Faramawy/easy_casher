<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $with = ['color'];
    protected $softDelete = true;

    //scopes
    public function scopeSearchCategory($query,$title){

        if ($title != null){
            $query->where('title', 'LIKE', "%{$title}%");
        }else{
            $query->whereNotNull('id');
        }

    }//end scope


    //relations
    public function products()
    {
        return $this->belongsToMany(Product::class,'product_categories');
    }

    public function color()
    {
        return $this->belongsTo(Color::class,'color_id');
    }

}//end model
