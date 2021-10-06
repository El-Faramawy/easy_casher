<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;

class PermissionForAdminAddingController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $admins = Admin::has('permissions')->withCount('permissions')->get();
            return DataTables::of($admins)

                ->addColumn('delete_all', function ($admin) {
                    return "<input style='width: 19px;' type='checkbox' class='form-control delete-all' name='delete_all' id='" . $admin->id . "'>";
                })

                ->addColumn('actions', function ($admin) {
                    return "<a href='" . route('adminPermissions.edit',$admin->id) . "'  class='btn btn-info'> <span class='icon-edit'></span></a>
                   <button class='btn btn-danger  delete' id='" . $admin->id . "'><span class='icon-delete'></span> </button>";
                })->rawColumns(['actions','delete_all'])->make(true);
        }
        return view('admin.adminPermissions.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $admins = Admin::doesnthave('permissions')->get();
        $permissions=Permission::where(['guard_name'=>'admin'])
            ->where('name','!=','Add Permissions')
            ->orderBy('type_order','desc')
            ->get();
        return view('admin.adminPermissions.create',
            [
                'admins'=>$admins,
                'permissions'=>$permissions,
            ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'permissions.*'=>'required|exists:permissions,id',
            'user_id'=>'required|exists:admins,id',
        ]);
        $admin=Admin::findOrFail($request->user_id);
        $permissions=Permission::whereIn('id',$request->permissions)->pluck('name')->toArray();
        $admin->givePermissionTo($permissions);
        toastr()->success('تمت العملية بنجاح !','تهانينا');
        return redirect()->route('adminPermissions.index');
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
    public function edit($id)
    {
        $admin=Admin::findOrFail($id);
        $permissions=Permission::where(['guard_name'=>'admin'])
            ->where('name','!=','Add Permissions')
            ->orderBy('type_order','desc')
            ->latest()
            ->get();
        $userPermissions=$admin->permissions()->pluck('id')->toArray();
        return view('admin.adminPermissions.edit',
            [
                'admin'=>$admin,
                'permissions'=>$permissions,
                'userPermissions'=>$userPermissions,
            ]);
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
        $this->validate($request,[
            'permissions.*'=>'required|exists:permissions,id',
        ]);
        $admin=Admin::findOrFail($id);
        $admin->syncPermissions($request->permissions);
        toastr()->success('تمت العملية بنجاح !','تهانينا');
        return redirect()->route('adminPermissions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permissions=Admin::findOrFail($id)->permissions()->get();
        foreach ($permissions as $permission){
            Admin::findOrFail($id)->revokePermissionTo($permission->name);
        }
        return response(['error'=>''],200);
    }

}
