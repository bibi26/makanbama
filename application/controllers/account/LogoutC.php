<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class LogoutC extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
    }


    function index()
    {
        if (isset($_COOKIE['MakanBaMa']))
        {
            $cookie = array(
                'name' => 'MakanBaMa',
                'value' => '',
                'expire' => 0,
                'domain' => $this->config->item('domain'),
                'path' => '/'
            );

            $this->input->set_cookie($cookie);
            redirect('mainC/');
        }
        else
        {
            die('no COOKIE');
        }
    }   

}
