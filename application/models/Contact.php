<?php

class Contact extends CI_Model
{

    function _construct()
    {
        parent::_construct();
    }

    function regist($input)
    {
        $data= array(
            'full_name' => $input['full_name'],
            'mobile' => $input['mobile'],
            'email' =>$input['email'],
            'province' => $input['province'],
            'city' => $input['city'],
            'message' => $input['message'],
            'ip' => $this->input->ip_address(),
            'browser' => $_SERVER['HTTP_USER_AGENT'] ,
            'user_id' =>(get_cookie('MakanBaMa'))?unserialize(get_cookie('MakanBaMa'))['USERID']:'',
        );
       $this->db->set('create_date','NOW()', FALSE);
       return $this->db->insert('contact', $data);
    }

}
