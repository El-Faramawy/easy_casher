<?php


namespace App\Http\Traits;


use App\Models\Setting;
use Illuminate\Support\Facades\Mail;

trait SendEmail
{

    /**
     * @param $email
     * @param $text
     * @param $subject
     *
     */
   protected function send_EmailFun($email,$text,$subject){
       $setting=Setting::first();
       $contact_company=$setting->ar_title;
       Mail::send([
           'html' => 'admin.settings.email-tem'],
           ['text' => $text,'email'=>$email,'logo'=>$setting->header_logo,'title'=>$contact_company],
           function($message) use ($email, $subject, $contact_company)
           {
               $message->to($email,$contact_company)->subject($subject);
           }
       );
   }//end fun

}//end trait
