<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: wzh
 * Date: 2016/10/25
 * Time: 下午2:25
 */
class NJUHeadlines extends CI_Controller
{


    public function getSchoolNews(){

        $page =  $this->input->get('page');
        $start = $page*20;
        $this->output->set_header('Access-Control-Allow-Origin:*');
        $this->output->set_header('Cache-Control: public');

        $date = date("Y-m-d");
        $sql = "select * from tb_news order by id DESC  ";
        $this->load->database();
        $query = $this->db->query($sql);
        $resultList = "[";
        foreach ($query->result() as $row)
        {
            $resultList = $resultList.json_encode($row).",";
        }
        $resultList = substr($resultList,0,strlen($resultList)-1);
        $resultList = $resultList."]";
        $this->output->set_content_type('application/json')->set_output($resultList);
    }


    public function getTopical(){
        $this->output->set_header('Access-Control-Allow-Origin:*');
        $this->output->set_header('Cache-Control: public');
        $date = date("Y-m-d");
        $sql = "select * from tb_topical WHERE date = '$date'";
        $this->load->database();
        $query = $this->db->query($sql);
        if($query->num_rows()==0) {
            $date = date("Y-m-d",strtotime("-1 day"));
            $sql = "select * from tb_topical WHERE  date = '$date'";
            $query = $this->db->query($sql);
        }
        $resultList = "[";
        foreach ($query->result() as $row)
        {
            $resultList = $resultList.json_encode($row).",";
        }
        $resultList = substr($resultList,0,strlen($resultList)-1);
        $resultList = $resultList."]";
        $this->output->set_content_type('application/json')->set_output($resultList);
    }



    public function getWechat(){
        $this->output->set_header('Access-Control-Allow-Origin:*');
        $this->output->set_header('Cache-Control: public');
        $page = $this->input->get('page');
        $type = $this->input->get('type');
        $start = $page*10;
        $sql = "select * from tb_wechat WHERE type = '$type' order by id DESC limit 0,20 ";
        $this->load->database();

        $query = $this->db->query($sql);
        $resultList = "[";
        foreach ($query->result() as $row)
        {
            $resultList = $resultList.json_encode($row).",";
        }
        $resultList = substr($resultList,0,strlen($resultList)-1);
        $resultList = $resultList."]";
        $this->output->set_content_type('application/json')->set_output($resultList);
    }

}