<?php


namespace App\Http\Traits;


trait ApiResponseTrait
{


    //using to return api response
    public function apiResponse($data,$code){
        return response($data,$code);
    }


    public function checkPagination($type , $data)
    {
        if ($type == 'on')
         return   $data->paginate(8);
        else
         return  ['data' =>$data->get()];
    }

}//end class
