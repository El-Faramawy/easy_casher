<?php


namespace App\Http\Traits\Api;


use App\Http\Traits\SendEmail;
use App\Http\Traits\SMSTrait;
use App\Models\User;


trait ApiUserTrait
{
    use SendEmail;

    /**
     * @param $user
     *
     */
    protected function generate_confirm_code_and_send_it($user)
    {
        //save code in password forget code
        $code = rand(11111,99999);
        $user->email_verification_code = $code;
        $user->save();
        //send email
        $email_text = $code .'<br>'. 'كود التفعيل';
        $this->send_EmailFun($user->email, $email_text, 'كود التفعيل');
    }


    /**
     * @param $id
     * @return mixed
     *
     */
    protected function getUser($id){
        return User::where('id',$id)->firstOrFail();
    }


    /**
     * @param $user
     * @return mixed
     *
     *
     */
    protected function add_passport_token_to_user($user){
        $token=$user->createToken('MyApp')-> accessToken;
        $user=$this->getUser($user->id);
        $user->token=$token;
        return $user;
    }

    /**
     * @param $user
     * @return int
     *
     */

    public function checkIfUserCanLogin($user){
        //user is block
        if ($user->is_block == 'blocked') {
            return 406;
        }
        //user not confirmed
        if ($user->is_confirmed == 'no') {
            return 407;
        }
        //user in success
        $user->is_login = 'connected';
        $user->save();
        return 22;
    }



}//end trait
