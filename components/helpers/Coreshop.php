<?php
/**
 * Created by PhpStorm.
 * User: arad
 * Date: 2018. 03. 18.
 * Time: 19:28
 */

namespace app\components\helpers;

class Coreshop
{

    public static function randomPassword($length = 6)
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public static function GlsDeliveryDate()
    {

        $leadas_napi_hatarido = '15:30'; //16 ora
        $unnepnapok = [];

        if (!in_array((date('Ymd')), $unnepnapok)) {

            switch (date('w')) {

                //vas
                case 0:
                    $delivery_date = date('Y. F d. D', strtotime("next Tuesday"));
                    break;

                //csut
                case 4:
                    {
                        if (date('H:i') < $leadas_napi_hatarido)
                            $delivery_date = date('Y. F d. D', strtotime("+1 day"));
                        else
                            $delivery_date = date('Y. F d. D', strtotime("next Monday"));
                        break;
                    }

                //pen
                case 5:
                    {
                        if (date('H:i') < $leadas_napi_hatarido)
                            $delivery_date = date('Y. F d. D', strtotime("next Monday"));
                        else
                            $delivery_date = date('Y. F d. D', strtotime("next Tuesday"));
                        break;
                    }

                //szo
                case 6:
                    $delivery_date = date('Y. F d. D', strtotime("next Tuesday"));
                    break;

                // het, kedd, sze
                default:
                    {
                        if (date('H:i') < $leadas_napi_hatarido)
                            $delivery_date = date('Y. F d. D', strtotime("+1 day"));
                        else
                            $delivery_date = date('Y. F d. D', strtotime("+2 day"));

                        break;
                    }
            }
        } //unnepnapok
        else
            $delivery_date = $unnepnapok[date('Ymd')];

        return $delivery_date;
    }

    public static function RemainingDispatchTime()
    {
        $startdate = date("Y-m-d H:i:s"); //current datetime
        // h-cs 15:00 elott
        if ((date('H') < 15) && (date('w') !== 5))
            $enddate = date('Y-m-d H:i:s', strtotime('today 3:00 pm'));
        else
            $enddate = date('Y-m-d H:i:s', strtotime('+1 day 3:00 pm'));


        // hetvegen
        if (date('w') == 0)
            $enddate = date('Y-m-d H:i:s', strtotime('monday 3:00 pm'));

        $diff = strtotime($enddate) - strtotime($startdate);
        $temp = $diff / 86400;
        // days
        $days = floor($temp);
        $temp = 24 * ($temp - $days);
        // hours
        $hours = floor($temp);
        $temp = 60 * ($temp - $hours);
        // minutes
        $minutes = floor($temp);
        $temp = 60 * ($temp - $minutes);
        // seconds
        $seconds = floor($temp);

        $dispatch = "Csomagfeladás ";
        if ($days > 0)
            $dispatch .= $days . " nap ";
        if ($hours > 0)
            $dispatch .= ($hours + 1) . " órán belül."; //+1 ora
        else
            $dispatch .= " 1 órán belül.";


        // pentek 15:00 utan
        if ((date('w') == 5) && (date('H') >= 15)) {
            if ($_SESSION["langStr"] == "hu")
                $enddate = date('Y-m-d H:i:s', strtotime('nextmonday 3:00 pm'));
            else
                $dispatch = '';
        }

        return $dispatch;
    }

    public static function dateToHU($str)
    {
        $en = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun");
        $hu = array("január", "február", "március", "április", "május", "június", "július", "augusztus", "szeptember", "október", "november", "december", "hétfő", "kedd", "szerda", "csütörtök", "péntek", "szombat", "vasárnap");

        return str_replace($en, $hu, $str);
    }

}