<?php

namespace App\Http\Controllers\Admin;

use App\Http\Traits\CheckPermission;
use App\Http\Traits\Upload_Files;
use App\Models\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SiteText;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;


class AdminPermissionsController extends Controller
{

    use Upload_Files,CheckPermission;


    public function __construct()
    {
        /* $this->middleware([('permission:siteTexts index,admin')])->only(['index']);*/
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $permissions=Permission::where('name','!=','Add Permissions')->latest()->get();
            return DataTables::of($permissions)

                ->editColumn('created_at', function ($permission) {
                    return date('Y/m/d',strtotime($permission->created_at));
                })
                ->addColumn('delete_all', function ($permission) {
                    return "<input style='width: 19px;' type='checkbox' class='form-control delete-all' name='delete_all' id='" . $permission->id . "'>";
                })
                ->addColumn('actions', function ($permission) {
                    return "<button  class='btn btn-info editButton' id='" . $permission->id . "'> <span class='icon-edit'></span></button>
                   <button class='btn btn-danger  delete' id='" . $permission->id . "'><span class='icon-delete'></span> </button>";
                })->rawColumns(['actions','delete_all'])->make(true);
        }
        return view('admin.permissions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        /*if (!checkAdminHavePermission('admins create'))
        {
            return response()->json(1,500);
        }*/
        if ($request->ajax()){
            $returnHTML = view("admin.permissions.parts.add_form")
                ->with([
                ])
                ->render();
            return response()->json(array('success' => true, 'html'=>$returnHTML));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request,[
            'name'=>'required|unique:permissions,name',
            'ar_name'=>'required',
            'type_name'=>'required',
            'type_order'=>'required',

        ]);
        $data['guard_name'] = 'admin';

        Permission::create($data);
        return response()->json(1,200);

    }

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
    public function edit(Request $request , $id)
    {
        /* if (!checkAdminHavePermission('admins edit'))
         {
             return response()->json(1,405);
         }*/
        if ($request->ajax()){
            $returnHTML = view("admin.permissions.parts.edit_form")
                ->with([
                    'permission' =>Permission::findOrFail($id)
                ])
                ->render();
            return response()->json(array('success' => true, 'html'=>$returnHTML));
        }
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
        $permission = Permission::findOrFail($id);
        $data = $this->validate($request,[
            'name'=>Rule::unique('permissions')->ignore($id),
            'ar_name'=>'required',
            'type_name'=>'required',
            'type_order'=>'required',
        ]);
        try{
            $permission->update($data);
            return response()->json(1,200);
        }catch (\Exception $exception){
            return response()->json($exception->getMessage(),500);
        }
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
        return response()->json(Permission::destroy($id),200);
    }

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
        Permission::destroy($request->id);
        return response()->json(1,200);
    }


}//end
