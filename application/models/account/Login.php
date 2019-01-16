<?php

class Login extends CI_Model
{

    function _construct()
    {
        parent::_construct();
    }

    function auth($email, $pas)
    {
        $this->db->where(array('pas' => md5($pas), 'email' => $email))->from('users');
        return $this->db->get()->result_array();
    }

    function loginLog($status, $email, $pas)
    {
        $this->db->set('create_date', 'NOW()', FALSE);
        $data = array(
            'status' => $status,
            'username' => $email,
            'security' => $pas,
            'ip' => $this->input->ip_address(),
            'browser1' => $this->agent->browser(),
            'browser2' => $this->agent->agent_string(),
        );
        $this->db->insert("login_log", $data);
        return $this->db->insert_id();
    }

}
