<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class HomeC extends MY_Controller
{

    function __construct()
    {

        parent::__construct();
          if (!$_COOKIE['MakanBaMa'] or unserialize(get_cookie('MakanBaMa'))['USERTYPE'] !='adminSuper')
        {
            redirect('main/VillaC');
        }
    }

    function index()
    {
        $this->middle = 'deskAdmin/home';
        $this->layout('panelAdmin');
    }

}
