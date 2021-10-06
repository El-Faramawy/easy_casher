<?php

namespace App\Http\Controllers\Admin;

use App\Http\Traits\CheckPermission;
use App\Http\Traits\Upload_Files;
use App\Models\Admin;
use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Category;
use App\Models\Country;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;


class AdminNotifications extends Controller
{



    public function __construct()
    {
        /* $this->middleware([('permission:admins index,admin')])->only(['index']);*/
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $notifications = AdminNotification::whereHas('user')->latest()->get();

            return DataTables::of($notifications)
                ->addColumn('logo', function ($notification) {
                    return ' <img src="'.get_file($notification->user->logo).'" class=" w-50 rounded" style="height:50px"
                             onclick="window.open(this.src)">';
                })
                ->addColumn('name', function ($notification) {
                    return $notification->user->name;
                })
                ->addColumn('type', function ($notification) {
                    $re_write = '';
                    if ($notification->type == 'newUser'){
                        $re_write ='<span class="badge badge-primary">تاجر جديد</span>';

                    }
                    return $re_write;
                })
                ->addColumn('phone', function ($notification) {
                    return "(".$notification->user->phone_code.")".$notification->user->phone;
                })
                ->editColumn('is_read', function ($notification) {
                    if ($notification->is_read == 'read'){
                        return '<span class="badge badge-primary">مقروء</span>';

                    }
                    if ($notification->is_read == 'unread'){
                        return '<span class="badge badge-warning">غير مقروء</span>';

                    }
                })
                ->editColumn('created_at', function ($notification) {
                    return date('Y/m/d',strtotime($notification->created_at));
                })
                ->addColumn('delete_all', function ($notification) {
                    return "<input style='width: 19px;' type='checkbox' class='form-control delete-all' name='delete_all' id='" . $notification->id . "'>";
                })
                ->addColumn('actions', function ($notification) {
                    $check = $notification->is_read=='unread'?'':'display:none';
                    return "<a  class='btn btn-info ' href='" . route('notifications.show',$notification->id) . "'> <span class='icon-eye'></span></a>
                    <button class='btn btn-primary  makeRead' id='" . $notification->id . "' style='".$check."'><span class='icon-check'></span> </button>
                    <button class='btn btn-danger  delete' id='" . $notification->id . "'><span class='icon-delete'></span> </button>";
                })->rawColumns(['actions','logo','delete_all','phone','type','is_read'])->make(true);
        }
        return view('admin.notifications.index');
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


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $notification = AdminNotification::findOrFail($id);
        $notification->is_read = 'read';
        $notification->save();
        return view('admin.notifications.single',compact('notification'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request , $id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /* if (!checkAdminHavePermission('admins delete'))
         {
             return response()->json(1,500);
         }*/
        return response()->json(AdminNotification::destroy($id),200);
    }



    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function delete_all(Request $request)
    {

        AdminNotification::destroy($request->id);
        return response()->json(1,200);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function makeRead($id)
    {
        AdminNotification::findOrFail($id)->update([
            'is_read' => 'read'
        ]);
        return response()->json(1,200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function notificationsForLayout(Request $request)
    {
        $returnHTML = view("admin.layouts.notification")
            ->with([
                'unreadNotificationCount' =>AdminNotification::where('is_read','unread')->count(),
                'notification_count' =>AdminNotification::count(),
                'unreadNotifications' =>AdminNotification::where('is_read','unread')->latest()->get(),
            ])
            ->render();
        return response()->json(array('success' => true, 'html'=>$returnHTML));
    }


}//end
