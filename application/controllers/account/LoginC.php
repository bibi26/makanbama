<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class LoginC extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('account/login');
    }

    function index()
    {
        $this->middle = 'account/registerUser';
        $this->layout();
    }

    function auth()
    {
        $this->load->library('user_agent');
        $email     = $this->input->post('email');
        $pas       = $this->input->post('pas');
        $res_login = $this->login->auth($email, $pas);
        if (count($res_login) == 1)//if a row find whit this email and pass
        {    
            if ($res_login[0]['status'] == 3)//if user ok an no problem
            {
                $this->login->loginLog(0,$email,$pas);
                $value = array(
                    'EMAIL' => $email,
                    'USERID' => $res_login[0]['id'],
                    'USERTYPE' => $res_login[0]['type'],
                );

                $cookie = array(
                    'name' => 'MakanBaMa',
                    'value' => serialize($value),
                    'expire' => 86500 * 30 * 12,
                    'domain' => $this->config->item('domain'),
                    'path' => '/'
                );

                $this->input->set_cookie($cookie);
                $data = array(
                    'success' => TRUE,
                    'message' => '',
                    'user' => $res_login[0]['type'],
                );
                die(json_encode($data));
            }
            elseif ($res_login[0]['status'] == 1)//if user dont click the link email and dont active
            {
                $this->login->loginLog(-2,$email,$pas);
               $data = array(
                    'success' => FALSE,
                    'message' => 'در حال حاضر حساب کاربری شما فعال نگردیده است لطفا به ایمیل خود رفته و آن را فعال نمایید!',
                );
                die(json_encode($data));
            }
            elseif ($res_login[0]['status'] == -1)//if admin deactive the current user
            {
                $this->login->loginLog(-3,$email,$pas);
                $data = array(
                    'success' => FALSE,
                    'message' => 'حساب شما به دلایلی در سامانه غیر فعال گردیده است ، لطفا باپشتیبانی سامانه تماس بگیرید.',
                );
                die(json_encode($data));
            }
        }
        else
        {
            $this->login->loginLog(-1,$email,$pas);
            $data = array(
                'success' => FALSE,
                'message' => 'رمز عبور یا ایمیل شما اشتباه است.',
            );
            die(json_encode($data));
        }
    }

}
