<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authenticate extends CI_Controller {
    public function __construct($config="rest") {
        parent::__construct();
        if($this->session->userdata('cashier')){
            redirect("home");
        }
    }
	public function index()
	{
		$this->load->view('vw_header');
		$this->load->view('vw_signin');
		$this->load->view('vw_footer');
	}
    public function signin(){
        $this->index();
    }
    public function signinuser(){
        $user=$this->input->post('username');
        $pass=$this->input->post('password');
        if($user=="admin" && $pass=="admin123"){
            $this->sendJson(array("message"=>"Login Success"));
            $this->session->set_userdata("cashier","admin");
        }else{
            $this->sendJson(array("message"=>"Incorrect Username or Password"));
        }
    }
    private function sendJson($data) {
        $this->output->set_header('Content-Type: application/json; charset=utf-8')->set_output(json_encode($data));
    }
}
