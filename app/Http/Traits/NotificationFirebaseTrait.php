<?php


namespace App\Http\Traits;


use App\Models\FirebaseToken;
use App\Models\Setting;
use App\Models\User;

trait NotificationFirebaseTrait
{
    /*
       |--------------------------------------------------------------------------
       | send Firebase Notification
       |--------------------------------------------------------------------------
       |
       |this function take a 3 params
       |1- array of users Id , you want to sent
       |2-single id to get the name of sender
       |3-mess array to send
       |
       | Support: "ios ", "android"
       |
       */
    public function sendFCMNotification($array_to,$from,$mess){

       // $API_ACCESS_KEY = env('FIREBASE_KEY');
        $API_ACCESS_KEY = "AAAADx6iG1E:APA91bEQ77aK2EYRyy3hbHR1qjSwCr2znWqdTfs2qPC1fzkZBw4XNNaKNS0d9DBhVhb4g-1NWeHZHcibp5rojfRyaXb3SyOPYiLsYqaZUbYtSF_2NUeOuwx3vc7g7aURMa_SQshgBARM";
        //-------------------------------------------------------
        $tokens =FirebaseToken::whereIn("user_id", $array_to)->get();
        if ($from!=null){
            $fromUser = User::find($from)->name;
        }else{
            $fromUser=Setting::first()->ar_title;
        }
        $mess['fromUserName'] = $fromUser;
        //--------------------------------------------------------
        $android_tokens = null;
        $ios_tokens = null;
        //check the tokens software types
        foreach ($tokens as $item) {
            if ($item->software_type == 'android') {
                $android_tokens[] = $item->phone_token;
            } else if ($item->software_type == 'ios'){
                $ios_tokens[] = $item->phone_token;
            }
        }
        //-------------------------------------------------------
        /*if ($i==3){
            dd($android_tokens);
        }*/
        $this->send_to_android_devices($android_tokens,$API_ACCESS_KEY,$mess);
        $this->send_to_ios_devices($ios_tokens,$API_ACCESS_KEY,$mess);
        //  dd(1);
    }
    //------------------Send To Android Device---------------
    private function send_to_android_devices($android_tokens,$API_ACCESS_KEY,$notifications)
    {
        //handle android tokens
        if ($android_tokens != null) {
            //prep the android payload
            $fields = array
            (
                'registration_ids' => $android_tokens,
                'data' => $notifications
            );

            //Generating JSON encoded string form the above array.
            $json = json_encode($fields);
            //Setup headers:
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Authorization: key= '.$API_ACCESS_KEY; // key here
            //Setup curl, add headers and post parameters.
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            /* curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
             curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
             curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);*/
            $result = curl_exec($ch);
            curl_close($ch);
        }
    }//end fun
    //------------------Send To Ios Device-------------------
    private function send_to_ios_devices($ios_tokens,$API_ACCESS_KEY,$notifications)
    {
        //handle ios tokens
        if ($ios_tokens != null) {
            $notifications['sound'] = 'default';
            $fields = array
            (
                'registration_ids' => $ios_tokens,
                'notification' => $notifications,
                'data' => $notifications
            );

            $headers = array
            (
                'Authorization: key=' . $API_ACCESS_KEY,
                'Content-Type: application/json'
            );
            $ch = curl_init();
            $json = json_encode($fields);
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            $result = curl_exec($ch);
            curl_close($ch);
        }
    }//end fun
    //--------------------------------------------------------
}
