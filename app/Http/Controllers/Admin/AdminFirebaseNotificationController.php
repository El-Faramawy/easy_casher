<?php

namespace App\Http\Controllers\Admin;

use App\Http\Traits\NewNotificationForWeb;
use App\Http\Traits\NotificationFirebaseTrait;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminFirebaseNotificationController extends Controller
{
    use NotificationFirebaseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('admin.firebase.index',['users'=>User::where('id','!=',1)->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|string',
            'body' => 'required|string',
        ];
        $this->validate($request, $rules);
        if ($request->flag == 'all'){
            $users = User::pluck('id')->toArray();
        }else{
            $this->validate($request, [
                'users'=>'required|array'
            ]);
            $users = $request->users;
        }
        $mess=\request()->only('title','body');
        $mess['body']=$request->body;
        $mess['notification_type']='general_notification';
        $this->sendFCMNotification($users,null,$mess);

       return response()->json(1,200);
    }//end

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


}//end class
