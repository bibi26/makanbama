<?php

class Change_pass extends CI_Model
{

    function _construct()
    {
        parent::_construct();
    }

    function chkCorrectUrl($user,$vc)
    {
      $this->db->select('email')->where(array('id' =>$user, 'verify_code' => $vc))->from('users');
        return $this->db->get()->result_array();
    }
    function cp($email,$pass)
    {
        $this->db->where('email', $email);
        return $this->db->update('users', array('pas'=>$pass));
    }


}
