<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

    //set the class variable.
    var $template = array();
    var $data     = array();

    //Load layout    
    public function layout($theme = '')
    {
        // making temlate and send data to view.
        $this->template['header']   = $this->load->view('layout/header', $this->data, true);
        $this->template['content1'] = $this->load->view('layout/content1', $this->data, true);

        if ($theme == 'panelUser')
        {
            $this->template['panelUser1'] = $this->load->view('layout/panelUser1', $this->data, true);
        }
        if ($theme == 'panelPassenger')
        {
            $this->template['panelPassenger1'] = $this->load->view('layout/panelPassenger1', $this->data, true);
        }
        if ($theme == 'panelAdmin')
        {
            $this->template['panelAdmin1'] = $this->load->view('layout/panelAdmin1', $this->data, true);
        }

        $this->template['middle'] = $this->load->view($this->middle, $this->data, true);

        if ($theme == 'panelUser')
        {
            $this->template['panelUser2'] = $this->load->view('layout/panelUser2', $this->data, true);
        }

        if ($theme == 'panelPassenger')
        {
            $this->template['panelPassenger2'] = $this->load->view('layout/panelPassenger2', $this->data, true);
        }
        if ($theme == 'panelAdmin')
        {
            $this->template['panelAdmin2'] = $this->load->view('layout/panelAdmin2', $this->data, true);
        }

        $this->template['content2'] = $this->load->view('layout/content2', $this->data, true);
        $this->template['footer']   = $this->load->view('layout/footer', $this->data, true);
        $this->load->view('layout/index', $this->template);
    }

}
