<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ResponseOpinionVisitorsC extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!$_COOKIE['MakanBaMa'] or unserialize(get_cookie('MakanBaMa'))['USERTYPE'] != 'hosteler')
        {
            redirect($this->config->item('home_url'));
        }
        $this->load->model('deskUser/response_opinion_visitors');
    }

    function detail($opinion_id)
    {
        $res_detail   = $this->response_opinion_visitors->getDetailOpinion($opinion_id);
        $res_response = $this->response_opinion_visitors->getResponseOpinion($opinion_id);
        $data         = array('_detailOpinion' => $res_detail, '_responseOpinion' => $res_response);
        $this->data   = $data;
        $this->middle = 'deskUser/responseOpinionVisitors';
        $this->layout('panelUser');
    }

    function regist()
    {
        $opinion_id       = $this->input->post('opinion_id');
        $response_opinion = $this->input->post('response_opinion');
        $res              = $this->response_opinion_visitors->regist($opinion_id, $response_opinion);
        if ($res)
        {
            redirect('deskUser/listOpinionVisitorsC/');
        }
        else
        {

            $data['err']  = 'خطا در ثبت اطلاعات در پایگاه داده!';
            $this->data   = $data;
            $this->middle = 'deskUser/responseOpinionVisitors';
            $this->layout('panelUser');
        }
    }

}
