<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ContactC extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('contact');
        $this->load->model('main');
    }

    public function index()
    {
        $this->main->pageVisit('pageContact');
        $random_number     = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
        $values            = array(
            'word' => $random_number,
            'img_path' => FCPATH . '/assets/img/captcha/',
            'img_url' => base_url() . 'assets/img/captcha/',
            'img_width' => '150',
            'img_height' => 30,
            'expiration' => 7200,
            'word_length' => 8,
            'font_size' => 24,
            'img_id' => 'captcha_image',
            'pool' => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'colors' => array(
                'background' => array(0, 0, 0),
                'border' => array(255, 255, 255),
                'text' => array(255, 255, 255),
                'grid' => array(255, 0, 255)
            )
        );
        $data['captcha']   = create_captcha($values);
        $this->session->set_userdata('captchaWord', $data['captcha']['word']);
        $data["_province"] = $this->main->getProvince();
        $this->data        = $data;
        $this->middle      = 'contact';
        $this->layout();
    }

    public function captcha()
    {
        $random_number   = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
        $values          = array(
            'word' => $random_number,
            'img_path' => FCPATH . '/assets/img/captcha/',
            'img_url' => base_url() . 'assets/img/captcha/',
            'img_width' => '150',
            'img_height' => 30,
            'expiration' => 7200,
            'word_length' => 8,
            'font_size' => 24,
            'img_id' => 'captcha_image',
            'pool' => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'colors' => array(
                'background' => array(0, 0, 0),
                'border' => array(255, 255, 255),
                'text' => array(255, 255, 255),
                'grid' => array(255, 0, 255)
            )
        );
        $data['captcha'] = create_captcha($values);
        $this->session->set_userdata('captchaWord', $data['captcha']['word']);
        if ($_GET)
        {
            die(json_encode($data['captcha']['filename']));
        }
        else
        {
            return $data;
        }
    }

    public function check_captcha($str)
    {
        $word = $this->session->userdata('captchaWord');
        if (strcmp(strtoupper($str), strtoupper($word)) == 0)
        {
            return true;
        }
        else
        {
            $this->form_validation->set_message('check_captcha', 'کد امنیتی صحیح نمی باشد.');
            return false;
        }
    }

    public function regist()
    {
        $this->form_validation->set_rules('full_name', 'نام ونام خانوادگی', 'trim');
        $this->form_validation->set_rules('optProvince', 'استان', 'trim');
        $this->form_validation->set_rules('optCity', 'شهرستان', 'trim');
        $this->form_validation->set_rules('mobile', 'شماره همراه', 'trim|regex_match[/^09[0-9]{9}$/u]', array('regex_match' => 'شماره همراه معتبر نمی باشد.'));
        $this->form_validation->set_rules('email', 'ایمیل', 'trim|required|valid_email', array('required' => ' لطفا ایمیل را وارد نمایید.', 'valid_email' => ' ایمیل معتبر نمی باشد.'));
        $this->form_validation->set_rules('message', 'پیام', 'trim|required', array('required' => ' لطفا متن پیام را وارد نمایید.'));
        $this->form_validation->set_rules('userCaptcha', 'Captcha', 'required|callback_check_captcha', array('required' => 'لطفا کد امنیتی را وارد نمایید.'));

        $input = array(
            'full_name' => $this->input->post('full_name', TRUE),
            'province' => $this->input->post('optProvince', TRUE),
            'city' => $this->input->post('optCity', TRUE),
            'mobile' => $this->input->post('mobile', TRUE),
            'email' => $this->input->post('email', TRUE),
            'message' => $this->input->post('message', TRUE),
        );

        if ($this->form_validation->run() == false)
        {
            $data              = $this->captcha();
            $data["_province"] = $this->main->getProvince();
            $this->data        = $data;
            $this->middle      = 'contact';
            $this->layout();
        }
        else
        {
            $res_insert = $this->contact->regist($input);
            if ($res_insert)
            {
                $data              = $this->captcha();
                $data["_province"] = $this->main->getProvince();
                $data['ok']        = 'پیام شما با موفقیت ارسال گردید.';
                $this->data        = $data;
                $this->middle      = 'contact';
                $this->layout();
            }
            else
            {
                $data              = $this->captcha();
                $data["_province"] = $this->main->getProvince();
                $data['err']       = 'خطا در ثبت اطلاعات در پایگاه داده!';
                $this->data        = $data;
                $this->middle      = 'contact';
                $this->layout();
            }
        }
    }

}
