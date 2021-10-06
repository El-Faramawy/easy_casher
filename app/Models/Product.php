<?php

namespace App\Models;

use App\SaleDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $softDelete = true;
    protected $with = ['color'];
    //scopes
    public function scopeSearchProduct($query,$title ,$category){

        if ($title != null && $category =='all'){
            $query->where('title', 'LIKE', "%{$title}%")
                ->whereHas('categories',function ($query) use($category){
                    $query->whereNull('deleted_at');
                });
        }else if ($title != null && $category !='all') {
            $query->where('title', 'LIKE', "%{$title}%")
                ->whereHas('categories',function ($query) use($category){
                    $query->whereNull('deleted_at')
                        ->where('categories.id',$category);
                });
        }else if ($title == null && $category !='all') {
            $query->whereHas('categories',function ($query) use($category){
                    $query->whereNull('deleted_at')
                        ->where('categories.id',$category);
                });
        }else{
            $query->whereNotNull('id')
                ->whereHas('categories',function ($query) use($category){
                $query->whereNull('deleted_at');
            });
        }

    }//end scope

    public function categories()
    {
        return $this->belongsToMany(Category::class,'product_categories');
    }

    public function single_category()
    {
        return $this->belongsToMany(Category::class,'product_categories')->latest();
    }

    public function color()
    {
        return $this->belongsTo(Color::class,'color_id');
    }



}//end class
