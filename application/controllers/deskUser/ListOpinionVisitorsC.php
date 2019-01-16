<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ListOpinionVisitorsC extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!$_COOKIE['MakanBaMa'] or unserialize(get_cookie('MakanBaMa'))['USERTYPE'] !='hosteler')
        {
            redirect($this->config->item('home_url'));
        }
        $this->load->model('deskUser/list_opinion_visitors');
    }

    function index()
    {
        $this->middle = 'deskUser/listOpinionVisitors';
        $this->layout('panelUser');
    }

    function getOpinions()
    {
        $sort=($_GET['columns'][$_GET['order'][0]['column']]['data'])==''?NULL:$_GET['columns'][$_GET['order'][0]['column']]['data'];
        $dir=$_GET['order'][0]['dir']==''? NULL:$_GET['order'][0]['dir'];
        if ($sort=='ID'){
            $sort='visitor_opinion.id';
        }
        if ($sort=='_persian_date'){
            $sort='create_date';
        }
        $draw=  $this->input->get('draw');
        $start=  $this->input->get('start');
        $length=  $this->input->get('length');
        $res  = $this->list_opinion_visitors->getOpinions($start,$length,$sort,$dir);
        $info = array();
        foreach ($res as $xx)
        {
            $persian_date        = jdate('H:i:s Y-m-d ', strtotime($xx['create_date']));
            $xx['_persian_date'] = $persian_date;
            $info[]              = $xx;
        }
        $r = array(
    "draw" => $draw,
            "recordsTotal" => $this->list_opinion_visitors->getCountOpinions(),
            "recordsFiltered" => $this->list_opinion_visitors->getCountOpinions(),
            "data" => $info
        );
        die(json_encode($r));
    }

}
