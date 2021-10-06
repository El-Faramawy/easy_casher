<?php

namespace App\Http\Controllers\Admin;

use App\Http\Traits\CheckPermission;
use App\Http\Traits\Upload_Files;
use App\Models\Admin;
use App\Http\Controllers\Controller;
use App\Models\SiteText;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;


class AdminSlidersController extends Controller
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
            $sliders = Slider::latest()
                ->get();

            return DataTables::of($sliders)
                ->editColumn('image', function ($slider) {
                    return ' <img src="'.get_file($slider->image).'" class=" w-60 rounded" style="height:60px"
                             onclick="window.open(this.src)">';
                })
                ->editColumn('created_at', function ($slider) {
                    return date('Y/m/d',strtotime($slider->created_at));
                })
                ->editColumn('type', function ($slider) {
                    if ($slider->type == 'categories'){
                        return 'الاقسام';
                    }elseif ($slider->type == 'clients'){
                        return 'العملاء';
                    }elseif ($slider->type == 'suppliers'){
                        return 'الموردين';
                    }
                    elseif ($slider->type == 'expenses'){
                        return 'المصرفات';
                    }
                })
                ->addColumn('delete_all', function ($slider) {
                    return "<input style='width: 19px;' type='checkbox' class='form-control delete-all' name='delete_all' id='" . $slider->id . "'>";
                })
                ->addColumn('actions', function ($slider) {
                    return "<button   class='btn btn-info editButton' id='" . $slider->id . "'> <span class='icon-edit'></span></button>
                   <button style='display:none' class='btn btn-danger  delete' id='" . $slider->id . "'><span class='icon-delete'></span> </button>";
                })->rawColumns(['actions','image','delete_all'])->make(true);
        }
        return view('admin.sliders.index');
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
            $returnHTML = view("admin.sliders.parts.add_form")
                ->with([
                ])
                ->render();
            return response()->json(array('success' => true, 'html'=>$returnHTML));
        }
    }

    public function all_Sliders(Request $request)
    {
        if ($request->ajax()){
            $returnHTML = view("admin.sliders.parts.sliders")
                ->with([
                    'sliders' =>Slider::all()
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
            'title'=>'nullable',
            'type'=>'required',
            'desc'=>'nullable',
            'image'=>'required|file|image',
        ]);
        $data ['image'] = $this->uploadFiles('sliders',$request->file('image'),null );
        Slider::create($data);
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
            $returnHTML = view("admin.sliders.parts.edit_form")
                ->with([
                    'slider' =>Slider::findOrFail($id)
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
        $slider = Slider::findOrFail($id);
        $data = $this->validate($request,[
            'title'=>'nullable',
            'desc'=>'nullable',
            'image'=>'nullable',
            'type'=>'required',
        ]);
        try{
            if ($request->hasFile('image'))
                $data ['image'] = $this->uploadFiles('sliders',$request->file('image'),$slider->image );
            else
                $data ['image'] = $slider->image;

            $slider->update($data);
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
        return response()->json(Slider::destroy($id),200);
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
        Slider::destroy($request->id);
        return response()->json(1,200);
    }


}//end
