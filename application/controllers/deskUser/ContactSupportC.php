<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ContactSupportC extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!$_COOKIE['MakanBaMa'] or unserialize(get_cookie('MakanBaMa'))['USERTYPE'] !='hosteler')
        {
            redirect($this->config->item('home_url'));
        }

        $this->load->model('deskUser/contact_support');
    }

    function index()
    {
        $this->middle = 'deskUser/contactSupport';
        $this->layout('panelUser');
    }

    function registRequest()
    {
        $this->form_validation->set_rules('request_txt', 'شماره همراه', 'trim|required', array('required' => 'لطفا درخواست و یا انتقاد ویامشکل خور را در کادر مربوطه عنوان کنید.'));
        $request_txt = $this->input->post('request_txt', TRUE);


        if ($this->form_validation->run() == false)
        {
            $this->middle = 'deskUser/contactSupport';
            $this->layout('panelUser');
        }
        else
        {

            $res_insert = $this->contact_support->registRequest($request_txt);
            if ($res_insert)
            {

                $data['ok']   = ' پیام شما با موفقیت ارسال شد. لطفاً منتظر پاسخ بخش پشتيبانی بمانید. ';
                $this->data   = $data;
                $this->middle = 'deskUser/contactSupport';
                $this->layout('panelUser');
            }
            else
            {

                $data['err']  = 'خطا در ثبت اطلاعات در پایگاه داده!';
                $this->data   = $data;
                $this->middle = 'deskUser/contactSupport';
                $this->layout('panelUser');
            }
        }
    }

}
