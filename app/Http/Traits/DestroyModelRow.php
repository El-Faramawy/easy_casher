<?php


namespace App\Http\Traits;




trait DestroyModelRow
{
    /**
     * @param $model
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */

    //return response to ajax
    public function destroy_row($model){
        $good= $model->delete();
        if ($good)
            return response(['error'=>0]);
        else
            return response(['error'=>1]);
    }



}//end trait