<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_common extends CI_Model{
	public function getCategories(){
        $flag=$this->db->query("SELECT categoryid as id, categoryname as cname from category")->result();
        return json_encode($flag,true);
    }
    public function addcategory($category){
        if($this->db->query("select * from category where categoryname='$category'")->num_rows()>0){
            return array("message"=>"Category already exists","result"=>false);
        }else{
            if($this->db->query("insert into category(categoryname) values('$category')")){
                return array("message"=>"Category added successfully","result"=>true);
            }else{
                return array("message"=>"Unknown Error","result"=>false);
            }
        }
    }
    public function addpayment(){
        $data["description"]=$this->input->post("description");
        $data["voucherid"]=$this->input->post("vouchernum");
        $data["categoryid"]=$this->input->post("analysis");
        $data["amount"]=$this->input->post("amount");
        $data["date"]=$this->input->post("date");
        $date=$this->input->post("date");
        $data["month"]=date_format(date_create($date),"F");
        $data["year"]=date_format(date_create($date),"Y");
        if($this->db->insert("payments",$data)){
            return array("message"=>"Payment added successfully","result"=>true);
        }else{
            return array("message"=>"Adding payment failed","result"=>false);
        }
    }
    public function deleteRecords($rid){
        if($this->db->query("DELETE FROM payments where recordid='$rid'")){
            return true;
        }else{
            return false;
        }
    }

    public function getCurentCashDetails($year,$month){
        $flag=$this->db->query("SELECT amountrs as totalamount, sum(amount) as spent from payments,petty where month='$month' and year='$year' and desval='totalamount'")->result();
        return json_encode($flag,true);
    }

    public function getpaymentdata($year,$month){
        $result=$this->db->query("SELECT recordid as rid, voucherid as id, description as description, amount as amount, date as date, categoryname as category FROM payments,category WHERE category.categoryid=payments.categoryid and month='$month' and year='$year'")->result();
        return json_encode($result,true);
    }
    public function getpaymentdatayear($year){
        $result=$this->db->query("SELECT recordid as rid, voucherid as id, description as description, amount as amount, date as date, categoryname as category FROM payments,category WHERE category.categoryid=payments.categoryid and year='$year'")->result();
        return json_encode($result,true);
    }
    // public function getRecordData($rid){
    //     $flag=$this->db->query("SELECT * FROM payments where recordid = '$rid'")->first_row();
    //     return array("voucherid"=>$flag.voucherid,"")
    // }
    public function getparticularrecord($record){
        $flag=$this->db->query("SELECT voucherid, description, amount, categoryname FROM payments,category where category.categoryid=payments.categoryid and recordid = '$record'")->result();
        return json_encode($flag,true);
    }
    public function editpay($rec,$description,$vouchernum,$amount){
        if($this->db->query("update payments set description='$description', amount='$amount', voucherid='$vouchernum' where recordid = '$rec'")){
            return array("message"=>"Edited Sucessfully","result"=>true);
        }else{
            return array("message"=>"Can't edit the record","result"=>false);
        }
    }
}
