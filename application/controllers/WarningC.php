<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class WarningC extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('main');
    }

    public function index()
    {
        $this->main->pageVisit('pageWarning');
        $this->middle = 'warning';
        $this->layout();
    }

}
