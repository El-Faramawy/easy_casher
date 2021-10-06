<?php


namespace App\Http\Traits\ForCashier;


use App\Models\Account;

trait AccountCreating
{

    public function createAccount( $display_title ,$model_id ,$model_type , $user_id , $added_by_id)
    {
        $user_type = ($model_type == 'App/Models/User') ?($added_by_id == $user_id ) ? 'parent':'child':'parent';
        Account::create([
            'display_title' => $display_title,
            'model_id' => $model_id,
            'model_type' => $model_type,
            'user_id' => $user_id,
            'added_by_id' => $added_by_id,
            'user_type' => $user_type,
        ]);

    }//end function

}//end trait
