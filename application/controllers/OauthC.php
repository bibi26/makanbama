<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class OuthC extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        # Change 'example.org' to your domain name.
        $domain = 'http://makanbama.ir';
        $openid = new LightOpenID($domain);

        if (!$openid->mode)
        {
            if (isset($_GET['login']))
            {
                $openid->identity = 'https://www.google.com/accounts/o8/id';
                header('Location: ' . $openid->authUrl());
            }
        }
        elseif ($openid->mode == 'cancel')
        {
            echo 'User has canceled authentication!';
        }
        else
        {
            echo 'User ' . ($openid->validate() ? $openid->identity . ' has ' : 'has not ') . 'logged in.';
        }
    }
    

}
