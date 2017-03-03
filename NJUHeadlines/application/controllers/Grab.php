<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: wzh
 * Date: 28/11/2016
 * Time: 7:08 PM
 */
class Grab extends CI_Controller
{


    public function grabData(){
        $url = "http://www.tmsf.com/index.jsp";
        $contents = file_get_contents($url);
        preg_match_all('/<td.*?td>/',$contents,$source);
        $head="<table><tr>".$source[0][0].$source[0][1].$source[0][2].$source[0][3]."</tr>";
        $row1 = "<tr>".$source[0][4].$source[0][5].$source[0][6].$source[0][7]."</tr>";
        $row2 = "<tr>".$source[0][8].$source[0][9].$source[0][10].$source[0][11]."</tr>";
        $row3 = "<tr>".$source[0][12].$source[0][13].$source[0][14].$source[0][15]."</tr>";
        $row4 = "<tr>".$source[0][16].$source[0][17].$source[0][18].$source[0][19]."</tr>";
        $row5 = "<tr>".$source[0][20].$source[0][21].$source[0][22].$source[0][23]."</tr>";
        $row6 = "<tr>".$source[0][24].$source[0][25].$source[0][26].$source[0][27]."</tr>";
        $row7 = "<tr>".$source[0][28].$source[0][29].$source[0][30].$source[0][31]."</tr>";
        echo "住宅"."<br>".$head.$row1.$row2.$row3.$row4.$row5.$row6.$row7."</table>";
        $head="<table><tr>".$source[0][32].$source[0][33].$source[0][34]."</tr>";
        $row1 = "<tr>".$source[0][35].$source[0][36].$source[0][37]."</tr>";
        $row2 = "<tr>".$source[0][38].$source[0][39].$source[0][40]."</tr>";
        $row3 = "<tr>".$source[0][41].$source[0][42].$source[0][43]."</tr>";
        $row4 = "<tr>".$source[0][44].$source[0][45].$source[0][46]."</tr>";
        $row5 = "<tr>".$source[0][47].$source[0][48].$source[0][49]."</tr>";
        $row6 = "<tr>".$source[0][50].$source[0][51].$source[0][52]."</tr>";
        $row7 = "<tr>".$source[0][53].$source[0][54].$source[0][55]."</tr>";
        echo "非住宅"."<br>".$head.$row1.$row2.$row3.$row4.$row5.$row6.$row7."</table>";

//        foreach ($source as $i){
//            echo $i;
//        }$i

//        preg_match('/msg_title = ".*?"/',$contents,$title);
//        preg_match('/msg_desc = ".*?"/',$contents,$profile);
//        preg_match('/msg_cdn_url = ".*?"/',$contents,$imageLink);
//
//        $my_source=$source[0];
//        $my_title=$title[0];
//        $my_profile=$profile[0];
//        $my_imagelink=$imageLink[0];
//
//        $my_source=substr($my_source,12,strlen($my_source)-13);
//        $my_source=str_replace('&nbsp;','',$my_source);
//
//        $my_title=substr($my_title,13,strlen($my_title)-14);
//        $my_title=str_replace('&nbsp;','|',$my_title);
//        $my_title=str_replace('x26nbsp;','|',$my_title);
//        $my_title=str_replace('x26quot;','',$my_title);
//        $my_title=str_replace('<br>',',',$my_title);
//
//        $my_profile=substr($my_profile,12,strlen($my_profile)-13);
//        $my_profile=str_replace('&nbsp;','|',$my_profile);
//        $my_profile=str_replace('x26nbsp;','|',$my_profile);
//        $my_profile=str_replace('<br>',',',$my_profile);
//
//        $my_imagelink=substr($my_imagelink,15,strlen($my_imagelink)-16);
//        $my_imagelink=$this::BASE_URL.$this->grabImage($my_imagelink,"images/".uniqid().".png");
//
//        $sql = "insert into tb_wechat ";
//        $sql=$sql."values (NULL,'$my_title','$my_profile','$my_imagelink','$url','$my_source',now(),";
//        if($type=="推荐"){
//            $sql=$sql."'rec'";
//        }else if ($type=="团学"){
//            $sql=$sql."'school'";
//        }else if($type=="院系"){
//            $sql=$sql."'department'";
//        }else if($type=="出国/考研"){
//            $sql=$sql."'study'";
//        }
//        $sql=$sql.")";
////        return $sql;
////        $this->output->set_content_type('application/json')->set_output(json_encode($sql));
//        $this->insertData($sql);

    }
}