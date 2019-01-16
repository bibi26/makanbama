<?php

class Visu extends CI_Model
{

    function _construct()
    {
        parent::_construct();
    }

    function getProvince()
    {
        $this->db->select('id,name');
        $this->db->from('province');
        $this->db->order_by('name');
        return $this->db->get()->result_array();
    }

    function getCity($province)
    {
        $this->db->select('id,name');
        $this->db->from('city');
        $this->db->where('ostan_id', $province);
                $this->db->like('id', '0000', 'before');

        $this->db->order_by('name');
        return $this->db->get()->result_array();
    }

    function getCountVisu($type_visu, $province, $city, $min_amount, $max_amount, $min_person, $max_person, $min_room, $max_room, $property)
    {
        $this->db->select('building_info.*,building_detail.*');
        $this->db->join('building_detail', 'building_info.id= building_detail.building_id');

        $this->db->where(array('type' => "{$type_visu}", 'show' => '1', 'status' => '1'));
        if ($province != NULL)
        {
            $this->db->where(array('province_id' => $province));
        }
        if ($city != NULL)
        {
            $this->db->where(array('city_id' => $city));
        }
        if ($min_amount != NULL and $max_amount != NULL and is_numeric($min_amount) and is_numeric($max_amount))
        {
            $this->db->where(array('rent_price >= ' => $min_amount, 'rent_price <= ' => $max_amount));
        }
        if ($min_person != NULL and $max_person != NULL and is_numeric($min_person) and is_numeric($max_person))
        {
            $this->db->where(array('persons_normal >= ' => $min_person, 'persons_max <= ' => $max_person));
        }
        if ($min_room != NULL and $max_room != NULL and is_numeric($min_room) and is_numeric($max_room))
        {
            $this->db->where(array('room_count >= ' => $min_room, 'room_count <= ' => $max_room));
        }
        if ($property != NULL)
        {
            foreach (explode('-', $property) as $p)
            {
                $this->db->where(array("building_detail.{$p}" => 1));
            }
        }
        $this->db->from('building_info');

        return $this->db->count_all_results();
    }

    function getVisu($type_visu, $province, $city, $min_amount, $max_amount, $min_person, $max_person, $min_room, $max_room, $property, $priority, $limit, $offest, $have_favorite)
    {

        if (isset($_COOKIE['MakanBaMa']))
        {
            $this->db->select('building_info.*,building_detail.*,city.name AS city,favorite.building_id as favoriteBuilding,favorite.user_id as favoriteHosteler,building_info.id as ID');
            $this->db->join('favorite', 'building_info.id= favorite.building_id', 'left');
            if ($have_favorite)
            {
                $this->db->where(array('favorite.user_id' => unserialize(get_cookie('MakanBaMa'))['USERID']));
            }
        }
        else
        {
            $this->db->select('building_info.*,building_detail.*,city.name AS city,building_info.id as ID');
        }
        $this->db->join('building_detail', 'building_info.id= building_detail.building_id');
        $this->db->join('city', 'building_info.city_id= city.id');

        $this->db->where(array('building_info.type' => "{$type_visu}", 'show' => '1', 'status' => '1'));
        if ($province != NULL)
        {
            $this->db->where(array('province_id' => $province));
        }
        if ($city != NULL)
        {
            $this->db->where(array('city_id' => $city));
        }
        if ($min_amount != NULL and $max_amount != NULL and is_numeric($min_amount) and is_numeric($max_amount))
        {
            $this->db->where(array('rent_price >= ' => $min_amount, 'rent_price <= ' => $max_amount));
        }
        if ($min_person != NULL and $max_person != NULL and is_numeric($min_person) and is_numeric($max_person))
        {
            $this->db->where(array('persons_normal >= ' => $min_person, 'persons_max <= ' => $max_person));
        }
        if ($min_room != NULL and $max_room != NULL and is_numeric($min_room) and is_numeric($max_room))
        {
            $this->db->where(array('room_count >= ' => $min_room, 'room_count <= ' => $max_room));
        }
        if ($property != NULL)
        {
            foreach (explode('-', $property) as $p)
            {
                $this->db->where(array("building_detail.{$p}" => 1));
            }
        }

        $this->db->from('building_info');
        if ($priority == NULL)
        {
            $this->db->order_by('building_info.id', 'desc');
        }
        else
        {
            switch ($priority)
            {
                case 'newest':
                    $this->db->order_by("building_info.id", 'desc');

                    break;
                case 'expensive':
                    $this->db->order_by("building_info.rent_price", 'desc');

                    break;
                case 'cheapest':
                    $this->db->order_by("building_info.rent_price", 'asc');

                    break;
            }
        }

        $this->db->limit($limit, $offest);
        return $this->db->get()->result_array();
    }

    function addToFavorite($visu_id, $type)
    {
        $this->db->select('*');
        $this->db->where(array('building_id' => $visu_id, 'user_id' => unserialize(get_cookie('MakanBaMa'))['USERID']))->from('favorite');
        $count = $this->db->count_all_results();
        if ($count == 0)
        {
            $data = array(
                'building_id' => $visu_id,
                'user_id' => unserialize(get_cookie('MakanBaMa'))['USERID'],
                'type' => $type,
            );
            $this->db->set('create_date', 'NOW()', FALSE);
            return $this->db->insert('favorite', $data);
        }
        else
        {
            $this->db->where(array('building_id' => $visu_id, 'user_id' => unserialize(get_cookie('MakanBaMa'))['USERID']));
            $this->db->delete('favorite');
        }
    }

