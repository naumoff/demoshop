<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 04.12.2017
 * Time: 17:02
 */

namespace App\Helpers;


trait DateTimeManipulation
{
    private function transformDateTime($date)
    {
        $date = str_replace(' ','T',$date);
        $date = str_replace('.','-',$date);
        return $date;
    }
}