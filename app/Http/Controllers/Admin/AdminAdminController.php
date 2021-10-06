<?php

namespace App\Http\Controllers\Admin;

use App\Http\Traits\CheckPermission;
use App\Http\Traits\Upload_Files;
use App\Models\Admin;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;


class AdminAdminController extends Controller
{

    use Upload_Files, CheckPermission;


    public function __construct()
    {
        /* $this->middleware([('permission:admins index,admin')])->only(['index']);*/
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $admins = Admin::where('id', '!=', auth('admin')
                ->user()->id)
                ->latest()
                ->get();

            return DataTables::of($admins)
                ->editColumn('image', function ($admin) {
                    return ' <img height="60px" src="' . get_file($admin->image) . '" class=" w-60 rounded"
                             onclick="window.open(this.src)">';
                })
                ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->addColumn('delete_all', function ($admin) {
                    return "<input style='width: 19px;' type='checkbox' class='form-control delete-all' name='delete_all' id='" . $admin->id . "'>";
                })
                ->addColumn('actions', function ($admin) {
                    return "<button  class='btn btn-info editButton' id='" . $admin->id . "'> <span class='icon-edit'></span></button>
                   <button class='btn btn-danger  delete' id='" . $admin->id . "'><span class='icon-delete'></span> </button>";
                })->rawColumns(['actions', 'image', 'delete_all'])->make(true);
        }
        return view('admin.admins.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        /*if (!checkAdminHavePermission('admins create'))
        {
            return response()->json(1,500);
        }*/
        /* $this->check_permisssions('admins create');*/
        if ($request->ajax()) {
            $returnHTML = view("admin.admins.parts.add_form")
                ->with([
                ])
                ->render();
            return response()->json(array('success' => true, 'html' => $returnHTML));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:admins,email',
            'password' => 'required',
            'image' => 'required|file|image',
        ]);
        $data['password'] = bcrypt($request->password);
        $data ['image'] = $this->uploadFiles('admins', $request->file('image'), null);
        Admin::create($data);
        return response()->json(1, 200);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        /* if (!checkAdminHavePermission('admins edit'))
         {
             return response()->json(1,405);
         }*/
        if ($request->ajax()) {
            $returnHTML = view("admin.admins.parts.edit_form")
                ->with([
                    'admin' => Admin::findOrFail($id)
                ])
                ->render();
            return response()->json(array('success' => true, 'html' => $returnHTML));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);
        $data = $this->validate($request, [
            'name' => 'required',
            'email' => Rule::unique('admins')->ignore($id),
            'password' => 'nullable',
            'image' => 'nullable',
        ]);
        try {

            if ($request->password)
                $data['password'] = bcrypt($request->password);
            else
                $data['password'] = $admin->password;


            if ($request->hasFile('image'))
                $data ['image'] = $this->uploadFiles('admins', $request->file('image'), $admin->image);

            $admin->update($data);
            return response()->json(1, 200);
        } catch (Exception $exception) {
            return response()->json($exception->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        /* if (!checkAdminHavePermission('admins delete'))
         {
             return response()->json(1,500);
         }*/
        return response()->json(Admin::destroy($id), 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */

    public function delete_all(Request $request)
    {
        /* if (!checkAdminHavePermission('admins multiDelete'))
         {
             return response()->json(1,500);
         }*/
        Admin::destroy($request->id);
        return response()->json(1, 200);
    }


}//end
