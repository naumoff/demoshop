<?php
/**
 * Created by PhpStorm.
 * User: Back-end PC
 * Date: 19.12.2017
 * Time: 12:56
 */

namespace App\Services;

use App\Order;
use Carbon\Carbon;


class InvoiceAndOrderNumberGeneratorService
{
    public static function getNextOrderNumber()
    {
        $today = Carbon::today();
        $year = $today->year;
        $nextOrderId = Order::getNextOrderId();
        return $year.'-'.$nextOrderId;
    }

    public static function getNextInvoiceNumber()
    {
        $nextOrderId = Order::getNextOrderId();
        return $nextOrderId;
    }
}