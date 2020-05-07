<?php
$post=file_get_contents("php://input");
$json=json_decode($post,JSON_PRETTY_PRINT);
preg_match('/"message":"([^"]+)"/msu',$post,$match);
$url=stripslashes($match[1]);

//GetObject
$vid="https://fbdownloader.net/download/?url=$url";
$cx=curl_init();
curl_setopt($cx,CURLOPT_URL,$vid);
curl_setopt($cx,CURLOPT_RETURNTRANSFER,true);
curl_setopt($cx,CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($cx,CURLOPT_POST,true);
curl_setopt($cx,CURLOPT_REFERER,'https://fbdownloader.net/');
curl_setopt($cx,CURLOPT_FOLLOWLOCATION,true);
curl_setopt($cx,CURLOPT_VERBOSE,false);
$exec=curl_exec($cx);
curl_close($cx);

//Explain Object
$data=$exec;
//---Data Api Collected---
$regexp = "/<a\s[^>]*\/video([\"\']??)([^\\1 >]*?)\\1[^>]*>(.*)<\/a>/siU";
  if(preg_match_all("$regexp", $data, $matches, PREG_SET_ORDER)) {
    foreach($matches as $match) {
$link="https://video".$match[2];
$hehe=rtrim($link,'"');

//SendDATA
if(isset($post)){
$arr = [
   "replies" => [
   	     [
            "message" => "Facebook_DL {Created By JNCKCode}" 
         ],
         [
            "message" => "Video mp4 => $hehe" 
         ] 
      ] 
];
$json=json_encode($arr);
}
echo $json;
?>