<?php

namespace App\Http\Controllers\Admin;

use App\Http\Traits\CheckPermission;
use App\Http\Traits\Upload_Files;
use App\Models\Admin;
use App\Models\StudentPayment;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;


class AdminUserPackageController extends Controller
{

    use Upload_Files,CheckPermission;


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
            $users = User::where([
                'user_type'=>'parent',

            ])->whereIn( 'is_confirmed',['accepted','refused'])->latest()->get();

            return DataTables::of($users)
                ->editColumn('logo', function ($user) {
                    return ' <img src="'.get_file($user->logo).'" class=" w-50 rounded" style="height:50px"
                             onclick="window.open(this.src)">';
                })
                ->editColumn('package_finished_at', function ($user) {
                    return date('Y/m/d',strtotime($user->package_finished_at));
                })

                ->editColumn('is_block', function ($user) {
                    $re_block = '';
                    if ($user->is_block == 'not_blocked') {
                        $re_block = '<span class="badge badge-success">مفعل</span>';
                    }else{
                        $re_block = '<span class="badge badge-danger">موقوف</span>';

                    }
                    return $re_block;
                })
                ->editColumn('is_confirmed', function ($user) {
                    $re_block = '';
                    if ($user->is_confirmed == 'accepted') {
                        $re_block = '<span class="badge badge-success">مقبول</span>';
                    }else{
                        $re_block = '<span class="badge badge-danger">مرفوض</span>';

                    }
                    return $re_block;
                })
                ->editColumn('package_finished_at', function ($user) {
                    if($user->package_finished_at != null)
                    return date('Y/m/d',strtotime($user->package_finished_at));
                    if($user->package_finished_at == null || $user->package_finished_at == '')
                        return '';
                })
                ->addColumn('delete_all', function ($user) {
                    return "<input style='width: 19px;' type='checkbox' class='form-control delete-all' name='delete_all' id='" . $user->id . "'>";
                })
                ->addColumn('actions', function ($user) {
                    /* usersPackages $user->id edit*/
                    return "<a href='".aurl("usersPackages")."/".$user->id."/edit'>
                            <button class='btn btn-primary ' ><span class='icon-edit'></span> </button></a>";

                })->rawColumns(['actions','logo','delete_all','is_block','is_confirmed'])->make(true);
        }
        return view('admin.bouquets.index');
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
    public function show($id, Request $request)
    {
        if ($request->ajax()){
            $view = "admin.users.parts.{$request->viewSection}";
            $returnHTML = view($view)
                ->with([
                    'user' =>User::findOrFail($id)
                ])
                ->render();
            return response()->json(array('success' => true,'profileForm'=>$returnHTML));
        }

        $user = User::findOrFail($id);
        $colors = [ '#C0C0C0','#808080','#FFA07A','#E9967A','blue','green','red',
            '#999999','#454545','#D3D3D3','#380000','#E80000','#009966','#009933',
            '#330099','#660099','#D3D3D3','#990066','#9900FF','#990000','#999900',
            '#FF33FF','#FFFF00','#FF3333','#FF3333','#FFFF99','#990000','#FF99CC',
            '#990000','#663366','#663399','#669966','#669999','#6666FF','#66FFFF'
        ];
        return view('admin.users.show',compact('user','colors'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request , $id)
    {
        $user = User::findOrFail($id);
        return view('admin.bouquets.edit',compact('user'));

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
//        $data = $this->validate($request, [
//            'package_finished_at' => 'required|after:today',
//
//        ]);
//
//        $validator = Validator::make($request->all(), [ // <---
//            'package_finished_at'=>['required'],
//        ]);
//       $data['package_finished_at'] = $request->package_finished_at;
//       dd($data);
//        User::find($id)->update($data['package_finished_at']);
//        return response()->json(1, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//    public function destroy($id)
//    {
//        /* if (!checkAdminHavePermission('admins delete'))
//         {
//             return response()->json(1,500);
//         }*/
//        return response()->json(User::destroy($id),200);
//    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function delete_all(Request $request)
    {
        /* if (!checkAdminHavePermission('admins multiDelete'))
         {
             return response()->json(1,500);
         }*/
        User::destroy($request->id);
        return response()->json(1,200);
    }


    public function changeBlock($id)
    {
        $row = User::findOrFail($id);
        $status = $row->is_block == 'blocked'?'not_blocked':'blocked';
        $row->update(['is_block' => $status]);
        return response()->json(1,200);
    }


public function UpdateFinishedAt(Request $request){
    $data = $this->validate($request, [
        'package_finished_at' => 'required|after:today',

    ]);

    $validator = \Validator::make($request->all(), [ // <---
        'package_finished_at'=>['required'],
    ]);
    $data['package_finished_at'] = $request->package_finished_at;
        $user = User::where('id',$request->id)->update($data);
    return redirect()->route('usersPackages.index');
}

}//end
