<?php

function getTitle(){
    global $pageTitle;
    if(isset($pageTitle)){
        echo $pageTitle;
    }else{
        echo 'Default';
    }

}
function checkItem($select,$from,$value){
    global $con;
    $statment=$con->prepare("SELECT $select FROM $from WHERE $select=?");
    $statment->execute(array($value));
    $count=$statment->rowCount();
    return $count;
}


//to calc the date ago
function dateGo($time_ago){
    $time_ago =  strtotime($time_ago) ? strtotime($time_ago) : $time_ago;
    $time = time()-$time_ago;
    // echo date('l jS \of F Y h:i:s A');
    switch($time):
        // seconds
        case $time <= 60;
        return 'lessthan a minute ago';
        // minutes
        case $time >= 60 && $time < 3600;
        return (round($time/60) == 1) ? 'a minute' : round($time/60).' minutes ago';
        // hours
        case $time >= 3600 && $time < 86400;
        return (round($time/3600) == 1) ? 'a hour ago' : round($time/3600).' hours ago';
        // days
        case $time >= 86400 && $time < 604800;
        return (round($time/86400) == 1) ? 'a day ago' : round($time/86400).' days ago';
        // weeks
        case $time >= 604800 && $time < 2600640;
        return (round($time/604800) == 1) ? 'a week ago' : round($time/604800).' weeks ago';
        // months
        case $time >= 2600640 && $time < 31207680;
        return (round($time/2600640) == 1) ? 'a month ago' : round($time/2600640).' months ago';
        // years
        case $time >= 31207680;
        return (round($time/31207680) == 1) ? 'a year ago' : round($time/31207680).' years ago' ;
        
        endswitch;
    
}
function chmod_r($dir, $dirPermissions, $filePermissions) {
    $dp = opendir($dir);
     while($file = readdir($dp)) {
       if (($file == ".") || ($file == ".."))
          continue;

      $fullPath = $dir."/".$file;

       if(is_dir($fullPath)) {
          echo('DIR:' . $fullPath . "\n");
          chmod($fullPath, $dirPermissions);
          chmod_r($fullPath, $dirPermissions, $filePermissions);
       } else {
          echo('FILE:' . $fullPath . "\n");
          chmod($fullPath, $filePermissions);
       }

     }
   closedir($dp);
}
function zipFile($source, $destination, $flag = '')
{
    if (!extension_loaded('zip') || !file_exists($source)) {
        return false;
    }

    $zip = new ZipArchive();
    if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
        return false;
    }

    $source = str_replace('\\', '/', realpath($source));
    if($flag)
    {
        $flag = basename($source) . '/';
        //$zip->addEmptyDir(basename($source) . '/');
    }

    if (is_dir($source) === true)
    {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);
        foreach ($files as $file)
        {
        
            if($file == $source."\.." || $file == $source."\.") continue;
            
            var_dump($file.'<br>');
            $file = str_replace('\\', '/', realpath($file));

            if (is_dir($file) === true)
            {
                $zip->addEmptyDir(str_replace($source . '/', '', $flag.$file . '/'));
            }
            else if (is_file($file) === true)
            {
                $zip->addFromString(str_replace($source . '/', '', $flag.$file), file_get_contents($file));
            }
        }
    }
    else if (is_file($source) === true)
    {
        $zip->addFromString($flag.basename($source), file_get_contents($source));
    }

    return $zip->close();
}

function rrmdir($dir) {
    if (is_dir($dir)) {
      $objects = scandir($dir);
      foreach ($objects as $object) {
        if ($object != "." && $object != "..") {
          if (filetype($dir."/".$object) == "dir") 
             rrmdir($dir."/".$object); 
          else unlink   ($dir."/".$object);
        }
      }
      reset($objects);
      rmdir($dir);
    }
   }
   function CheckCaptcha($userResponse) {
    $fields_string = '';
    $fields = array(
        'secret' => '6LdeUUEUAAAAAKTI8GgPooYa0WD8jMXSAzy9lVhz',
        'response' => $userResponse
    );
    foreach($fields as $key=>$value)
    $fields_string .= $key . '=' . $value . '&';
    $fields_string = rtrim($fields_string, '&');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
    curl_setopt($ch, CURLOPT_POST, count($fields));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);
    $res = curl_exec($ch);
    curl_close($ch);
    return json_decode($res, true);
}
