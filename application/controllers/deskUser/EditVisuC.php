<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class editVisuC extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!$_COOKIE['MakanBaMa'] or unserialize(get_cookie('MakanBaMa'))['USERTYPE'] != 'hosteler')
        {
            redirect('main/VisuC');
        }
        $this->load->model('deskUser/edit_visu');
    }

    function index()
    {
        
    }

    function edit($type_visu,$buillding_id)
    {
        $this->session->set_userdata('BUILDING', $buillding_id);
        $res_info       = $this->edit_visu->edit($buillding_id);
        $res_province   = $this->edit_visu->getProvince();
        $res_city       = $this->edit_visu->getCity($res_info[0]['province_id']);
        $data['result'] = array('_province' => $res_province, '_city' => $res_city, 'info' => $res_info[0]);
        $this->data     = $data;
        $this->middle   = 'deskUser/editVisu';
        $this->layout('panelUser');
    }

    public function uploadImgMain($action)
    {
        $user  = unserialize(get_cookie('MakanBaMa'))['USERID'];
        $place = $this->input->post('fn');
        switch ($action)
        {
            case 'upload':
                $file = isset($_FILES['fileMain']) ? $_FILES['fileMain'] : NULL;
                if (( ($file["type"] == "image/jpeg") || ($file["type"] == "image/pjpeg") || ($file["type"] == "image/jpg")))
                {
                    if ($file["size"] <= 1000000)
                    {
                        $user_folder = FCPATH . "/assets/img/upload/" . $user . "/" . $place . "/";
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
                                    'initialPreview' => [base_url() . "assets/img/upload/{$user}/{$place}/{$filename}?{$nc}"],
                                    'initialPreviewConfig' => [ [ 'url' => base_url() . "deskUser/editVisuC/uploadImgMain/delete", 'key' => $place]],
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
                                    'initialPreview' => [base_url() . "assets/img/upload/{$user}/{$place}/{$filename}?{$nc}"],
                                    'initialPreviewConfig' => [ [ 'url' => base_url() . "deskUser/editVisuC/uploadImgMain/delete", 'key' => $place],],
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
                $key         = $this->input->post('key');
                $place    = $key;
                $filename="MAIN_{$key}.jpg";
                $user_folder = FCPATH . "/assets/img/upload/" . $user . "/" . $place . "/";
                $destPath = $user_folder . $filename;
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
        $place = $this->input->post('fn');


        switch ($action)
        {
            case 'upload':
                $file = isset($_FILES['fileAdditional']) ? $_FILES['fileAdditional'] : NULL;

                if (( ($file["type"] == "image/jpeg") || ($file["type"] == "image/pjpeg") || ($file["type"] == "image/jpg")))
                {
                    if ($file["size"] <= 2000000)
                    {
                        $r           = mt_rand(100000, 1000000);
                        $user_folder = FCPATH . "/assets/img/upload/" . $user . "/" . $place . "/";
                        $filename    = 'ADDI_' . $r . '.jpg';
                        $destPath    = $user_folder . $filename;
$param=$filename.','.$place;
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
                                    'initialPreview' => [base_url() . "assets/img/upload/{$user}/{$place}/{$filename}"],
                                    'initialPreviewConfig' => [ [ 'url' => base_url() . 'deskUser/editVisuC/uploadImgAdditional/delete', 'key' => $param],],
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
                                    'initialPreview' => [base_url() . "assets/img/upload/{$user}/{$place}/{$filename}"],
                                    'initialPreviewConfig' => [ [ 'url' => base_url() . 'deskUser/editVisuC/uploadImgAdditional/delete', 'key' => $param],],
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
                $key         = explode( ',',$this->input->post('key'));
                
                $user_folder = FCPATH . "/assets/img/upload/" . $user . "/" . $key[1] . "/";
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

    public function regist($type_visu)
    {
        $input_main   = array(
            'title' => $this->input->post('title', TRUE),
            'province_id' => $this->input->post('optProvince', TRUE),
            'city_id' => $this->input->post('optCity', TRUE),
            'floor_count' => $this->input->post('floorCount', TRUE),
            'room_count' => $this->input->post('roomCount', TRUE),
            'persons_normal' => $this->input->post('personsNormal', TRUE),
            'persons_max' => $this->input->post('personsMax', TRUE),
            'building_space' => $this->input->post('buildingSpace', TRUE),
            'ground_space' => $this->input->post('groundSpace', TRUE),
            'rent_price' => str_replace(',', '',  $this->input->post('rentPrice', TRUE)),
            'final_desc' => $this->input->post('finalDesc', TRUE),
            'rent_price_desc' => $this->input->post('rentPriceDesc', TRUE),
            'lat' => $this->input->post('lat'),
            'lng' => $this->input->post('lng'),
        );
        $input_detail = array(
            'sea_' => $this->input->post('sea_'),
            'sea' => ($this->input->post('sea')) == 'on' ? 1 : 0,
            'forest_' => $this->input->post('forest_'),
            'forest' => ($this->input->post('forest')) == 'on' ? 1 : 0,
            'mountain_' => $this->input->post('mountain_'),
            'mountain' => ($this->input->post('mountain')) == 'on' ? 1 : 0,
            'foothill_' => $this->input->post('foothill_'),
            'foothill' => ($this->input->post('foothill')) == 'on' ? 1 : 0,
            'lake_' => $this->input->post('lake_'),
            'lake' => ($this->input->post('lake')) == 'on' ? 1 : 0,
            'river_' => $this->input->post('river_'),
            'river' => ($this->input->post('river')) == 'on' ? 1 : 0,
            'city_' => $this->input->post('city_'),
            'city' => ($this->input->post('city')) == 'on' ? 1 : 0,
            'village_' => $this->input->post('village_'),
            'village' => ($this->input->post('village')) == 'on' ? 1 : 0,
            'pool_' => $this->input->post('pool_'),
            'pool' => ($this->input->post('pool')) == 'on' ? 1 : 0,
            'nearsea_' => $this->input->post('nearSea_'),
            'nearsea' => ($this->input->post('nearSea')) == 'on' ? 1 : 0,
            'woodsy_' => $this->input->post('woodsy_'),
            'woodsy' => ($this->input->post('woodsy')) == 'on' ? 1 : 0,
            'mountainous_' => $this->input->post('mountainous_'),
            'mountainous' => ($this->input->post('mountainous')) == 'on' ? 1 : 0,
            'very_nearsea_' => $this->input->post('veryNearSea_'),
            'very_nearsea' => ($this->input->post('veryNearSea')) == 'on' ? 1 : 0,
            'into_twon_' => $this->input->post('intoTwon_'),
            'into_twon' => ($this->input->post('intoTwon')) == 'on' ? 1 : 0,
            'exclusive_' => $this->input->post('exclusive_'),
            'exclusive' => ($this->input->post('exclusive')) == 'on' ? 1 : 0,
            'nonexclusive_' => $this->input->post('nonExclusive_'),
            'nonexclusive' => ($this->input->post('nonExclusive')) == 'on' ? 1 : 0,
            'janitor_' => $this->input->post('janitor_'),
            'janitor' => ($this->input->post('janitor')) == 'on' ? 1 : 0,
            'console_games_' => $this->input->post('consoleGames_'),
            'console_games' => ($this->input->post('consoleGames')) == 'on' ? 1 : 0,
            'furniture_' => $this->input->post('furniture_'),
            'furniture' => ($this->input->post('furniture')) == 'on' ? 1 : 0,
            'dining_table_' => $this->input->post('diningTable_'),
            'dining_table' => ($this->input->post('diningTable')) == 'on' ? 1 : 0,
            'tv_' => $this->input->post('tv_'),
            'tv' => ($this->input->post('tv')) == 'on' ? 1 : 0,
            'antenna_' => $this->input->post('antenna_'),
            'antenna' => ($this->input->post('antenna')) == 'on' ? 1 : 0,
            'internet_' => $this->input->post('internet_'),
            'internet' => ($this->input->post('internet')) == 'on' ? 1 : 0,
            'elevator_' => $this->input->post('elevator_'),
            'elevator' => ($this->input->post('elevator')) == 'on' ? 1 : 0,
            'sound_system_' => $this->input->post('soundSystem_'),
            'sound_system' => ($this->input->post('soundSystem')) == 'on' ? 1 : 0,
            'vacume_cleaner_' => $this->input->post('vacumeCleaner_'),
            'vacume_cleaner' => ($this->input->post('vacumeCleaner')) == 'on' ? 1 : 0,
            'iron_' => $this->input->post('iron_'),
            'iron' => ($this->input->post('iron')) == 'on' ? 1 : 0,
            'cabinet_' => $this->input->post('cabinet_'),
            'cabinet' => ($this->input->post('cabinet')) == 'on' ? 1 : 0,
            'kitchen_ware_' => $this->input->post('kitchenWare_'),
            'kitchen_ware' => ($this->input->post('kitchenWare')) == 'on' ? 1 : 0,
            'refrigerator_' => $this->input->post('refrigerator_'),
            'refrigerator' => ($this->input->post('refrigerator')) == 'on' ? 1 : 0,
            'dish_washer_' => $this->input->post('dishWasher_'),
            'dish_washer' => ($this->input->post('dishWasher')) == 'on' ? 1 : 0,
            'washing_machine_' => $this->input->post('washingMachine_'),
            'washing_machine' => ($this->input->post('washingMachine')) == 'on' ? 1 : 0,
            'microwave_' => $this->input->post('microWave_'),
            'microwave' => ($this->input->post('microWave')) == 'on' ? 1 : 0,
            'tea_maker_' => $this->input->post('teaMaker_'),
            'tea_maker' => ($this->input->post('teaMaker')) == 'on' ? 1 : 0,
            'water_purifier_' => $this->input->post('waterPurifier_'),
            'water_purifier' => ($this->input->post('waterPurifier')) == 'on' ? 1 : 0,
            'bed_' => $this->input->post('bed_'),
            'bed' => ($this->input->post('bed')) == 'on' ? 1 : 0,
            'bathroom_' => $this->input->post('bathroom_'),
            'bathroom' => ($this->input->post('bathroom')) == 'on' ? 1 : 0,
            'toilet_bowls_' => $this->input->post('toiletBowls_'),
            'toilet_bowls' => ($this->input->post('toiletBowls')) == 'on' ? 1 : 0,
            'iranian_health_service_' => $this->input->post('iranianHealthService_'),
            'iranian_health_service' => ($this->input->post('iranianHealthService')) == 'on' ? 1 : 0,
            'indoor_swimming_pool_' => $this->input->post('indoorSwimmingPool_'),
            'indoor_swimming_pool' => ($this->input->post('indoorSwimmingPool')) == 'on' ? 1 : 0,
            'souna_' => $this->input->post('souna_'),
            'souna' => ($this->input->post('souna')) == 'on' ? 1 : 0,
            'jakuzzi_' => $this->input->post('jakuzzi_'),
            'jakuzzi' => ($this->input->post('jakuzzi')) == 'on' ? 1 : 0,
            'outdoor_swimming_pool_' => $this->input->post('outdoorSwimmingPool_'),
            'outdoor_swimming_pool' => ($this->input->post('outdoorSwimmingPool')) == 'on' ? 1 : 0,
            'shower_in_the_yard_' => $this->input->post('showerInTheYard_'),
            'shower_in_the_yard' => ($this->input->post('showerInTheYard')) == 'on' ? 1 : 0,
            'gym_equipment_' => $this->input->post('gymEquipment_'),
            'gym_equipment' => ($this->input->post('gymEquipment')) == 'on' ? 1 : 0,
            'massage_chairs_' => $this->input->post('massageChairs_'),
            'massage_chairs' => ($this->input->post('massageChairs')) == 'on' ? 1 : 0,
            'pool_table_' => $this->input->post('poolTable_'),
            'pool_table' => ($this->input->post('poolTable')) == 'on' ? 1 : 0,
            'pingpong_table_' => $this->input->post('pingongTable_'),
            'pingPong_table' => ($this->input->post('pingpongTable')) == 'on' ? 1 : 0,
            'soccer_' => $this->input->post('soccer_'),
            'soccer' => ($this->input->post('soccer')) == 'on' ? 1 : 0,
            'back_gammon_' => $this->input->post('backGammon_'),
            'back_gammon' => ($this->input->post('backGammon')) == 'on' ? 1 : 0,
            'chest_table_' => $this->input->post('chestTable_'),
            'chest_table' => ($this->input->post('chestTable')) == 'on' ? 1 : 0,
            'volleyball_court_' => $this->input->post('volleyballCourt_'),
            'volleyball_court' => ($this->input->post('volleyballCourt')) == 'on' ? 1 : 0,
            'football_court_' => $this->input->post('footballCourt_'),
            'football_court' => ($this->input->post('footballCourt')) == 'on' ? 1 : 0,
            'tennis_court_' => $this->input->post('tennisCourt_'),
            'tennis_court' => ($this->input->post('tennisCourt')) == 'on' ? 1 : 0,
            'badminton_court_' => $this->input->post('badmintonCourt_'),
            'badminton_court' => ($this->input->post('badmintonCourt')) == 'on' ? 1 : 0,
            'childeren_play_area_' => $this->input->post('childerenPlayArea_'),
            'childeren_play_area' => ($this->input->post('childerenPlayArea')) == 'on' ? 1 : 0,
            'terrace_' => $this->input->post('terrace_'),
            'terrace' => ($this->input->post('terrace')) == 'on' ? 1 : 0,
            'parking_' => $this->input->post('parking_'),
            'parking' => ($this->input->post('parking')) == 'on' ? 1 : 0,
            'yard_' => $this->input->post('yard_'),
            'yard' => ($this->input->post('yard')) == 'on' ? 1 : 0,
            'green_space_' => $this->input->post('greenSpace_'),
            'green_space' => ($this->input->post('greenSpace')) == 'on' ? 1 : 0,
            'pergola_' => $this->input->post('pergola_'),
            'pergola' => ($this->input->post('pergola')) == 'on' ? 1 : 0,
            'barbecue_' => $this->input->post('barbecue_'),
            'barbecue' => ($this->input->post('barbecue')) == 'on' ? 1 : 0,
            'fountain_' => $this->input->post('fountain_'),
            'fountain' => ($this->input->post('fountain')) == 'on' ? 1 : 0,
            'split_cooler_' => $this->input->post('splitCooler_'),
            'split_cooler' => ($this->input->post('splitCooler')) == 'on' ? 1 : 0,
            'gase_cooler_' => $this->input->post('gaseCooler_'),
            'gase_cooler' => ($this->input->post('gaseCooler')) == 'on' ? 1 : 0,
            'water_cooler_' => $this->input->post('waterCooler_'),
            'water_cooler' => ($this->input->post('waterCooler')) == 'on' ? 1 : 0,
            'ceiling_fan_' => $this->input->post('ceilingFan_'),
            'ceiling_fan' => ($this->input->post('ceilingFan')) == 'on' ? 1 : 0,
            'gas_heater_' => $this->input->post('gasHeater_'),
            'gas_heater' => ($this->input->post('gasHeater')) == 'on' ? 1 : 0,
            'radiators_' => $this->input->post('radiators_'),
            'radiators' => ($this->input->post('radiators')) == 'on' ? 1 : 0,
            'wall_package_' => $this->input->post('wallPackage_'),
            'wall_package' => ($this->input->post('wallPackage')) == 'on' ? 1 : 0,
            'fireplace_wood_' => $this->input->post('fireplaceWood_'),
            'fireplace_wood' => ($this->input->post('fireplaceWood')) == 'on' ? 1 : 0,
            'fireplace_gas_' => $this->input->post('fireplaceGas_'),
            'fireplace_gas' => ($this->input->post('fireplaceGas')) == 'on' ? 1 : 0,
            'oven_' => $this->input->post('oven_'),
            'oven' => ($this->input->post('oven')) == 'on' ? 1 : 0,
            'hairdryer_' => $this->input->post('hairdryer_'),
            'hairdryer' => ($this->input->post('hairdryer')) == 'on' ? 1 : 0,
            'water_have' => ($this->input->post('waterHave')) == 'on' ? 1 : 0,
            'flash_have' => ($this->input->post('flashHave')) == 'on' ? 1 : 0,
            'gas_have' => ($this->input->post('gasHave')) == 'on' ? 1 : 0,
            'phone_have' => ($this->input->post('phoneHave')) == 'on' ? 1 : 0,
        );

        $res_main = $this->edit_visu->editMain($input_main);
        if ($res_main)
        {
            $res_detail = $this->edit_visu->editDetail($input_detail);
            if ($res_detail)
            {

                redirect('deskUser/listVisuC/visu/'.$type_visu);
            }
            else
            {
                $msg['err']   = 'خطا در ثبت اطلاعات در پایگاه داده!';
                $this->data   = $msg;
                $this->middle = 'deskUser/newVisu';
                $this->layout('panelUser');
            }
        }
        else
        {
            $msg['err']   = 'خطا در ثبت اطلاعات در پایگاه داده!';
            $this->data   = $msg;
            $this->middle = 'deskUser/newVisu';
            $this->layout('panelUser');
        }
    }

}
