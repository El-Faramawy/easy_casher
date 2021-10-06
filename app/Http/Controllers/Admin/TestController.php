<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Pusher\Pusher;

class TestController extends Controller
{

    public function notify()
    {
        $options = array(
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'encrypted' => true
        );
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $data['order_id'] = 1;
        $data['title'] = 'new Order Has Created';
        $data['message'] = 'new Order Has Created';
        $pusher->trigger('new-order-channel', 'App\\Events\\OrderEvent', $data);

    }


}
