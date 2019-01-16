<?php

class Response_opinion_visitors extends CI_Model
{

    function _construct()
    {
        parent::_construct();
    }

    function getDetailOpinion($opinion_id)
    {
        $user = unserialize($_COOKIE['MakanBaMa'])['USERID'];
        $this->db->select('*');
        $this->db->where(array('user_id' => $user, 'id' => $opinion_id));
        $this->db->from('visitor_opinion');
        return $this->db->get()->result_array();
    }
    function getResponseOpinion($opinion_id)
    {
        $user = unserialize($_COOKIE['MakanBaMa'])['USERID'];
        $this->db->select('response');
        $this->db->where(array('user_id' => $user, 'id' => $opinion_id));
        $this->db->from('visitor_opinion');
        return $this->db->get()->result_array();
    }

    function regist($opinion_id, $response_opinion)
    {
        $user = unserialize(get_cookie('MakanBaMa'))['USERID'];
        $this->db->set('create_date', 'NOW()', FALSE);
        return $this->db->update('visitor_opinion', array('show' => 0,'response' => $response_opinion, 'response_date' => date('Y-m-d H:i:s')),array('id'=>$opinion_id,'user_id'=>$user));
        
    }

}
