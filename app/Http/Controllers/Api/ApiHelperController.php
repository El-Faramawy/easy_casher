<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Slider;
use Illuminate\Http\Request;

class ApiHelperController extends Controller
{

    public function getAllColors()
    {
        return response(['data' => Color::get()],200);
    }

    public function getAllSliders()
    {
        return response(['data' => Slider::get()],200);
    }


}//end class
