<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class VerifyAccountC extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('account/verify_account');
    }

    function verify($verifyCode = '')
    {

        if (isset($verifyCode) and $verifyCode != '')
        {
            $has_verify_account = $this->verify_account->hasVerifyAccount($verifyCode);
            if ($has_verify_account)
            {

                    $active_account = $this->verify_account->activeAccount($verifyCode);
                    if ($active_account)
                    {
                        $result['activeAccount_1'] = 'حساب کاربری شما با موفقیت فعال شد هم اکنون میتوانید وارد سایت شوید.';
			  $result['activeAccount_1'] = 'جهت ورود به سامانه از طریق منوی بالای سایت اقدام نمائید.';
                        $this->data              = $result;
                        $this->middle            = 'account/registedAccount';
                        $this->layout();
                    }
                    else
                    {
                        $result['errUpdate'] = 'خطا در ثبت اطلاعات درپایگاه داده';
                        $this->data          = $result;
                        $this->middle        = 'account/registedAccount';
                        $this->layout();
                    }
         
            }
            else
            {
                $result['noVercode'] = 'کد معتبرسازی نامعتبر می باشد.';
                $this->data          = $result;
                $this->middle        = 'account/registedAccount';
                $this->layout();
            }
        }
        else
        {
            $result['badUrl'] = 'لینک مربوطه فاقد کد معتبر سازی می باشد.';
            $this->data       = $result;
            $this->middle     = 'account/registedAccount';
            $this->layout();
        }
    }

}
