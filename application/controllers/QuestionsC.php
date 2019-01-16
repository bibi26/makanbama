<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class QuestionsC extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('main');
    }

    public function index()
    {
        $this->main->pageVisit('pageQuestions');
        $this->middle = 'questions';
        $this->layout();
    }

}
