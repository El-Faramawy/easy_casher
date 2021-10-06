<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $softDelete = true;


    //scopes
    public function scopeSearchClient($query,$title){

        if ($title != null){
            $query->where('name', 'LIKE', "%{$title}%");
        }else{
            $query->whereNotNull('id');
        }

    }//end scope

    public function account()
    {
        return $this->hasMany(Account::class,'model_id','id');
    }

}//end class
