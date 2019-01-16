<?php

class Place extends CI_Model
{

    function _construct()
    {
        parent::_construct();
    }

    function getPlaces($province, $city, $limit, $offest, $have_favorite)
    {
        if (isset($_COOKIE['MakanBaMa']))
        {
            $this->db->select('places.*,province.name AS _province,city.name AS _city,favorite.building_id as favoriteBuilding,favorite.user_id as favoriteHosteler,places.id as ID');
            $this->db->join('favorite', 'places.id= favorite.building_id', 'left');
            if ($have_favorite)
            {
                $this->db->where(array('favorite.user_id' => unserialize(get_cookie('MakanBaMa'))['USERID']));
            }
        }
        else
        {
            $this->db->select('places.*,province.name AS _province,city.name AS _city,places.id as ID');
        }
        $this->db->join('province', 'province.id=places.province_id', 'left');
        $this->db->join('city', 'city.id=places.city_id', 'left');
        $this->db->where(array('show' => '1', 'status' => '1'));
        if ($province != NULL)
        {
            $this->db->where(array('province_id' => $province));
        }
        if ($city != NULL)
        {
            $this->db->where(array('city_id' => $city));
        }
        $this->db->from('places');
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $offest); // limit(offest,limit)
        return $this->db->get()->result_array();
//                 var_dump($limit, $offest,$this->db->last_query());die;
    }

    function getCountPlaces($province, $city, $have_favorite)
    {
        if (isset($_COOKIE['MakanBaMa']))
        {
            $this->db->select('places.id');
            $this->db->join('favorite', 'places.id= favorite.building_id', 'left');
            if ($have_favorite)
            {
                $this->db->where(array('favorite.user_id' => unserialize(get_cookie('MakanBaMa'))['USERID']));
            }
        }
        else
        {
            $this->db->select('places.id');
        }

        $this->db->where(array('show' => '1', 'status' => '1'));
        if ($province != NULL)
        {
            $this->db->where(array('province_id' => $province));
        }
        if ($city != NULL)
        {
            $this->db->where(array('city_id' => $city));
        }
        $this->db->from('places');
        return $this->db->count_all_results();
    }

    function visitAllPlace()
    {
        $this->db->where('type', 'place');
        $this->db->set('visit', 'visit+1', FALSE);
        return $this->db->update('log_visits');
    }

    function visitSrchPlace()
    {
        $this->db->where('type', 'searchPlace');
        $this->db->set('visit', 'visit+1', FALSE);
        return $this->db->update('log_visits');
    }

    function visitItemPlace($place_id)
    {
        $this->db->where('id', $place_id);
        $this->db->set('visit', 'visit+1', FALSE);
        return $this->db->update('places');
    }

    function getDetailPlace($place_id)
    {

        if (isset($_COOKIE['MakanBaMa']))
        {
            $this->db->select('places.*,province.name AS _province,city.name AS _city,favorite.building_id as favoriteBuilding,favorite.user_id as favoriteHosteler,places.id as ID');
            $this->db->join('favorite', 'places.id= favorite.building_id', 'left');

        }
        else
        {
            $this->db->select('places.*,province.name AS _province,city.name AS _city,places.id as ID');
        }

            $this->db->join('province', 'province.id=places.province_id', 'left');
            $this->db->join('city', 'city.id=places.city_id', 'left');
        $this->db->where(array('places.id' => $place_id));
        $this->db->from('places');
        return $this->db->get()->result_array();
    }

    function getVisu($type,$city)
    {
        $this->db->select('building_info.*');
        $this->db->where(array('type' => $type, 'show' => '1', 'status' => '1', 'city_id' => $city));
        $this->db->from('building_info');
        return $this->db->get()->result_array();
    }

    function addToFavorite($place_id, $status)
    {
        $this->db->select('*');
        $this->db->where(array('building_id' => $place_id, 'user_id' => unserialize(get_cookie('MakanBaMa'))['USERID']))->from('favorite');
        $count = $this->db->count_all_results();
        if ($count == 0)
        {
            $data = array(
                'building_id' => $place_id,
                'user_id' => unserialize(get_cookie('MakanBaMa'))['USERID'],
                'type' => 'place',
            );
            $this->db->set('create_date', 'NOW()', FALSE);
            return $this->db->insert('favorite', $data);
        }
        else
        {
            $this->db->where(array('building_id' => $place_id, 'user_id' => unserialize(get_cookie('MakanBaMa'))['USERID']));
            $this->db->delete('favorite');
        }
    }

}
