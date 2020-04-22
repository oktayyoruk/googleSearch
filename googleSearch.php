<?php
   function googleSearch($text,$count){
      $url = "https://www.google.com.tr/search?num=".$count."&q=".str_replace(" ","+",$text);
      header('Content-Type: text/html; charset=utf-8');
      $ci = curl_init();
      curl_setopt($ci, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Safari/537.36");
      curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 60);
      curl_setopt($ci, CURLOPT_TIMEOUT, 60);
      curl_setopt($ci, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ci, CURLOPT_FOLLOWLOCATION, TRUE);
      curl_setopt($ci, CURLOPT_HTTPHEADER, array('Expect:'));
      curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ci, CURLOPT_HEADER, FALSE);
      curl_setopt($ci, CURLOPT_PROXYTYPE, 'HTTP');
      curl_setopt($ci, CURLOPT_URL, $url);
      $response = curl_exec($ci);
      curl_close ($ci);

      $explode = explode("</cite>", $response);
      $arr = array();
      foreach($explode as $data){
         $explode2 = explode('<a href="',$data);
         $explode3 = explode('"', $explode2[count($explode2)-1]);
         $data = $explode3[0];
         if(strstr($data, ".")){
            if(!strstr($data, "google.com")){
               if(!empty($data)){
                  array_push($arr, $data);
               }
            }
         }
      }
      $arr = array_values(array_unique($arr));
      echo json_encode($arr);
   }
   $text = "oktay yörük";
   $count = "100";
   googleSearch($text,$count);
?>