<?php


namespace App\Http\Traits;


trait CheckPermission
{

    function check_permisssions($permission_name)
    {
        if (!checkAdminHavePermission($permission_name))
        {
            return response()->json(1,500);
        }
    }

}//end trait
