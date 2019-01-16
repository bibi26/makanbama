<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ForgetPasswordC extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('account/forget_password');
    }

    function index()
    {
        $this->middle = 'account/forgetPassword';
        $this->layout();
    }

    function retrieval()
    {
        $this->form_validation->set_rules('email', 'ایمیل', 'trim|required|valid_email', array('required' => ' لطفا ایمیل را وارد نمایید.', 'valid_email' => ' ایمیل معتبر نمی باشد.'));

        $email = $this->input->post('email', TRUE);


        if ($this->form_validation->run() == false)
        {
            $this->middle = 'account/forgetPassword';
            $this->layout();
        }
        else
        {
            $res_chk = $this->forget_password->chkExistEmail($email);
            if (count($res_chk) == 1)
            {
                if ($res_chk[0]['status']==3)
                {
                    $base_url            = base_url();
                    $verify_code         = generateRandomString(20);
                    $config              = array();
                    $config['useragent'] = "CodeIgniter";
                    $config['protocol']  = "smtp";
                    $config['smtp_host'] = $this->config->item('domain');
                    $config['smtp_port'] = "25";
                    $config['mailtype']  = 'html';
                    $config['charset']   = 'utf-8';
                    $config['newline']   = "\r\n";
                    $config['wordwrap']  = TRUE;
                    $this->load->library('email');
                    $this->email->initialize($config);
                    $from                = 'amirian.tat2@gmail.com';
                    $to                  = 'amirian.tat2@gmail.com'; //$input['email']
                    $subject             = 'تایید ثبت نام در سایت مکان با ما';
                    $message             = <<<EOT
                    <div style='background-color:red;height:40px;width:300px;text-align:right;'>با عرض سلام</div>
                    <div style='background-color:red;height:40px;width:300px;text-align:right;'>لطفا برای تغییر رمز عبور خود بر روی لینک ذیل کلیک کنید :</div>
                    <div style='background-color:red;height:40px;width:300px;text-align:right;'><a href='{$base_url}/account/changePassC/index/{$res_chk[0]['id']}/{$verify_code}'>فعالسازي حساب کاربري در مکان با ما</a></div>
EOT;
//                    $message             = "<b style='color:red;'>با سلام </b><br/>براي فعالسازي حساب کاربري خود بر روي لينک ذيل کليک کنيد <br/><a href='localhost/account/verifyAccountC/{$verify_code}'>فعالسازي حساب کاربري در مکان با ما</a>";
                    $this->email->from($from, 'behzad');
                    $this->email->to($to);
                    $this->email->subject($subject);
                    $this->email->message($message);

                    if ($this->email->send())
                    {
                        $res_update_verify_code = $this->forget_password->updateVerifyCode($res_chk[0]['id'], $verify_code);
                        if ($res_update_verify_code)
                        {
                                    $this->session->unset_userdata('LOGINUSER');

                            $data['msg']   = 'لطفاً برای تغییر رمز عبور به ایمیل خود مراجعه و بر روی لینک تغییر رمز عبور کلیک نمایید.';
                            $this->data   = $data;
                            $this->middle = 'account/redirect';
                            $this->layout();
                        }
                        else
                        {
                            $msg['err']   = 'خطا در بروزرسانی اطلاعات در پایگاه داده!';
                            $this->data   = $msg;
                            $this->middle = 'account/registerUser';
                            $this->layout();
                        }
                    }
                    else
                    {
                        $msg['err'] = 'خطا در ارسال ایمیل';
                        $this->data = $msg;
                    }
                }
                elseif($res_chk[0]['status']==0)
                {
                    $data['err']  = 'کدتاییدیه به ایمیل شما ارسال گردیده ، به ایمیل خود رفته و روی لینک مربوطه به سایت مکان با ما کلیک نمایید.';
                    $this->data   = $data;
                    $this->middle = 'account/forgetPassword';
                    $this->layout();
                }
                elseif($res_chk[0]['status']==-1)
                {
                    $data['err']  = 'حساب شما به دلایلی در سامانه غیر فعال گردیده است ، لطفا باپشتیبانی سامانه تماس بگیرید.';
                    $this->data   = $data;
                    $this->middle = 'account/forgetPassword';
                    $this->layout();
                }
            }
            else
            {
                $data['err']  = 'ایمیل موردنظر در سامانه وجود ندارد.';
                $this->data   = $data;
                $this->middle = 'account/forgetPassword';
                $this->layout();
            }
        }
    }

}
