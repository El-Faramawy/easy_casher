<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\DestroyModelRow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminRolesController extends Controller
{
    use DestroyModelRow;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles=Role::get();
        return view('admin.roles.index',['roles'=>$roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $guards=collect(config('auth.guards'))->forget('api');
        return view('admin.roles.create',['guards'=>$guards]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name'=> 'required|max:255',
            'guard_name'  => [
                'required',
                Rule::unique('roles')->where(function ($query) use ($request) {
                    return $query
                        ->whereName($request->name)
                        ->whereGuardName($request->guard_name);
                }),
            ],
            'permissions'=>'required'
        ],
            [
                'guard_name.unique' => __('messages.roles.error.unique', [
                    'name'=> $request->name,
                    'guard_name'     => $request->guard_name
                ]),
            ]);

        try{
            DB::beginTransaction();
            $role=Role::create($request->except('permissions'));
            $permissions=Permission::whereIn('id',$request->permissions)->get();
            $role->syncPermissions($permissions);
            DB::commit();
            toastr()->success('تمت العملية بنجاح !','تهانينا');
            return redirect()->route('roles.index');
        }catch (\Exception $exception){
            DB::rollBack();
            toastr()->error($exception->getMessage());
            return redirect()->route('roles.index');
        }

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
    public function edit(Role $role)
    {
        $guards=collect(config('auth.guards'))->forget('api');
        return view('admin.roles.edit',['guards'=>$guards,'role'=>$role]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        request()->validate([
            'name'=>'required|max:255',
            'guard_name'  => [
                'required',
                Rule::unique('roles')->where(function ($query) use ($request, $role) {
                    return $query
                        ->whereName($request->name)
                        ->whereGuardName($request->guard_name)
                        ->whereNotIn('id', [$role->id]);
                }),
            ],
            'permissions'=>'required'
        ],
            [
                'guard_name.unique' => __('messages.roles.error.unique', [
                    'name' => $request->name,
                    'guard_name'      => $request->guard_name
                ]),
            ]);
        try{
            DB::beginTransaction();
            $role->update($request->except('permissions'));
            //get all permissions of this role
            $role_permissions=$role->permissions;
            // dd($role_permissions);
            foreach ($role_permissions as $role_permission){
                $role->revokePermissionTo($role_permission);
            }
            //add new permissions to role
            $permissions=Permission::whereIn('id',$request->permissions)->get();
            $role->syncPermissions($permissions);
            DB::commit();
            toastr()->success('تمت العملية بنجاح !','تهانينا');
            return redirect()->route('roles.index');
        }catch (\Exception $exception){
            DB::rollBack();
            toastr()->error($exception->getMessage());
            return redirect()->route('roles.index');
        }

    }//end

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $this->destroy_row($role);
    }


    /**
     *
     * return permissions based on guard name for create
     *
     */

    public function get_permission_based_on_guard_name(Request $request)
    {
        $permissions=Permission::where('guard_name',$request->guard_name)->get();
        if ($permissions->count()>0){
            return response(['message'=>'','permissions'=>$permissions]);
        }
        return response(['message'=>'لم يتم اضافة أى صلاحيات فى هذا الجارد','permissions'=>$permissions]);
    }//end function

    /**
     *
     * return permissions based on guard name for Update
     *
     */

    public function get_permission_based_on_guard_nameInEdit(Request $request)
    {
        $role=Role::where('id',$request->role_id)->with('permissions')->first();
        $rolePermissionIds=$role->permissions->pluck('id')->toArray();
        $permissions=Permission::where('guard_name',$request->guard_name)->get();
        if ($permissions->count()>0){
            $i=0;
            foreach ($permissions as $permission){
                if (in_array($permission->id,$rolePermissionIds)){
                    $permissions[$i++]->check='checked';
                }else{
                    $permissions[$i++]->check='';
                }
            }
            return response(['message'=>'','permissions'=>$permissions]);
        }
        return response(['message'=>'لم يتم اضافة أى صلاحيات فى هذا الجارد','permissions'=>$permissions]);
    }//end function


}//end class

