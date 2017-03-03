<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: wzh
 * Date: 27/12/2016
 * Time: 2:52 PM
 */
class Article extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getArticleByKeywordList(){
        $this->output->set_header('Access-Control-Allow-Origin:*');
        $this->output->set_header('Cache-Control: public');
        $sources =  $this->input->get('source');
        $resultList = "[";
        foreach ($sources as $source){
            $array = explode("-",$source);
            $resultList = $resultList.$this->getData($array[0],$array[1]).",";
        }
        $resultList = substr($resultList,0,strlen($resultList)-1);
        $resultList = $resultList."]";
        $this->output->set_content_type('application/json')->set_output($resultList);

    }
    public function getArticleByKeyword(){
        $this->output->set_header('Access-Control-Allow-Origin:*');
        $this->output->set_header('Cache-Control: public');
        $source =  $this->input->get('source');
        $array = explode("-",$source);
        $resultList = $this->getData($array[0],$array[1]);
        $this->output->set_content_type('application/json')->set_output($resultList);

    }

    public function grabData(){
        $github_keywords=array("css","html","java","javascript","php","python","ruby","cpp","objective-c","swift","c","csharp");
        $csdn_keywords=array("mobile","web","enterprise","code","www","database","system","cloud","software","other");
//
        foreach ($csdn_keywords as $keyword){
            $this->grabCsdn($keyword);
        }
        foreach ($github_keywords as $keyword){
          $this->grabGithub($keyword);
        }

    }
    private function grabGithub($keyword){
        $titles = array();
        $links = array();
        $base_url = "https://github.com";
        $url = "https://github.com/trending/".$keyword;
        $content = $this->getContent($url);
        $array = $this->getAllWordsByReg($content,'/<h3>.*?<\/h3>/sm');
        for($i=0;$i<count($array[0]);$i++){
            $s = $this->getFirstWordsByReg($array[0][$i],'/href=\".*?\"/');
            array_push($titles,substr($s,6,strlen($s)-7));
            array_push($links,$base_url.substr($s,6,strlen($s)-7));
        }
        $this->insertData($titles,$links,$keyword,"github");
        echo "github插入成功!";
    }

    private function grabCsdn($keyword){
        $titles = array();
        $links = array();
        $url = "http://blog.csdn.net/".$keyword."/hotarticle.html";
        $content = $this->getContent($url);
        $array = $this->getAllWordsByReg($content,'/<a.*?<\/h3>/');
        for($i=0;$i<count($array[0]);$i++){
            $link = $this->getFirstWordsByReg($array[0][$i],'/href=\".*?\"/');
            $title = $this->getFirstWordsByReg($array[0][$i],'/>.*?<\/a>/');
            array_push($links,substr($link,6,strlen($link)-7));
            array_push($titles,substr($title,1,strlen($title)-5));
        }
        $this->insertData($titles,$links,$keyword,"csdn");
        echo "csdn插入成功!";
    }

    private function getContent($url){
        $opts = array(
            'http'=>array(
                'method'=>"GET",
                'timeout'=>600,
            )
        );
        $context = stream_context_create($opts);
        $contents = file_get_contents($url,false,$context);
        return $contents;
    }

    private function getAllWordsByReg($content,$reg){
        preg_match_all($reg,$content,$array);
        return $array;
    }
    private function getFirstWordsByReg($content,$reg){
        preg_match($reg,$content,$array);
        return $array[0];
    }
    private function getJson($query){
        $resultList = "[";
        foreach ($query->result_array() as $row)
        {
            $result=array();
            $result["id"] = $row["id"];
            $result["title"] = $row["title"];
            $result["link"] = $row["link"];
            $result["source"] = $row["source"]."-".$row["keyword"];
            $result["date"] = $row["date"];
            $resultList = $resultList.json_encode($result).",";
        }
        $resultList = substr($resultList,0,strlen($resultList)-1);
        $resultList = $resultList."]";
        if(strlen($resultList)==1){
            $resultList="[".$resultList;
        }
        return $resultList;
    }
    private function getData($source,$keyword){
        $date=date("Y-m-d");
        $query = $this->db->get_where('tb_article', array('source' => $source,'keyword'=> $keyword,'date' =>$date), 3, 0);
//        $sql = "select * from tb_article WHERE source='$source' AND keyword='$keyword'AND date='$date' limit 3 ";
        try{
            return $this->getJson($query);
        }catch (Exception $e){
        }
    }

    private function insertData($titles,$links,$keyword,$source){
        for($i=0;$i<count($titles);$i++){
            $sql = "insert ignore into tb_article VALUES (NULL ,'$titles[$i]','$links[$i]','$keyword','$source',now())";
            try{
                $query = $this->db->query($sql);
            }catch (Exception $e){
            }
        }

    }
}