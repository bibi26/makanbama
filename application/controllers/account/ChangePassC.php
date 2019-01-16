<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ChangePassC extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('account/change_pass');
    }

    function index($user, $vc)
    {
        $res = $this->change_pass->chkCorrectUrl($user, $vc);
        if (count($res) == 1)
        {
            $this->session->set_userdata('EMAIL_H',$res[0]['email']);
            $this->middle = 'account/changePass';
            $this->layout();
        }
        else
        {
            $msg['err']   = 'اطلاعات لینک ایمیل شما نامعتبر می باشد.';
            $this->data   = $msg;
            $this->middle = 'account/changePass';
            $this->layout();
        }
    }

    function cp()
    {
        $this->form_validation->set_rules('pass1', 'رمز عبور', 'trim|required|min_length[4]', array('required' => ' لطفا رمز عبور را وارد نمایید.', 'min_length' => ' طول رمز عبور می بایست حداقل 6 کاراکتر باشد.'));
        $this->form_validation->set_rules('pass2', 'تکرار رمز عبور', 'trim|matches[pass1]', array('matches' => ' رمزعبور با تکرار آن یکسان نمی باشد.'));
        $email = $this->session->userdata('EMAIL_H');
        $pas1  = $this->input->post('pass1', TRUE);
        $pas2  = $this->input->post('pass2', TRUE);
        if ($this->form_validation->run() == false)
        {
            $this->middle = 'account/changePass';
            $this->layout();
        }
        else
        {
            $this->session->unset_userdata('EMAIL_H');
            $res = $this->change_pass->cp($email, md5($pas1));
            if ($res)
            {
                $data['msg']   = 'رمزعبور با موفقیت انجام شد.';
                $this->data   = $data;
                $this->middle = 'account/redirect';
                $this->layout();
            }
            else
            {
                $msg['err']   = 'خطا در ثبت اطلاعات در پایگاه داده!';
                $this->data   = $msg;
                $this->middle = 'account/changePass';
                $this->layout();
            }
        }
    }

}
