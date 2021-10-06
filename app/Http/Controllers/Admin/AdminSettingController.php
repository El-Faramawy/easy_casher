<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Upload_Files;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    use Upload_Files;

    public function __construct()
    {
        /* $this->middleware([('permission:settings index,admin')])->only(['index']);*/
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.settings.settings');
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
    public function edit(Request $request)
    {
        /*if (!checkAdminHavePermission('settings edit'))
      {
          return response()->json(1,500);
      }*/
        if ($request->ajax()){
            //show tab based of request
            $returnHTML = view("admin.settings.parts.{$request->tab}")
                ->with([
                    'name' =>$request->tab ,
                    'settings' => \setting()
                ])
                ->render();
            return response()->json(array('success' => true, 'html'=>$returnHTML , 'tab'=>$request->tab));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Setting $setting)
    {
       $data = $request->all();

       if ($request->hasFile('header_logo'))
           $data['header_logo']= $request->hasFile('header_logo')
               ?$this->uploadFiles('settings',$request->header_logo,$setting->header_logo)
               :$setting->header_logo;

        if ($request->hasFile('footer_logo'))
            $data['footer_logo']= $request->hasFile('footer_logo')
                ?$this->uploadFiles('settings',$request->footer_logo,$setting->footer_logo)
                :$setting->footer_logo;
        Setting::updateOrCreate(['id' => 1],$data);
        return response()->json(1,200);
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
}
