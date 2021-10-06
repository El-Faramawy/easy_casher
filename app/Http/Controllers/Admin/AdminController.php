<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\League;
use App\Models\Match;
use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Story;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Http\Request;


class AdminController extends Controller
{

    public function __construct()
    {

    }

    /**
     * show dashboard.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('admin.home.dashboard',[
            'colors' =>['#C0C0C0','#808080','#FFA07A','#E9967A','blue','green','red',
                '#999999','#454545','#D3D3D3','#380000','#E80000','#009966','#009933',
                '#330099','#660099','#D3D3D3','#990066','#9900FF','#990000','#999900',
                '#FF33FF','#FFFF00','#FF3333','#FF3333','#FFFF99','#990000','#FF99CC',
                '#990000','#663366','#663399','#669966','#669999','#6666FF','#66FFFF'
            ],
        ]);
    }




}//end
