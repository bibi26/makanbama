<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class WhyMakanBamaC extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('main');
    }

    public function index()
    {
        $this->main->pageVisit('pageWhyMakanBama');
        $this->middle = 'whyMakanBama';
        $this->layout();
    }

}
