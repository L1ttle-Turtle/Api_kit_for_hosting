<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Demo extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }

    public function index()
    {
        $this->load->view('demo/dashboard');
    }

    public function dashboard()
    {
        $this->load->view('demo/dashboard');
    }

}