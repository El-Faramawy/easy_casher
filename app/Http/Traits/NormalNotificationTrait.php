<?php


namespace App\Http\Traits;

use App\Models\Notification;
use App\Models\Setting;
use App\Models\User;

trait NormalNotificationTrait
{
    /**
     * @param $type
     * @param $title_arr
     * @param $desc_arr
     * @param $ides
     * @param $action_type
     *
     */

    public function sendNormalNotificationToUser($type,$title_arr,$desc_arr,$ides,$action_type)
    {
        $type_title = $type.'_id';
       $notiication= Notification::create([
            'ar_title' => $title_arr[0],
            'en_title' => $title_arr[1],
            'ar_desc' => $desc_arr[0],
            'en_desc' =>$desc_arr[1] ,
            "{$type_title}" => $ides[0],
            'from_user_id' => $ides[1] ,
            'to_user_id' =>$ides[2] ,
            'action_type' =>$action_type ,
            "notification_date" => date('Y-m-d'),
        ]);
       return $notiication;
    }//end fun

}//end trait
