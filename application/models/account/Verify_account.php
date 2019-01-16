<?php

class Verify_account extends CI_Model
{

    function _construct()
    {
        parent::_construct();
    }



    function hasVerifyAccount($verify_code)
    {
        $this->db->where(array('verify_code' => $verify_code,'status' => 1))->from('users');
        $count = $this->db->count_all_results();
        return $count;
    }


    function activeAccount($verify_code)
    {
        $res = $this->db->where(array('verify_code' => $verify_code))->update('users', array('status' => 3));
        return $res;
    }

}
