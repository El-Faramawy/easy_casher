<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpenseRevenue extends Model
{
    protected $guarded = [];
    protected $softDelete = true;
    protected $with = ['expense_account','revenue_account'];

    public function expense_account()
    {
        return $this->belongsTo(Account::class,'debtor_id');
    }

    public function revenue_account()
    {
        return $this->belongsTo(Account::class,'creditor_id');
    }
}
