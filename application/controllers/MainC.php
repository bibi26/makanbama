<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MainC extends MY_Controller
{

    function __construct()
    {

        parent::__construct();
        $this->load->model('main');

    }

    public function index()
    {
        redirect($this->config->item('home_url'));
    }

    public function getProvince()
    {
        $res = $this->main->getProvince();
        die(json_encode(array('status' => 'ok', 'msg' => $res)));
    }

    public function getCity()
    {
        $province = $this->input->post('provinceId');
        $res      = $this->main->getCity($province);
        die(json_encode(array('status' => 'ok', 'msg' => $res)));
    }
}
