<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable,HasApiTokens;
    use HasRoles;
    use SoftDeletes;
    protected $with = ['permissions'];
    protected $softDelete = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeSearchCashier($query,$parent_id,$name){

        if ($name != null){
            $query->where('parent_id',$parent_id)->where('name', 'LIKE', "%{$name}%");
        }else{
            $query->where('parent_id',$parent_id);
        }

    }//end scope


    public function notifications()
    {
        return $this->hasMany(Notification::class,'to_user_id');
    }


    public function account()
    {
        return $this->hasMany(Account::class,'model_id','id');
    }

    public function trader_account()
    {
        return $this->hasMany(Account::class,'model_id','trader_id');
    }


}
