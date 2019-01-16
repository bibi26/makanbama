<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class PlaceC extends MY_Controller
{

    function __construct()
    {

        parent::__construct();
        $this->load->model('main/place');
        $this->load->model('main');
    }

    public function index()
    {
        $this->place->visitAllPlace();
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
        if ($province != NULL or $city != NULL)
        {
            $this->place->visitSrchPlace();
        }
        
        if ($this->input->get('favorite'))
        {
            $have_favorite = TRUE;
        }
        else
        {
            $have_favorite = FALSE;
        }
        $config['base_url']             = base_url(uri_string());
        $config['total_rows']           = $this->place->getCountPlaces($province, $city, $have_favorite);
        $config['per_page']             = 10;
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
            $offest = ($this->input->get('page')*$config['per_page'] -$config['per_page'] );
        }
        if ($province != NULL)
        {
            $data["srch_province"] = $province;
        }
        if ($city != NULL)
        {
            $data["_city"]     = $this->main->getCity($province);
            $data["srch_city"] = $city;
        }
        else
        {
            $data["_city"] = $this->main->getCity($province);
        }
        $data["_province"] = $this->main->getProvince();
        $data["_places"]   = $this->place->getPlaces($province, $city, $config['per_page'], $offest, $have_favorite);
        $this->data        = $data;
        $this->middle      = 'main/showPlacesV';
        $this->layout();
    }

    function detail($place_id)
    {
        $this->place->visitItemPlace($place_id);
        $res_detail_place = $this->place->getDetailPlace($place_id);
        $data             = array('_detailPlace' => $res_detail_place);
        $data["_villas"]  = $this->place->getVisu($type='villa',$res_detail_place[0]['city_id']);
        $data["_suits"]   = $this->place->getVisu($type='suit',$res_detail_place[0]['city_id']);
        $this->data       = $data;
        $this->middle     = 'main/detailPlaceV';
        $this->layout();
    }

    public function addToFavorite()
    {
        $place_id = $this->input->post('placeID');
        $status  = $this->input->post('status');
        $res     = $this->place->addToFavorite($place_id, $status);
        die(json_encode(array('status' => 'ok', 'msg' => '')));
    }

}
