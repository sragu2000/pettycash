<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    public function __construct($config="rest") {
       parent::__construct();
        if(! $this->session->userdata('cashier')){
            redirect("authenticate");
        }
        $this->load->model("Mdl_common");
    }
    public function getCurentCashDetails($year=null,$month=null){
        $monthNum  = (int)$month;
        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
        $month = $dateObj->format('F');
        echo $this->Mdl_common->getCurentCashDetails($year, $month);
    }
	public function index()
	{
        $this->load->view('vw_header');
        $this->load->view('vw_navbar');
		$this->load->view("vw_petty");
        $this->load->view('vw_footer');
	}
    public function getCategories() {
        echo $this->Mdl_common->getCategories();
    }
    public function logout(){
		$this->session->unset_userdata("cashier");
		redirect("authenticate");
	}
    public function addanalysis(){
        $this->load->view('vw_header');
        $this->load->view('vw_navbar');
		$this->load->view("vw_addanalysis");
        $this->load->view('vw_footer');
    }
    public function newcategory(){
        $category = $this->input->post('category');
        $flag=$this->Mdl_common->addcategory($category);
        $this->sendJson(array("message" =>$flag["message"],"result"=>$flag["result"]));
    }
    public function addpayment(){
        $flag=$this->Mdl_common->addpayment();
        $this->sendJson(array("message" =>$flag["message"],"result"=>$flag["result"]));
    }

    public function viewPayments(){
        $this->load->view('vw_header');
        $this->load->view('vw_navbar');
		$this->load->view("vw_viewpayments");
        $this->load->view('vw_footer');
    }
    public function viewPaymentsYear(){
        $this->load->view('vw_header');
        $this->load->view('vw_navbar');
		$this->load->view("vw_viewpaymentsyear");
        $this->load->view('vw_footer');
    }

    public function getpaymentdata($year=null,$month=null){
        $monthNum  = (int)$month;
        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
        $month = $dateObj->format('F');
        echo $this->Mdl_common->getpaymentdata($year,$month);
    }

    public function getpaymentdatayear($year=null){
        echo $this->Mdl_common->getpaymentdatayear($year);
    }

    public function deleterecord($rid){
        $flag=$this->Mdl_common->deleteRecords($rid);
        if($flag==true){
            $this->session->set_flashdata("action","Record deleted Successfully");
            redirect("home/viewpayments");
        }else{
            $this->session->set_flashdata("action","Can't Delete Record");
            redirect("home/viewpayments");
        }
    }
    public function editpayment($rid){
        $this->load->view('vw_header');
        $this->load->view('vw_navbar');
        $data["record"]=$rid;
		$this->load->view("vw_updatepayments",$data);
        $this->load->view('vw_footer');
    }
    public function getparticularrecord($record){
        echo $this->Mdl_common->getparticularrecord($record);
    }   
    public function editpay(){
        $description=$this->input->post("description");
        $vouchernum=$this->input->post("vouchernum");
        $amount=$this->input->post("amount");
        $rec=$this->input->post("recid");
        $flag=$this->Mdl_common->editpay($rec,$description,$vouchernum,$amount);
        $this->sendJson(array("message"=>$flag["message"],"result"=>$flag["result"]));
    }
    
    private function sendJson($data) {
        $this->output->set_header('Content-Type: application/json; charset=utf-8')->set_output(json_encode($data));
    }
}
