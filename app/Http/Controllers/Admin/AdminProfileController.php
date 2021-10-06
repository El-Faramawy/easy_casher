<?php

namespace App\Http\Controllers\Admin;

use App\Http\Traits\Upload_Files;
use App\Models\Admin;
use App\Http\interfaces\AdminInterface;
use App\Http\Requests\UpdateAdmin;
use App\Rules\UpdatedUniqueAttribute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class AdminProfileController extends Controller
{
    use Upload_Files;
    public function __construct()
    {

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.profile.index')->with(['admin'=>\admin()->user()]);
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
    public function edit(Request $request,$id)
    {
        if ($request->ajax()){
            $returnHTMLForSlider = view("admin.profile.parts.profile-slider")
                ->with([
                    'admin' =>Admin::findOrFail($id)
                ])
                ->render();
            $returnHTMLForProfileForm = view("admin.profile.parts.profile-for")
                ->with([
                    'admin' =>Admin::findOrFail($id)
                ])
                ->render();
            return response()->json(array('success' => true, 'slider'=>$returnHTMLForSlider , 'profileForm'=>$returnHTMLForProfileForm));

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
        $admin=Admin::findOrFail($id);
        //more validation
        $this->validate($request, [
            'name'=>'required',
            'email' =>Rule::unique('admins')->ignore($id),
            'password'=>'nullable',
            'image'=>'nullable',
        ]);
        //image
        $data = $request->all();
        if ($request->hasFile('image'))
            $data ['image'] = $this->uploadFiles('admins',$request->file('image'),$admin->image );
        else
            $data ['image'] = $admin->image;
        //password
        if ($request->has('password'))
            $data['password'] = $request->password!=null?bcrypt($request->password):$admin->password;
        else
            $data ['password'] = $admin->password;
        $admin->update($data);
        //return
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

}//end class
