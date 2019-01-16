<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class HomeC extends MY_Controller
{

    function __construct()
    {

        parent::__construct();
        if (!$_COOKIE['MakanBaMa'])
        {
            redirect($this->config->item('home_url'));
        }
    }

    function index()
    {
        $this->middle = 'deskUser/home';
        $this->layout('panelPassenger');
    }

}
