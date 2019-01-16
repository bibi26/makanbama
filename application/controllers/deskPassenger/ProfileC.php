<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ProfileC extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!$_COOKIE['MakanBaMa'] or unserialize(get_cookie('MakanBaMa'))['USERTYPE'] != 'passenger')
        {
            redirect($this->config->item('home_url'));
        }
        $this->load->model('deskPassenger/profile');
        $this->load->model('main');
    }

    function index()
    {
        $res               = $this->profile->getProfileInfo();
        $data["_data"]     = $res[0];
        $data["_province"] = $this->main->getProvince();
        $data["_city"]     = $this->main->getCity($res[0]['province_id']);
        $this->data        = $data;
        $this->middle      = 'deskPassenger/profile';
        $this->layout('panelPassenger');
    }

    function registInfo()
    {
        $this->form_validation->set_rules('first_name', 'نام','trim|required', array('required' => ' لطفا نام را وارد نمایید.'));
        $this->form_validation->set_rules('last_name', ' نام خانوادگی', 'trim|required', array('required' => ' لطفا نام خانوادگی را وارد نمایید.'));
        $this->form_validation->set_rules('optProvince', 'استان', 'trim|required', array('required' => ' لطفا استان را وارد نمایید.'));
        $this->form_validation->set_rules('optCity', 'شهرستان', 'trim|required', array('required' => ' لطفا شهرستان را وارد نمایید.'));
        $this->form_validation->set_rules('mobile', 'شماره همراه', 'trim|required|regex_match[/^09[0-9]{9}$/u]', array('required' => ' لطفاشماره همراه را وارد نمایید.','regex_match' => 'شماره همراه معتبر نمی باشد.'));
        $this->form_validation->set_rules('address', 'آدرس', 'trim');
        $input = array(
            'first_name' => $this->input->post('first_name', TRUE),
            'last_name' => $this->input->post('last_name', TRUE),
            'mobile' => $this->input->post('mobile', TRUE),
            'address' => $this->input->post('address', TRUE),
            'province' => $this->input->post('optProvince', TRUE),
            'city' => $this->input->post('optCity', TRUE),
        );

        if ($this->form_validation->run() == false)
        {
            $data["_province"] = $this->main->getProvince();
            $res           = $this->profile->getProfileInfo();
            $data["_city"] = $this->main->getCity($res[0]['province_id']);
            $data["_data"] = $res[0];
            $this->data    = $data;

            $this->middle = 'deskPassenger/profile';
            $this->layout('panelPassenger');
        }
        else
        {
            $res_insert = $this->profile->registInfo($input);
            if ($res_insert)
            {
                $res               = $this->profile->getProfileInfo();
                $data["_data"]     = $res[0];
                $data["_province"] = $this->main->getProvince();
                $data["_city"]     = $this->main->getCity($res[0]['province_id']);
                $data['ok']   = 'اطلاعات کاربری شما با موفقیت ذخیره شد. بزودی اطلاعات شما توسط مدیر سایت بررسی میشود. ';
                $this->data   = $data;
                $this->middle = 'deskPassenger/profile';
                $this->layout('panelPassenger');
            }
            else
            {
                $res               = $this->profile->getProfileInfo();
                $data["_province"] = $this->main->getProvince();
                $data["_city"]     = $this->main->getCity($res[0]['province_id']);

                $data["_data"] = $res[0];
                $data['err']   = 'خطا در ثبت اطلاعات در پایگاه داده!';
                $this->data    = $data;
                $this->middle  = 'deskPassenger/profile';
                $this->layout('panelPassenger');
            }
        }
    }

    public function uploadImgProfile($action)
    {
        $user = unserialize(get_cookie('MakanBaMa'))['USERID'];
        switch ($action)
        {
            case 'upload':
                $file = isset($_FILES['fileProfile']) ? $_FILES['fileProfile'] : NULL;
                if (( ($file["type"] == "image/jpeg") || ($file["type"] == "image/pjpeg") || ($file["type"] == "image/jpg")))
                {
                    if ($file["size"] <= 1000000)
                    {
                        $user_folder = FCPATH . "\assets\img\upload\\" . $user . "\\";
                        $filename    = 'PROFILE_' . $user . '.jpg';
                        $destPath    = $user_folder . $filename;
                        $nc          = mt_rand(100000, 1000000);

                        if ($file["error"] > 0)
                        {
                            $output = array('error' => "Return Code:" . $file["error"]);
                            die(json_encode($output));
                        }
                        else
                        {
                            if (file_exists($user_folder))
                            {
                                if (file_exists($destPath))
                                {
                                    unlink($destPath);
                                }
                                move_uploaded_file($file['tmp_name'], $destPath);
                                $config['image_library']  = 'gd2';
                                $config['source_image']   = $destPath;
                                $config['new_image']      = $user_folder;
                                $config['create_thumb']   = TRUE;
                                $config['maintain_ratio'] = TRUE;
                                $config['thumb_marker']   = '';
                                $config['width']          = 640;
                                $config['height']         = 480;

                                $config['wm_text']            = 'www.makanbama.ir';
                                $config['wm_type']            = 'text';
                                $config['wm_font_size']       = '20';
                                $config['wm_font_color']      = 'ffffff';
                                $config['wm_vrt_alignment']   = 'middle';
                                $config['wm_hor_alignment']   = 'left';
                                $config['wm_padding']         = '60';
                                $config['wm_shadow_color']    = '000000';
                                $config['wm_shadow_distance'] = 4;

                                $this->image_lib->clear();

                                $this->image_lib->initialize($config);
                                $this->image_lib->resize();
                                $this->image_lib->watermark();
                                $output = [
                                    'uploaded' => 'OK',
                                    'initialPreview' => [base_url() . "assets/img/upload/{$user}/{$filename}?{$nc}"],
                                    'initialPreviewConfig' => [ [ 'url' => base_url() . "deskPassenger/profileC/uploadImgProfile/delete"]],
                                    'append' => FALSE
                                ];
                                die(json_encode($output));
                            }
                            else
                            {
                                $oldumask = umask(0);
                                if (!mkdir($user_folder, 0777, TRUE))
                                {
                                    $output = array('error' => "Error: can't create folder please contact with administrator...\r\n<br>");
                                    die(json_encode($output));
                                }
                                umask($oldumask);
                                move_uploaded_file($file['tmp_name'], $destPath);
                                $config['image_library']  = 'gd2';
                                $config['source_image']   = $destPath;
                                $config['new_image']      = $user_folder;
                                $config['create_thumb']   = TRUE;
                                $config['maintain_ratio'] = TRUE;
                                $config['thumb_marker']   = '';
                                $config['width']          = 640;
                                $config['height']         = 480;

                                $config['wm_text']            = 'www.makanbama.ir';
                                $config['wm_type']            = 'text';
                                $config['wm_font_size']       = '20';
                                $config['wm_font_color']      = 'ffffff';
                                $config['wm_vrt_alignment']   = 'middle';
                                $config['wm_hor_alignment']   = 'left';
                                $config['wm_padding']         = '60';
                                $config['wm_shadow_color']    = '000000';
                                $config['wm_shadow_distance'] = 4;

                                $this->image_lib->clear();

                                $this->image_lib->initialize($config);
                                $this->image_lib->resize();
                                $this->image_lib->watermark();
                                $output = [
                                    'uploaded' => 'OK',
                                    'initialPreview' => [base_url() . "assets/img/upload/{$user}/{$filename}?{$nc}"],
                                    'initialPreviewConfig' => [ [ 'url' => base_url() . "deskPassenger/editVisuC/uploadImgProfile/delete"],],
                                    'append' => FALSE
                                ];
                                die(json_encode($output));
                            }
                        }
                    }
                    else
                    {
                        $output = array('error' => "سایز عکس حداکثر می بایست 1MB باشد.");
                        die(json_encode($output));
                    }
                }
                else
                {
                    $output = array('error' => "پسوند فایل مجاز نمی باشد.");
                    die(json_encode($output));
                }
                break;
            case 'delete':
                $user_folder = FCPATH . "\assets\img\upload\\" . $user . "\\";
                $filename    = 'PROFILE_' . $user . '.jpg';
                $destPath    = $user_folder . $filename;
                if (file_exists($destPath))
                {
                    unlink($destPath);
                }
                $output = array('uploaded' => 'OK');
                die(json_encode($output));
                break;
        }
    }

}