    function visitAllVisu($type_visu)
    {
        $this->db->where('type', $type_visu);
        $this->db->set('visit', 'visit+1', FALSE);
        return $this->db->update('log_visits');
    }

    function visitSrchVisu($type_visu)
    {
        $this->db->where('type', "search{$type_visu}");
        $this->db->set('visit', 'visit+1', FALSE);
        return $this->db->update('log_visits');
    }

    function visitItemVisu($visu_id)
    {
        $this->db->where('id', $visu_id);
        $this->db->set('visit', 'visit+1', FALSE);
        return $this->db->update('building_info');
    }

    function getDetailVisu($visu_type, $visu_id)
    {
        if (isset($_COOKIE['MakanBaMa']))
        {
            $this->db->select("building_detail.*,building_info.*,building_info.create_date as create_at,building_info.id as ID,city.name AS city,building_info.user_id AS HOST,province.name AS _province,city.name AS _city , CONCAT (first_name,' ',last_name) AS FULL_NAME,mobile AS MOBILE,favorite.building_id as favoriteBuilding,favorite.user_id as favoriteHosteler", FALSE);
            $this->db->join('favorite', 'building_info.id= favorite.building_id', 'left');
        }
        else
        {
            $this->db->select("building_detail.*,building_info.*,building_info.create_date as create_at,building_info.id as ID,city.name AS city,building_info.user_id AS HOST,province.name AS _province,city.name AS _city , CONCAT (first_name,' ',last_name) AS FULL_NAME,mobile AS MOBILE", FALSE);
        }
        $this->db->join('building_detail', 'building_detail.building_id=building_info.id', 'left');
        $this->db->join('province', 'province.id=building_info.province_id', 'left');
        $this->db->join('users', 'users.id=building_info.user_id', 'left');
        $this->db->join('city', 'city.id=building_info.city_id', 'left');
        $this->db->where(array('building_info.type' => "{$visu_type}", 'building_info.id' => $visu_id));
        $this->db->from('building_info');
        return $this->db->get()->result_array();
    }

    function getOpinionVisu($visu_id)
    {
        $this->db->select("visitor_opinion.opinion,"
                . "visitor_opinion.id,"
                . "visitor_opinion.user_id,"
                . "visitor_opinion.response,"
                . "visitor_opinion.response_date,"
                . "visitor_opinion.create_date as opinion_date,"
                . "visitor_opinion.user_id as user_id_passenger,"
                . " CONCAT (users.first_name,' ',users.last_name) AS full_name_passenger", FALSE);
        $this->db->join('users', 'users.id=visitor_opinion.user_id', 'left');
        $this->db->where(array('main_id' => $visu_id, 'visitor_opinion.show' => 1));
        $this->db->from('visitor_opinion');
        $this->db->order_by('id', 'desc');
        return $this->db->get()->result_array();
    }

    function registVisitorOpinion($visu_type, $building_id, $opinion)
    {
        $user = unserialize(get_cookie('MakanBaMa'))['USERID'] ? unserialize(get_cookie('MakanBaMa'))['USERID'] : NULL;
        $data = array(
            'opinion' => $opinion,
            'main_id' => $building_id,
            'type' => $visu_type,
            'user_id' => $user
        );
        $this->db->set('create_date', 'NOW()', FALSE);
        return $this->db->insert('visitor_opinion', $data);
    }

    function reportViolation($building_id, $reason_option, $reason_txt)
    {
        $user = unserialize(get_cookie('MakanBaMa'))['USERID'] ? unserialize(get_cookie('MakanBaMa'))['USERID'] : NULL;
        $data = array(
            'reason_option' => $reason_option,
            'reason_txt' => $reason_txt,
            'user_id' => $user,
            'building_id' => $building_id,
        );
        $this->db->set('create_date', 'NOW()', FALSE);
        return $this->db->insert('violations', $data);
    }

    function requestRentVisu($building_id, $from_date, $to_date, $mobile, $full_name)
    {
        $user = unserialize(get_cookie('MakanBaMa'))['USERID'] ? unserialize(get_cookie('MakanBaMa'))['USERID'] : NULL;
        $data = array(
            'from_date_g' => jalali_to_gregorian(substr($from_date, 0, 4), substr($from_date, 5, 2), substr($from_date, 8, 2), '-'),
            'from_date_j' => $from_date,
            'to_date_g' => jalali_to_gregorian(substr($to_date, 0, 4), substr($to_date, 5, 2), substr($to_date, 8, 2), '-'),
            'to_date_j' => $to_date,
            'mobile' => $mobile,
            'full_name' => $full_name,
            'user_id' => $user,
            'building_id' => $building_id,
            'ip' => $this->input->ip_address(),
        );
        $this->db->set('create_date', 'NOW()', FALSE);
        return $this->db->insert('rents', $data);
    }

    function incrementalRentVisu($building_id)
    {
        $this->db->where('id', $building_id);
        $this->db->set('request', 'request+1', FALSE);
        return $this->db->update('building_info');
    }
    
      function getRentUserIp($user_ip,$visu_id)
    {
        $this->db->select("*");
        $this->db->where(array('ip' => $user_ip, 'building_id' => $visu_id));
        $this->db->from('rents');
        $this->db->limit(1);
        $this->db->order_by('id','desc');
        return $this->db->get()->result_array();
    }

}
