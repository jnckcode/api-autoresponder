<?php
$post=file_get_contents("php://input");
$json=json_decode($post,JSON_PRETTY_PRINT);
preg_match('/"message":"([^"]+)"/msu',$post,$match);
$url=stripslashes($match[1]);
$link=urlencode($url);
$api="https://apis-youtube.herokuapp.com/video_info.php?url=$link";

//Curl
$curl=curl_init();
curl_setopt($curl,CURLOPT_URL,$api);
curl_setopt($curl,CURLOPT_POST,true);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($curl,CURLOPT_USERAGENT,'Mozilla/5.0 (iPhone; U; CPU iPhone OS 3_0 like Mac OS X; en-us) AppleWebKit/528.18 (KHTML, like Gecko) Version/4.0 Mobile/7A341 Safari/528.16');
curl_setopt($curl,CURLOPT_REFERER,"https://apis-youtube.herokuapp.com/");
curl_setopt($curl,CURLOPT_FOLLOWLOCATION,true);
$exe=curl_exec($curl);

//ObjectParse
$json=json_decode($exe,JSON_PRETTY_PRINT);

//Video
$mp4=print_r($json[0]['url']);
//Music
$mp3=print_r($json[16]['url']);

//SendUrl To chat
if(isset($post)){
$arr = [
   "replies" => [
   	     [
            "message" => "Youtube_DL {Created By JNCKCode}" 
         ],
         [
            "message" => "Video mp4 360p => $mp4" 
         ], 
         [
               "message" => "Music m4a 143kbps => $mp3" 
            ] 
      ] 
];
$json=json_encode($arr);
}
echo $json;

?>