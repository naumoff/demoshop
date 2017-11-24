<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 24.11.2017
 * Time: 11:44
 */

namespace App\Helpers;

trait TranslateUserStatus
{
    private function translateStatusEnToRu($enStatus)
    {
        $statuses = config('lists.user_status');
        foreach ($statuses AS $key=>$array){
            if($key == $enStatus){
                return $array['ru'];
            }
        }
        return $enStatus;
    }
}