<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class detailItemC extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!$_COOKIE['MakanBaMa'] or unserialize(get_cookie('MakanBaMa'))['USERTYPE'] !='adminSuper')
        {
            redirect('main/VillaC');
        }
        $this->load->model('deskAdmin/detail_item');
    }

    function detail($buillding_id)
    {
        $this->session->set_userdata('BUILDING', $buillding_id);
        $res_info       = $this->detail_item->detail($buillding_id);
                $res_opinion_villa = $this->detail_item->getOpinionItem($buillding_id);
        $data ['_opinionVilla'] = $res_opinion_villa;
        $data['result'] =  $res_info;
        $this->data     = $data;
        $this->middle   = 'deskAdmin/detailItem';
        $this->layout('panelAdmin');
    }

}
