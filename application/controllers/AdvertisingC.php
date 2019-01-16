<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class AdvertisingC extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('main');
    }

    public function index()
    {
        $this->main->pageVisit('pageAdvertising');
        $this->middle      = 'advertising';
        $this->layout();
    }

}
