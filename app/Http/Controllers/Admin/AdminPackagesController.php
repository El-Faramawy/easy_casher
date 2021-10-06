<?php

namespace App\Http\Controllers\Admin;

use App\Http\Traits\CheckPermission;
use App\Http\Controllers\Controller;
use App\Http\Traits\Upload_Files;
use App\Models\Packages;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class AdminPackagesController extends Controller
{
    use Upload_Files, CheckPermission;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $datas = Packages::latest()
                ->get();

            return DataTables::of($datas)
                ->editColumn('image', function ($datas) {
                    return ' <img height="60px" src="' . get_file($datas->image) . '" class=" w-60 rounded"
                             onclick="window.open(this.src)">';
                })
                ->editColumn('created_at', function ($datas) {
                    return date('Y/m/d', strtotime($datas->created_at));
                })
                ->editColumn('is_free', function ($datas) {
                    if ($datas->is_free == 'yes'){
                        return 'مجانية';
                    }else{
                        return 'غير مجانية';
                    }
                })
                ->editColumn('is_shown', function ($datas) {
                    if ($datas->is_showing == 'show'){
                        return 'معروضة';
                    }else{
                        return 'غير معروضة';
                    }
                })
                ->addColumn('delete_all', function ($datas) {
                    return "<input style='width: 19px;' type='checkbox' class='form-control delete-all' name='delete_all' id='" . $datas->id . "'>";
                })
                ->addColumn('actions', function ($datas) {
                    return "<button  class='btn btn-info editButton' id='" . $datas->id . "'> <span class='icon-edit'></span></button>
                   <button class='btn btn-danger  delete' id='" . $datas->id . "'><span class='icon-delete'></span> </button>";
                })->rawColumns(['actions', 'image','is_shown','is_free', 'delete_all'])->make(true);
        }
        return view('admin.Packages.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        if ($request->ajax()) {
            $returnHTML = view("admin.Packages.parts.add_form")
                ->with([
                ])
                ->render();
            return response()->json(array('success' => true, 'html' => $returnHTML));
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

        $data = $this->validate($request, [
            'title' => 'required',
            'price' => 'nullable|numeric',
            'num_of_days' => 'nullable|numeric',
            'image' => 'nullable',
            'is_showing' => 'nullable',
            'is_free' => 'nullable',

        ]);

        $validator = Validator::make($request->all(), [ // <---
            'price'=>['required'],
        ]);
        if ($validator->fails()){
             $data['price'] = 0;
        }


        if ($request->image) $data ['image'] = $this->uploadFiles('admins', $request->file('image'), null);
        Packages::create($data);
        return response()->json(1, 200);
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
    public function edit($id,Request $request)
    {
        if ($request->ajax()) {
            $returnHTML = view("admin.Packages.parts.edit_form")
                ->with([
                    'find' => Packages::findOrfail($id)
                ])
                ->render();
            return response()->json(array('success' => true, 'html' => $returnHTML));
        }
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
        $data = $this->validate($request, [
            'title' => 'required',
            'price' => 'nullable|numeric',
            'num_of_days' => 'nullable|numeric',
            'image' => 'nullable',
            'is_showing' => 'nullable',
            'is_free' => 'nullable',

        ]);

        $validator = Validator::make($request->all(), [ // <---
            'price'=>['required'],
        ]);
        if ($validator->fails()){
            $data['price'] = 0;
        }


        if ($request->image) $data ['image'] = $this->uploadFiles('admins', $request->file('image'), null);
        Packages::find($id)->update($data);
        return response()->json(1, 200);
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
        return response()->json(Packages::destroy($id), 200);
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
        Packages::destroy($request->id);
        return response()->json(1, 200);
    }
}
