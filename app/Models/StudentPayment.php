<?php

namespace App\Models;

use App\Http\Traits\ColumnFillable;
use Illuminate\Database\Eloquent\Model;

class StudentPayment extends Model
{
    protected $guarded=[];
    protected $table='student_payments';

}
