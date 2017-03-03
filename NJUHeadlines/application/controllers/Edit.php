<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: wzh
 * Date: 2016/10/28
 * Time: 下午9:21
 */
class Edit extends CI_Controller
{

    const BASE_URL="http://182.254.150.201/";

    public function addWechat(){

        $data = $this->input->post('data');
        $types=$data['types'];
        $contentLinks=$data['contentLinks'];
        $sql='';
            for($i=0;$i<count($contentLinks);$i++){
                if($contentLinks[$i]!=''){
                    $sql=$sql.$this->grabData($contentLinks[$i],$types[$i]);
                }
            }

        $result=array("status"=>1);
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    private function grabData($url,$type){

        $contents = file_get_contents($url);

        preg_match('/nickname = ".*?"/',$contents,$source);
        preg_match('/msg_title = ".*?"/',$contents,$title);
        preg_match('/msg_desc = ".*?"/',$contents,$profile);
        preg_match('/msg_cdn_url = ".*?"/',$contents,$imageLink);

        $my_source=$source[0];
        $my_title=$title[0];
        $my_profile=$profile[0];
        $my_imagelink=$imageLink[0];

        $my_source=substr($my_source,12,strlen($my_source)-13);
        $my_source=str_replace('&nbsp;','',$my_source);

        $my_title=substr($my_title,13,strlen($my_title)-14);
        $my_title=str_replace('&nbsp;','|',$my_title);
        $my_title=str_replace('x26nbsp;','|',$my_title);
        $my_title=str_replace('x26quot;','',$my_title);
        $my_title=str_replace('<br>',',',$my_title);

        $my_profile=substr($my_profile,12,strlen($my_profile)-13);
        $my_profile=str_replace('&nbsp;','|',$my_profile);
        $my_profile=str_replace('x26nbsp;','|',$my_profile);
        $my_profile=str_replace('<br>',',',$my_profile);

        $my_imagelink=substr($my_imagelink,15,strlen($my_imagelink)-16);
        $my_imagelink=$this::BASE_URL.$this->grabImage($my_imagelink,"images/".uniqid().".png");

        $sql = "insert into tb_wechat ";
        $sql=$sql."values (NULL,'$my_title','$my_profile','$my_imagelink','$url','$my_source',now(),";
        if($type=="推荐"){
            $sql=$sql."'rec'";
        }else if ($type=="团学"){
            $sql=$sql."'school'";
        }else if($type=="院系"){
            $sql=$sql."'department'";
        }else if($type=="出国/考研"){
            $sql=$sql."'study'";
        }
        $sql=$sql.")";
//        return $sql;
//        $this->output->set_content_type('application/json')->set_output(json_encode($sql));
        $this->insertData($sql);

    }

    private function grabImage($url,$filename="") {
        if($url==""):return false;endif;

        if($filename=="") {
            $ext=strrchr($url,".");
            if($ext!=".gif" && $ext!=".jpg"):return false;endif;
            $filename=date("dMYHis").$ext;
        }

        ob_start();
        readfile($url);
        $img = ob_get_contents();
        ob_end_clean();
        $size = strlen($img);

        $fp2=@fopen($filename, "a");
        fwrite($fp2,$img);
        fclose($fp2);

        return $filename;
    }


    private function insertData($sql){

        $this->load->database();
        try{
            $query = $this->db->query($sql);
        }catch (Exception $e){
//            $result=array("status"=>0,"title"=>$titles[$i]);
//            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }
}