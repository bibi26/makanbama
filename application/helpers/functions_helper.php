<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('hash_password'))
{

    function hash_password($password)
    {
        $pre_salt        = '$2y$10$';
        $salt            = md5(uniqid(mt_rand(), 'true'));
        $hashed_password = crypt($password, ($pre_salt
                . $salt));
        return $hashed_password;
    }

}
if (!function_exists('statusItems'))
{

    function statusItems($val)
    {
        if ($val == 0)
        {
            return 'منتظر تایید';
        }
        elseif ($val == 1)
        {
            return 'رد';
        }
        elseif ($val == 3)
        {
            return 'تایید';
        }
        else
        {
            return 'تعریف نشده';
        }
    }

}

function limitword($string, $limit)
{
    $words  = explode(" ", $string);
    $output = implode(" ", array_splice($words, 0, $limit));
    return $output;
}

function generateRandomString($length = 10)
{
    $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString     = '';
    for ($i = 0; $i < $length; $i++)
    {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if (!function_exists('check_password'))
{

    function check_password($password_input, $password_main)
    {
        $hash = crypt($password_input, $password_main);
        if ($hash ===
                $password_main)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

}

if (!function_exists('getUserIP'))
{

    function getUserIP()
    {
        $ipaddress = '';
        if (
                getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv(
                        'HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (
                getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (
                getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'
                ))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

}

function checkSSN($ssn)
{
    //output array
    $output = array(
        'success' => FALSE, 'message' => 'خطا!'
    );

    //filter ssn
    $ssn = preg_replace('/[^0-9]/', '', trim($ssn));

    //length should be 10 digits
    if (strlen($ssn) <= 9)
    {

        $output['message'] = 'ده رقم کد ملی را وارد نمایید';
        return $output;
    }

    //initial validate ssn
    if (!preg_match('/^[0-9]{10}$/', $ssn))
    {
        $output['message'] = 'لطفا ده رقم کد ملی را وارد نمایید';
        return $output;
    }

    //check digit and other staff
    if ($ssn == '2222222222' OR $ssn == '3333333333' OR $ssn == '4444444444' OR $ssn == '5555555555' OR $ssn == '6666666666' OR $ssn == '7777777777' OR $ssn == '8888888888' OR $ssn == '9999999999')
    {
        $output ['message'] = 'کد ملی صحیح نیست';
        return $output;
    }

    $lastChar   = intval(substr($ssn, 9, 1));
    $checkDigit = 0;
    for ($j = 0; $j <= 8; $j++)
    {
        $checkDigit += intval(substr($ssn, $j, 1)) * (10 - $j);
    }

    $remind = $checkDigit - intval($checkDigit / 11) * 11;

    if (($remind == 0 AND $remind == $lastChar) OR ( $remind == 1 AND $lastChar == 1) OR ( $remind > 1 AND $lastChar == 11 - $remind))
    {
        $output['success'] = TRUE;
        $output['message'] = 'کد ملی صحیح است';
        return $output;
    }
    else
    {
        $output['message'] = 'چنین کد ملی وجود ندارد';
        return $output;
    }
}
