<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ListVisuC extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
          if (!$_COOKIE['MakanBaMa'] or unserialize(get_cookie('MakanBaMa'))['USERTYPE'] !='hosteler')
        {
            redirect('main/VisuC');
        }
        $this->load->model('deskUser/list_visu');
    }

    function visu()
    {
        $this->middle = 'deskUser/listVisu';
        $this->layout('panelUser');
    }

    function getVisu($visu_type)
    {
        $sort=($_GET['columns'][$_GET['order'][0]['column']]['data'])==''?NULL:$_GET['columns'][$_GET['order'][0]['column']]['data'];
        $dir=$_GET['order'][0]['dir']==''? NULL:$_GET['order'][0]['dir'];
        if ($sort=='_persian_date'){
            $sort='update_date';
        }
        if ($sort=='key'){
            $sort='id';
        }
        $draw=  $this->input->get('draw');
        $start=  $this->input->get('start');
        $length=  $this->input->get('length');
        $res = $this->list_visu->getVisu($visu_type,$start,$length,$sort,$dir);
        $info=array();
        foreach ($res as $xx)
        {
            $persian_date        = jdate('H:i:s Y-m-d ', strtotime($xx['update_date']));
            $xx['_persian_date'] = $persian_date;
            $info[]              = $xx;
        }
        $r = array(
          "draw" => $draw,
            "recordsTotal" => $this->list_visu->getCountVisu($visu_type),
            "recordsFiltered" => $this->list_visu->getCountVisu($visu_type),
            "data" => $info
        );
        die(json_encode($r));
    }

    function ostensible($visu_type,$building_id, $is_show)
    {
        if (is_numeric($building_id) and ( $is_show == 0 or $is_show == 1))
        {
            $res = $this->list_visu->ostensible($building_id, $is_show);
            if ($res)
            {
    
                $this->middle = 'deskUser/listVisu';
                $this->layout('panelUser');
            }
            else
            {
                $msg['err']   = 'خطا در بروزرسانی اطلاعات در پایگاه داده!';
                $this->data   = $msg;
                $this->middle = 'deskUser/listVisu';
                $this->layout('panelUser');
            }
        }
        else
        {
                            $msg['err']   = 'داد های ارسالی نامعتبر می باشد.';
                $this->data   = $msg;
                $this->middle = 'deskUser/listVisu';
                $this->layout('panelUser');
        }
    }
    


}
