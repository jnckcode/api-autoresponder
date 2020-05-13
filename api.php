<?php
//Input Data
$post=file_get_contents("php://input");
$json=json_decode($post,JSON_PRETTY_PRINT);
preg_match('/"message":"([^"]+)"/msu',$post,$match);
$url=stripslashes($match[1]);

//ProsesData
if (strpos($url,"www.instagram.com")||strpos($url,"m.instagram.com") !== false){
	//DataInstagram
	$api=file_get_contents($url.'/?__a=1');

preg_match('/"video_url":"([^"]+)"/msu',$api,$vid);
$dl=$vid[1];

//GetImage URL
preg_match('/"display_url":"([^"]+)"/msu',$api,$img);
$pict=$img[1];

//SendUrl To chat
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
print_r($json);
} elseif (strpos($url,"www.facebook.com")||strpos($url,"m.facebook.com") !== false){
	//DataFacebook
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
}
}

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
print_r($json);
}else{
	echo "Link Salah !";
}
?>