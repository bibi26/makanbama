<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class VisuC extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('main/visu');
        $this->load->model('main');
    }

    public function visu($type_visu)
    {
        $this->visu->visitAllVisu($type_visu);
        if ($this->input->get('prv') == null)
        {
            $province = NULL;
        }
        else
        {
            $province = $this->input->get('prv');
        }

        if ($this->input->get('cty') == null)
        {
            $city = NULL;
        }
        else
        {
            $city = $this->input->get('cty');
        }

        if ($this->input->get('amt') == null)
        {
            $amount = NULL;
        }
        else
        {
            $amount = $this->input->get('amt');
        }

        if ($this->input->get('rom') == null)
        {
            $rooms = NULL;
        }
        else
        {
            $rooms = $this->input->get('rom');
        }

        if ($this->input->get('prs') == null)
        {
            $persons = NULL;
        }
        else
        {
            $persons = $this->input->get('prs');
        }

        if ($this->input->get('prt') == null)
        {
            $property = NULL;
        }
        else
        {
            $property = $this->input->get('prt');
        }
        if ($this->input->get('pri') == null)
        {
            $priority = NULL;
        }
        else
        {
            $priority = $this->input->get('pri');
        }

        if ($this->input->get('favorite'))
        {
            $have_favorite = TRUE;
        }
        else
        {
            $have_favorite = FALSE;
        }
        if ($province != null or $city != null or $amount != null or $rooms != null or $persons != null or $property != null or $priority != null)
        {
            $this->visu->visitSrchVisu($type_visu);
        }
        if ($amount != NULL)
        {
            $a          = explode('-', $amount);
            $min_amount = $a[0];
            $max_amount = $a[1];
        }
        else
        {
            $min_amount = NULL;
            $max_amount = NULL;
        }
        if ($persons != NULL)
        {
            $p          = explode('-', $persons);
            $min_person = $p[0];
            $max_person = $p[1];
        }
        else
        {
            $min_person = NULL;
            $max_person = NULL;
        }
        if ($rooms != NULL)
        {
            $r        = explode('-', $rooms);
            $min_room = $r[0];
            $max_room = $r[1];
        }
        else
        {
            $min_room = NULL;
            $max_room = NULL;
        }

        $config['base_url']             = base_url(uri_string());
        $config['total_rows']           = $this->visu->getCountVisu($type_visu, $province, $city, $min_amount, $max_amount, $min_person, $max_person, $min_room, $max_room, $property);
        $config['per_page']             = 9;
        $config['page_query_string']    = TRUE;
        $config['query_string_segment'] = 'page';
        $config['use_page_numbers']     = TRUE;
        $config['full_tag_open']        = '<ul class="pagination">';
        $config['full_tag_close']       = '</ul>';
        $config['prev_link']            = 'قبلی';
        $config['prev_tag_open']        = '<li>';
        $config['prev_tag_close']       = '</li>';
        $config['next_link']            = 'بعدی';
        $config['next_tag_open']        = '<li>';
        $config['next_tag_close']       = '</li>';
        $config['cur_tag_open']         = '<li class="active"><a href="#">';
        $config['cur_tag_close']        = '</a></li>';
        $config['num_tag_open']         = '<li>';
        $config['num_tag_close']        = '</li>';
        $config["num_links"]            = round($config["total_rows"] / $config["per_page"]);
        $config['users']                = 1;
        $this->pagination->initialize($config);
        $data['pages']                  = $this->pagination->create_links();


        if ($this->input->get('page') == null)
        {
            $offest = 0;
        }
        else
        {
            $offest = ($this->input->get('page') * $config['per_page'] - $config['per_page'] );
        }
        if ($province != NULL)
        {
            $data["srch_province"] = $province;
        }
        if ($city != NULL)
        {
            $province_city          = $this->main->getProvinceCity($city);
            $data["_Province_city"] = $province_city[0]['ostan_id'];
            if ($province != NULL)
            {
                $data["_city"] = $this->main->getCity($province); //when search by province AND city
            }
            else
            {
                $data["_city"] = $this->main->getCity($province_city[0]['ostan_id']); //when search by only city
            }
            $data["srch_city"] = $city;
        }
        else
        {
            $data["_city"] = $this->main->getCity($province);
        }
        if ($property != NULL)
        {
            $data["srch_property"] = $property;
        }
        if ($rooms != NULL)
        {
            $data["srch_room"] = $rooms;
        }
        if ($persons != NULL)
        {
            $data["srch_person"] = $persons;
        }
        if ($amount != NULL)
        {
            $data["srch_amount"] = $amount;
        }
        if ($priority != NULL)
        {
            $data["srch_priority"] = $priority;
        }
        $data["_province"] = $this->main->getProvince();
        $data["_visu"]     = $this->visu->getVisu($type_visu, $province, $city, $min_amount, $max_amount, $min_person, $max_person, $min_room, $max_room, $property, $priority, $config['per_page'], $offest, $have_favorite);
        $this->data        = $data;
        $this->middle      = 'main/showVisuV';
        $this->layout();
    }

    public function addToFavorite()
    {
        $visu_id = $this->input->post('ID');
        $type    = $this->input->post('type');
        $res     = $this->visu->addToFavorite($visu_id, $type);
        die(json_encode(array('status' => 'ok', 'msg' => '')));
    }

    function detail($visu_type, $visu_id)
    {
        $user_ip          = $this->input->ip_address();
        $res_rent_user_ip = $this->visu->getRentUserIp($user_ip, $visu_id);
        $allow_rent=array();
        if (is_array($res_rent_user_ip) and count($res_rent_user_ip) > 0)
        {
            $date1 = date_create(date('Y-m-d H:i:s'));
            $date2 = date_create($res_rent_user_ip[0]['create_date']);
            $diff  = date_diff($date1, $date2);
            if ($diff->days == 0)
            {
                $allow_rent['status'] = FALSE;
                $allow_rent['msg']= "درخواست شما برای اجاره ثبت گردید ، در اسرع وقت با شما تماس گرفته می شود.";
            }
            else
            {
                $allow_rent['status'] = TRUE;
            }
        }
        else
        {
            $allow_rent['status'] = TRUE;
        }

        $this->visu->visitItemVisu($visu_id);
        $res_detail   = $this->visu->getDetailVisu($visu_type, $visu_id);
        $res_opinion  = $this->visu->getOpinionVisu($visu_id);
        $data         = array('_detailVisu' => $res_detail, '_opinionVisu' => $res_opinion, '_allow_rent' => $allow_rent);
        $this->data   = $data;
        $this->middle = 'main/detailVisuV';
        $this->layout();
    }

    function registVisitorOpinion()
    {
        $building_id = $this->input->post('building_id');
        $opinion     = $this->input->post('opinion');
        $visu_type   = $this->input->post('type');
        $this->visu->registVisitorOpinion($visu_type, $building_id, $opinion);
        $data        = array(
            'success' => TRUE,
            'message' => '',
        );
        die(json_encode($data));
    }

    function reportViolation()
    {
        $building_id   = $this->input->post('building_id', TRUE);
        $reason_option = $this->input->post('reason_option');
        $reason_txt    = $this->input->post('reason_txt');
        $this->visu->reportViolation($building_id, $reason_option, $reason_txt);
        $data          = array(
            'success' => TRUE,
            'message' => '',
        );
        die(json_encode($data));
    }

    function requestRentVisu()
    {

        $building_id = $this->input->post('building_id', TRUE);
        $from_date   = $this->input->post('from_date', TRUE);
        $to_date     = $this->input->post('to_date', TRUE);
        $mobile      = $this->input->post('mobile', TRUE);
        $full_name   = $this->input->post('full_name', TRUE);
        if ($from_date == '' or $from_date == NULL)
        {
            $data = array(
                'success' => FALSE,
                'message' => 'لطفا تاریخ شروع رزرو سوئیت را وارد نمایید.',
            );
            die(json_encode($data));
        }
        if ($to_date == '' or $to_date == NULL)
        {
            $data = array(
                'success' => FALSE,
                'message' => 'لطفا تاریخ اتمام رزرو سوئیت را وارد نمایید.',
            );
            die(json_encode($data));
        }
        if ($mobile == '' or $mobile == NULL)
        {
            $data = array(
                'success' => FALSE,
                'message' => 'لطفا شماره همراه را وارد نمایید.',
            );
            die(json_encode($data));
        }
        if (!preg_match('/^09[0-9]{9}$/u', str_replace("\\\\", "", $mobile)))
        {
            $data = array(
                'success' => FALSE,
                'message' => 'لطفا شماره همراه را معتبر وارد نمایید.',
            );
            die(json_encode($data));
        }
        if ($full_name == '' or $full_name == NULL)
        {
            $data = array(
                'success' => FALSE,
                'message' => 'لطفا نام و نام خانوادگی را وارد نمایید.',
            );
            die(json_encode($data));
        }
        $res_rent_visu = $this->visu->requestRentVisu($building_id, $from_date, $to_date, $mobile, $full_name);
        if ($res_rent_visu)
        {
            $res_incremental_rent = $this->visu->incrementalRentVisu($building_id);
            if ($res_incremental_rent)
            {
                $data = array(
                    'success' => TRUE,
                    'message' => "درخواست شما برای اجاره ثبت گردید ، در اسرع وقت با شما تماس گرفته می شود.",
                );
                die(json_encode($data));
            }
            else
            {
                $data = array(
                    'success' => FALSE,
                    'message' => 'خطا در ثبت اطلاعات در پایگاه داده',
                );
                die(json_encode($data));
            }
        }
        else
        {
            $data = array(
                'success' => FALSE,
                'message' => 'خطا در ثبت اطلاعات در پایگاه داده',
            );
            die(json_encode($data));
        }
    }

}
