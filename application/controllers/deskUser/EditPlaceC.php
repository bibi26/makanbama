<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class EditPlaceC extends MY_Controller
{

    function __construct()
    {

        parent::__construct();
        if (!$_COOKIE['MakanBaMa'] or unserialize(get_cookie('MakanBaMa'))['USERTYPE'] != 'hosteler')
        {
            redirect($this->config->item('home_url'));
        }
        $this->load->model('deskUser/edit_place');
        $this->load->model('main');
    }

    function index($place_id)
    {
        $this->session->set_userdata('rec_place_id', $place_id);
        $res_info      = $this->edit_place->getInfoPlace($place_id);
        $res_province  = $this->main->getProvince();
        $res_city      = $this->main->getCity($res_info[0]['province_id']);
        $this->session->set_userdata('RNDCODEPLACE', $res_info[0]['folder']);
        $msg['result'] = array('_province' => $res_province, '_city' => $res_city, 'info' => $res_info[0]);
        $this->data    = $msg;
        $this->middle  = 'deskUser/editPlace';
        $this->layout('panelUser');
    }

    public function uploadImgMain($action)
    {
        $user = unserialize(get_cookie('MakanBaMa'))['USERID'];

        $place = $this->session->userdata('RNDCODEPLACE');
        switch ($action)
        {
            case 'upload':
                $file = isset($_FILES['fileMain']) ? $_FILES['fileMain'] : NULL;
                if (( ($file["type"] == "image/jpeg") || ($file["type"] == "image/pjpeg") || ($file["type"] == "image/jpg")))
                {
                    if ($file["size"] <= 1000000)
                    {

                        $user_folder = FCPATH . "/assets/img/upload/places/" . $user . "/" . $place . "/";
                        $filename    = 'MAIN_' . $place . '.jpg';
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
                                    'initialPreview' => [base_url() . "assets/img/upload/places/{$user}/{$place}/{$filename}?{$nc}"],
                                    'initialPreviewConfig' => [ [ 'url' => base_url() . "deskUser/editPlaceC/uploadImgMain/delete"]],
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
                                    'initialPreview' => [base_url() . "assets/img/upload/places/{$user}/{$place}/{$filename}?{$nc}"],
                                    'initialPreviewConfig' => [ [ 'url' => base_url() . "deskUser/editPlaceC/uploadImgMain/delete"],],
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
                $user_folder = FCPATH . "/assets/img/upload/places/" . $user . "/" . $place . "/";
                $filename    = 'MAIN_' . $place . '.jpg';
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

    public function uploadImgAdditional($action)
    {
        $user  = unserialize(get_cookie('MakanBaMa'))['USERID'];
        $place = $this->session->userdata('RNDCODEPLACE');


        switch ($action)
        {
            case 'upload':
                $file = isset($_FILES['fileAdditional']) ? $_FILES['fileAdditional'] : NULL;

                if (( ($file["type"] == "image/jpeg") || ($file["type"] == "image/pjpeg") || ($file["type"] == "image/jpg")))
                {
                    if ($file["size"] <= 2000000)
                    {
                        $r           = mt_rand(100000, 1000000);
		     
                        $user_folder = FCPATH . "assets/img/upload/places/" . $user . "/" . $place . "/";
	
                        $filename    = 'ADDI_' . $r . '.jpg';
                        $destPath    = $user_folder . $filename;
                        $param       = $filename . ',' . $place;

                        if ($file["error"] > 0)
                        {
                            $output = array('error' => "خطا در آپلود :" . $file["error"]);
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
                                    'initialPreview' => [base_url() . "assets/img/upload/places/{$user}/{$place}/{$filename}"],
                                    'initialPreviewConfig' => [ [ 'url' => base_url() . 'deskUser/editPlaceC/uploadImgAdditional/delete', 'key' => $param],],
                                    'append' => TRUE
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
                                    'initialPreview' => [base_url() . "assets/img/upload/places/{$user}/{$place}/{$filename}"],
                                    'initialPreviewConfig' => [ [ 'url' => base_url() . 'deskUser/editPlaceC/uploadImgAdditional/delete', 'key' => $param],],
                                    'append' => true
                                ];
                                die(json_encode($output));
                            }
                        }
                    }
                    else
                    {
                        $output = array('error' => "سایز عکس حداکثر می بایست 2MB باشد.");
                        die(json_encode($output));
                    }
                }
                else
                {
                    $output = array('error' => "پسوند فایل مجاز نمی باشد.(فقط jpg)");
                    die(json_encode($output));
                }
                break;
            case 'delete':
                $key = explode(',', $this->input->post('key'));

                $user_folder = FCPATH . "/assets/img/upload/places/" . $user . "/" . $key[1] . "/";
                $filename    = $key[0];
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

    function resize_image($file, $w, $h, $crop = FALSE)
    {
        list($width, $height) = getimagesize($file);
        $r = $width / $height;
        if ($crop)
        {
            if ($width > $height)
            {
                $width = ceil($width - ($width * abs($r - $w / $h)));
            }
            else
            {
                $height = ceil($height - ($height * abs($r - $w / $h)));
            }
            $newwidth  = $w;
            $newheight = $h;
        }
        else
        {
            if ($w / $h > $r)
            {
                $newwidth  = $h * $r;
                $newheight = $h;
            }
            else
            {
                $newheight = $w / $r;
                $newwidth  = $w;
            }
        }
        $src = imagecreatefromjpeg($file);
        $dst = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        return $dst;
    }

    public function edit()
    {
        $input_main = array(
            'ID' => $this->input->post('ID', TRUE),
            'title' => $this->input->post('title', TRUE),
            'province_id' => $this->input->post('optProvince', TRUE),
            'city_id' => $this->input->post('optCity', TRUE),
            'description' => $this->input->post('description', TRUE),
            'address' => $this->input->post('address', TRUE),
            'lat' => $this->input->post('lat'),
            'lng' => $this->input->post('lng'),
        );

        $this->form_validation->set_rules('title', 'عنوان', 'trim|required', array('required' => ' لطفا عنوان را وارد نمایید.'));
        $this->form_validation->set_rules('optProvince', 'استان', 'trim|required', array('required' => ' لطفا استان را تعیین نمایید.'));
        $this->form_validation->set_rules('optCity', 'شهرستان', 'trim|required', array('required' => ' لطفا شهرستان را تعیین نمایید.'));
        $this->form_validation->set_rules('address', 'آدرس', 'trim|required', array('required' => ' لطفا آدرس را وارد نمایید.'));
        $this->form_validation->set_rules('description', 'توضیحات', 'trim|required', array('required' => ' لطفا توضیحات را وارد نمایید.'));


        if ($this->form_validation->run() == false)
        {
            $res_info     = $this->edit_place->getInfoPlace($input_main['ID']);
            $res_province = $this->main->getProvince();
            if ($input_main['city_id'] != '')
            {
                $data['result']['_city'] = $this->main->getCity($input_main['province_id']);
            }

            $data['result'] = array('_province' => $res_province, 'info' => $res_info[0]);
            $this->data     = $data;
            $this->middle   = 'deskUser/editPlace';
            $this->layout('panelUser');
        }
        else
        {
            $res_info = $this->edit_place->getInfoPlace($input_main['ID']);
            $user        = unserialize(get_cookie('MakanBaMa'))['USERID'];
            $user_folder = FCPATH . "/assets/img/upload/places/" . $user . "/" . $res_info[0]['folder'] . "/";
            $filename    = 'MAIN_' . $res_info[0]['folder'] . '.jpg';
            $destPath    = $user_folder . $filename;
            if (file_exists($destPath) == false)
            {
                $data['errUp'] = 'لطفا یک تصویر برای مطلب گردشگری وارد نمایید.';
                $res_info      = $this->edit_place->getInfoPlace($input_main['ID']);
                $res_province  = $this->main->getProvince();
                if ($input_main['city_id'] != '')
                {
                    $data['result']['_city'] = $this->main->getCity($input_main['province_id']);
                }

                $data['result'] = array('_province' => $res_province, 'info' => $res_info[0]);
                $this->data     = $data;
                $this->middle   = 'deskUser/editPlace';
                $this->layout('panelUser');
            }
            else
            {
                $res_main = $this->edit_place->edit($input_main);
                if ($res_main)
                {
                    redirect('deskUser/listPlaceC/');
                }
                else
                {
                    $data['err']       = 'خطا در ثبت اطلاعات در پایگاه داده!';
                    $data["_province"] = $this->main->getProvince();
                    if ($input_main['city_id'] != '')
                    {
                        $data["_city"] = $this->main->getCity($input_main['province_id']);
                    }
                    $this->data   = $data;
                    $this->middle = 'deskUser/editPlace';
                    $this->layout('panelUser');
                }
            }
        }
    }

}
