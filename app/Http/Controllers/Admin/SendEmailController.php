<?php

namespace App\Http\Controllers\Admin;

use App\Http\Traits\SendEmail;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SendEmailController extends Controller
{
    use SendEmail;

    /**
     * @param $email_type
     *
     * Check emaul type
     */

    public function check_email_type($request)
    {
        if ($request->email_type==0){
            $emails=User::pluck('email')->toArray();
            foreach ($emails as $email){
                $this->send_EmailFun($email,$request->text,$request->subject);
            }
        }

        if ($request->email_type==1){
            $this->send_EmailFun($request->user_email,$request->text,$request->subject);

        }

        if ($request->email_type==2){
            $this->send_EmailFun($request->email,$request->text,$request->subject);
        }

    }//ens

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('admin.email-send.send_email',['users'=>User::get()]);
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
        //
    }

    public function send_Email(Request $request)
    {
        $this->check_email_type($request);
        toastr()->success('تم الارسال بنجاح','تهانينا ');
        return redirect()->route('admin.dashboard');
    }//end fun

}
