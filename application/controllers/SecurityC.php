<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class SecurityC extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('main');
    }

    public function index()
    {
        $this->main->pageVisit('pageSecurity');
        $this->middle = 'security';
        $this->layout();
    }

}
