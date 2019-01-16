<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class RegisterUserC extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('account/register_user');
    }

    function index()
    {
        $this->middle = 'account/registerUser';
        $this->layout();
    }

    public function chkUniqEmail($str)
    {
        $chk_uniq_email = $this->register_user->chkUniqEmail($str);
        if ($chk_uniq_email)
        {
            $this->form_validation->set_message('chkUniqEmail', 'ایمیل تکراری می باشد( در سامانه موجود می باشد.)');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    public function signUP()
    {
        if (!isset($_POST['type']))
        {
            $msg['type']  = 'لطفا نوع کاربری را انتخاب نمایید.';
            $this->data   = $msg;
            $this->middle = 'account/registerUser';
            $this->layout();
        }
        $this->form_validation->set_rules('email', 'ایمیل', 'trim|required|valid_email|callback_chkUniqEmail', array('required' => ' لطفا ایمیل را وارد نمایید.', 'valid_email' => ' ایمیل معتبر نمی باشد..'));
        $this->form_validation->set_rules('pass1', 'رمز عبور', 'trim|required|min_length[4]', array('required' => ' لطفا رمز عبور را وارد نمایید.', 'min_length' => ' طول رمز عبور می بایست حداقل 6 کاراکتر باشد.'));
        $this->form_validation->set_rules('pass2', 'تکرار رمز عبور', 'trim|matches[pass1]', array('matches' => ' رمزعبور با تکرار آن یکسان نمی باشد.'));
        $type  = $this->input->post('type', TRUE);
        $email = $this->input->post('email', TRUE);
        $pas1  = $this->input->post('pass1', TRUE);
        $pas2  = $this->input->post('pass2', TRUE);
        if ($this->form_validation->run() == false)
        {
            $this->middle = 'account/registerUser';
            $this->layout();
        }
        else
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
            $from                = 'info@makanbama.ir';
            $to                  = $email; //$input['email']
            $subject             = 'تایید ثبت نام در سایت مکان با ما';
            $message             = <<<EOT
			<div style="background-color:white;border:2px #3eaa11 solid;width:90%;height:300px;font-family:'tahoma',sans-serif;direction:rtl;text-align:right;padding:10px;">
				<div style='font-size:14px;margin-bottom:20px;'><b>با سلام</b></div>
				<div style='font-size:14px;margin-bottom:20px;'>براي فعالسازي حساب کاربري خود بر روي لينک ذيل کليک کنيد </div>
				<div style="text-align:center;padding:auto;wdith:100%;"><a href='{$base_url}account/verifyAccountC/verify/{$verify_code}' style="background:#3eaa11;border-radius:2px;color:#fff;direction:rtl;display:block;float:right;font-family:'tahoma',sans-serif;font-size:14px;font-weight:bold;height:52px;line-height:52px;text-align:center;text-decoration:none;padding:5px;">فعالسازي حساب کاربری در سایت مکان با ما</a>
		    </div>
			
EOT;
            $this->email->from($from, 'behzad');
            $this->email->to($to);
            $this->email->subject($subject);
            $this->email->message($message);

            if ($this->email->send())
            {
                $res_register = $this->register_user->signUP($type, $email, md5($pas1), $verify_code);
                if ($res_register)
                {
	
                    $result['pursuitLinkActivation'] = '';
                    $this->data              = $result;
                    $this->middle            = 'account/registedAccount';
		      $this->layout();
                }
                else
                {
                    $msg['err']   = 'خطا در ثبت اطلاعات در پایگاه داده!';
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
    }

}
