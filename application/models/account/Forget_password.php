<?php

class Forget_password extends CI_Model
{

    function _construct()
    {
        parent::_construct();
    }

    function chkExistEmail($email)
    {
        $this->db->select('id,status,email')->where(array( 'email' => $email))->from('users');
        return $this->db->get()->result_array();
    }
    function updateVerifyCode($id,$verify_code)
    {
        return $this->db->where('id', $id)->update('users', array('verify_code'=>$verify_code));
    }

}
