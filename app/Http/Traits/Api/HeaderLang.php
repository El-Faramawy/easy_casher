<?php


namespace App\Http\Traits\Api;


trait HeaderLang
{

    /**
     * @param $lang
     *
     * check if the lang in the array of lang or not
     *
     */

    protected function check_the_lang($lang){
        if (in_array($lang,array('ar','en'))){
            return true;
        }
        return false;
    }



    protected function lang_of_header($lang){
        if ($lang==null){
            return $lang = 'ar';
        }
        if ($this->check_the_lang($lang)) {
            return $lang ;
        }
        return false;
    }//end fun


}//end class