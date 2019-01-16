<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ListItemC extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
          if (!$_COOKIE['MakanBaMa'] or unserialize(get_cookie('MakanBaMa'))['USERTYPE'] !='adminSuper')
        {
            redirect('main/VillaC');
        }
        $this->load->model('deskAdmin/list_item');
    }

    function index()
    {
        $this->middle = 'deskAdmin/listItem';
        $this->layout('panelAdmin');
    }

    function getItems()
    {
        $draw=  $this->input->get('draw');
        $start=  $this->input->get('start');
        $length=  $this->input->get('length');
        $res = $this->list_item->getItems($start,$length);
        $info=array();
        foreach ($res as $xx)
        {
            $persian_date        = jdate('H:i:s Y-m-d ', strtotime($xx['update_date']));
            $xx['_persian_date'] = $persian_date;
            $info[]              = $xx;
        }
        $r = array(
          "draw" => $draw,
            "recordsTotal" => $this->list_item->getCountItems(),
            "recordsFiltered" => $this->list_item->getCountItems(),
            "data" => $info
        );
        die(json_encode($r));
    }

}
