<?php

namespace App\Http\Controllers\Admin\CRUD;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;


// my Traits
use App\Http\Traits\NotificationFirebaseTrait;


class AdminNewUsersController extends Controller
{
    use NotificationFirebaseTrait;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::where([
                'user_type'=>'parent',
                'is_confirmed'=>'new',
            ])->latest()->get();
            return DataTables::of($users)

                ->editColumn('logo', function ($user) {
                    return ' <img src="'.get_file($user->logo).'" class=" w-50 rounded" style="height:50px"
                             onclick="window.open(this.src)">';
                })
                ->editColumn('is_confirmed', function ($user) {
                    $re_write_ = '';
                    if ($user->is_confirmed == 'new') {
                        $re_write_ = '<span class="badge badge-success">جديد</span>';
                    }
                    return $re_write_;
                })

                ->editColumn('created_at', function ($user) {
                    return date('Y/m/d',strtotime($user->created_at));
                })
                ->addColumn('delete_all', function ($user) {
                    return "<input style='width: 19px;' type='checkbox' class='form-control delete-all' name='delete_all' id='" . $user->id . "'>";
                })

                ->addColumn('status', function ($user) {
                    return "<button class='btn btn-success  status' attr_type='accepted' id='" . $user->id . "'><span class='icon-check'></span> موافقة </button>
                            <button class='btn btn-danger  status' attr_type='refused' id='" . $user->id . "'><span class='icon-exit_to_app'></span> رفض </button>";
                })
                ->addColumn('actions', function ($user) {
                    return "<button class='btn btn-danger  delete' id='" . $user->id . "'><span class='icon-delete'></span> </button>";
                })->rawColumns(['actions','logo','delete_all','is_confirmed','status'])->make(true);
        }
        return view('admin.crud.new-users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {

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

        return response()->json(User::destroy($id),200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function delete_all(Request $request)
    {
        User::destroy($request->id);
        return response()->json(1,200);
    }

    public function changeStatus($id,Request $request)
    {
        $row = User::findOrFail($id);
        $row->update(['is_confirmed' => $request->status]);

        User::where('trader_id',$id)->update([
            'is_confirmed' => $request->status
        ]);
        $row = User::findOrFail($id);
        $row->title              = 'الكاشير';

        $row->message              = 'تم قبولك بنجاح';
        $row->body               = 'تم قبولك بنجاح';

        if ( $request->status == 'refused')
        {
            $row->message    = 'تم رفضك ';
            $row->body       = 'تم رفضك';
        }
        $row->notification_type  = 'newTraders';


        $this->sendFCMNotification([$id],null,$row);
        return response()->json(1,200);
    }

}
