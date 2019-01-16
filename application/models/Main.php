<?php
class main extends CI_Model
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
    function getProvinceCity($city)
    {
        $this->db->select('id,ostan_id');
        $this->db->from('city');
        $this->db->where('id', $city);
        return $this->db->get()->result_array();
    }
    
    function pageVisit($type)
    {
       $this->db->where('type', $type);
        $this->db->set('visit', 'visit+1', FALSE);
        return $this->db->update('log_visits');
    }
    
    

}
