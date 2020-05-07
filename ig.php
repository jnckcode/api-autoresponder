<?php
//Input Data
$post=file_get_contents("php://input");
$json=json_decode($post,JSON_PRETTY_PRINT);
preg_match('/"message":"([^"]+)"/msu',$post,$match);
$url=stripslashes($match[1]);

//GetVideo URL
if(strpos($url,"/?utm_source=ig_web_copy_link")!== true){
$fixed=str_replace("/?utm_source=ig_web_copy_link","",$url);

$api=file_get_contents($fixed.'/?__a=1');
}
preg_match('/"video_url":"([^"]+)"/msu',$api,$vid);
$dl=$vid[1];

//GetImage URL
preg_match('/"display_url":"([^"]+)"/msu',$api,$img);
$pict=$img[1];

//SendUrl To chat
if(isset($post)){
$arr = [
   "replies" => [
   	     [
            "message" => "Instagram_DL {Created By JNCKCode}" 
         ],
         [
            "message" => "Gambar => $pict" 
         ], 
         [
               "message" => "Video => $dl" 
            ] 
      ] 
];
$json=json_encode($arr);
}
echo $json;
?>