<?php
session_start();

include 'connect.php';
function RandomString($length) {
    $keys = array_merge(range(0,9), range('a', 'z'));

    $key = "";
    for($i=0; $i < $length; $i++) {
        $key .= $keys[mt_rand(0, count($keys) - 1)];
    }
    return $key;
}

$dir = __DIR__;
$rand = rand(0,999999999);
include 'includes/functions/function.php';
if(isset($_COOKIE['SPID'])){
$code = $_POST['code'];
$lang = $_COOKIE['lang'];
$input =$_POST['inputval'];
$desc = array(
    0 => array('pipe', 'r'), // 0 is STDIN for process
    1 => array('pipe', 'w'), // 1 is STDOUT for process
    2 => array("pipe", "w")		// stderr
);
$inputarray =explode(',',$input);
if($lang == 'PHP'){
    $handle = fopen("compilerFile/".$rand.".php",'w');
    fwrite($handle,$code);
     exec('"C:\xampp\php\php" compilerFile\\'.$rand.'.php 2>&1',$output,$return_value);
     if(!empty($output[0])){
        
        ?>
        <p>Result</p>
        <div class="result-ok">
            <p><?php echo $output[0];?></p>
        </div>
        <?php
    }else{
        ?>
        <p>Error</p>
         <div class="result-error">
            <p><?php echo $output[1];?></p>
        </div>
        <?php
    }
}
// // // // // // // // // // // // // // 
// // // // // // // // // // // // // // 
//*****************C#****************//
// // // // // // // // // // // // // // 
// // // // // // // // // // // // // // 
else if($lang == 'C#'){
     
    $handle = fopen("compilerFile/".$rand.".cs",'w');
    file_put_contents("compilerFile/".$rand.'.cs',$code);
    fclose($handle);
    //// command to invoke markup engine
    $cmd = "mcs compilerFile/".$rand.".cs";
    $p = proc_open($cmd, $desc, $pipes);
    stream_set_blocking($pipes[2], 0);
    if($err = stream_get_contents($pipes[2])){
        
        ?>
        <p>Error</p>
        <div class="result-error">
        <?php
                echo '<p>'.$err.'</p>';
             ?>
       </div>
       <?php
       proc_close($p);
       
    
    }else{
        $rel ='compilerFile/'.$rand.'.exe';
        $abs = realpath($rel);
        $p = proc_open('mono '.$abs, $desc, $pipes);
        foreach($inputarray as $input){
            fwrite($pipes[0], $input);
            fwrite($pipes[0],"\n");

        }
        fclose($pipes[0]);
        $html = stream_get_contents($pipes[1]);
        ?>
        <p>Result</p>
        <div class="result-ok">
            <p><?php echo $html;?></p>
        </div>
        <?php
        proc_close($p);
        
    }
   

}else if($lang == 'Python'){
    // $handle = fopen("compilerFile/".$rand.".py",'w');
    // fwrite($handle,$code);
   exec('"C:\Users\Mohammad\AppData\Local\Programs\Python\Python36-32\python" compilerFile\\'.$rand.'.py 2>&1',$output,$return_value);
  if(!$return_value){
    ?>
        <p>Result</p>
        <div class="result-ok">
            <p><?php echo $output[0];?></p>
        </div>
    <?php
  }else if($return_value){
      ?>
         <p>Error</p>
         <div class="result-error">
            <p><?php echo $output[3] .' In'.end(explode(',',$output[0]));?></p>
        </div>
      <?php
  }
}else if($lang == 'Ruby'){
    $handle = fopen("compilerFile/".$rand.".rb",'w');
    fwrite($handle,$code);
    exec('"C:\Ruby24-x64\bin\ruby" compilerFile/'.$rand.'.rb 2>&1',$output,$return_value);
    if(!$return_value){
        ?>
         <p>Result</p>
        <div class="result-ok">
            <p><?php echo $output[0];?></p>
        </div>
        <?php
    }else{
        ?>
<p>Error</p>
         <div class="result-error">
            <p><?php echo $output[0]?></p>
        </div>

<?php

    }
    
}else if($lang == 'Go'){
    $handle = fopen("compilerFile/".$rand.".go",'w');
    fwrite($handle,$code);
    exec('"C:\Go\bin\go" run compilerFile\\'.$rand.'.go 2>&1',$output,$return_value);//go
    if(!$return_value){
        ?>
          <p>Result</p>
        <div class="result-ok">
            <p><?php echo $output[0];?></p>
        </div>
        <?php
    }else{
        ?>
       <p>Error</p>
         <div class="result-error">
            <p><?php echo $output[1]?></p>
        </div>
        <?php
    }
    
}else if($lang == 'Java'){
    $handle = fopen("compilerFile/MyClass.java",'a+');
    //$strClassPos = str_replace('MyClass',$rand,$code);
 
    fwrite($handle,$code);
    exec('"C:\Program Files\Java\jdk1.8.0_151\bin\javac"  compilerFile/MyClass.java 2>&1',$output,$return_value);//java
     exec('"C:\Program Files\Java\jdk1.8.0_151\bin\java" -cp compilerFile MyClass  2>&1',$output,$return_value);//java
    if($return_value == 0){
        ?>

        <p>Result</p>
        <div class="result-ok">
            <p><?php echo $output[0];?></p>
        </div>
        <?php
    }else{
        
        ?>
        <p>Error</p>
         <div class="result-error">
            <p><?php echo $output[0].$output[1]?></p>
        </div>

        <?php

    }
    fclose($handle);
    if(file_exists('compilerFile/MyClass.class')){
        unlink('compilerFile/MyClass.class');
    }
    
    unlink('compilerFile/MyClass.java');
}else if($lang == 'C'){

    $handle = fopen('compilerFile/'.$rand.'.c','w');
    fwrite($handle,$code);

      exec('C:/MinGW/bin/gcc -o compilerFile/'.$rand.' compilerFile//'.$rand.'.c 2>&1',$output,$return_value);//c
     $rel ='compilerFile/'.$rand.'.exe';
    $abs = realpath($rel);
     exec(''.$abs.' 2>&1',$output,$return_value);
    if(count($output)<2){
        ?>
        <p>Result</p>
        <div class="result-ok">
            <p><?php echo $output[0];?></p>
        </div>

        <?php
    }else{
        ?>
            <p>Error</p>
         <div class="result-error">
            <p><?php echo $output[0].$output[1]?></p>
        </div>

        <?php
    }

    
}
// // // // // // // // // // // // // // 
// // // // // // // // // // // // // // 
//*****************C++****************//
// // // // // // // // // // // // // // 
// // // // // // // // // // // // // // 
else if($lang == 'C++'){
    //to make the file
    $handle = fopen('compilerFile/'.$rand.'.cpp','w');
    fwrite($handle,$code);
    fclose($handle);
    //strat compile the file
    $cmd = "g++ -o compilerFile/".$rand." compilerFile/".$rand.".cpp";
    $p = proc_open($cmd, $desc, $pipes);
    stream_set_blocking($pipes[2], 0);
    
    if ($err = stream_get_contents($pipes[2]))
    {
        ?>
        <p>Error</p>
        <div class="result-error">
        <?php
                echo '<p>'.$err.'</p>';
             ?>
       </div>
       <?php
       proc_close($p);
       
    }else{
    
       $rel ='compilerFile/'.$rand.'.exe';
        $abs = realpath($rel);
        $p = proc_open($abs, $desc, $pipes);
        foreach($inputarray as $input){
            fwrite($pipes[0], $input);
            fwrite($pipes[0],"\n");

        }
        fclose($pipes[0]);
        $html = stream_get_contents($pipes[1]);
        ?>
        <p>Result</p>
            <div class="result-ok">
            <?php 
        
                echo '<p>'.$html.'</p>';
        
                ?>
            </div>


        <?php
            unlink('compilerFile/'.$rand.'.exe');
            }
            unlink("compilerFile/".$rand.".cpp");
    
}

else if($lang == 'SQL'){
    $handle = fopen('compilerFile/'.$rand.'.sql','w');
    fwrite($handle,$code);
    exec('"C:\sqllight\sqlite3" compilerFile\\'.$rand.'.sdb < compilerFile\\'.$rand.'.sql 2>&1',$output,$return_value);//sql
    if($return_value == 0){
        ?>
        <p>Result</p>
            <div class="result-ok">
             <?php 
             foreach($output as $out){
                echo '<p>'.$out.'</p>';
             }
                ?>
            </div>


        <?php
    }else{
        ?>
        <p>Error</p>
        <div class="result-error">
        <?php
        foreach($output as $out){
                echo '<p>'.$out.'</p>';
             }
             ?>
       </div>
       <?php
    }
    
}

else if($lang == 'MATLAB'){
    mkdir('compilerFile/'.$rand);
   $code =  str_replace('-dpng ','-dpng compilerFile/'.$rand.'/',$code);
    $handle = fopen('compilerFile/'.$rand.'/'.$rand.'.m','w');
    fwrite($handle,$code);
    echo exec('"C:\Octave\Octave-4.2.1\bin\octave" --qf --no-window-system compilerFile/'.$rand.'/'.$rand.'.m',$output,$return_value);
    if($return_value == 0){
        ?>
        <p>Result</p>
            <div class="result-ok">
            <?php 
            foreach($output as $out){
                echo '<p>'.$out.'</p>';
            }
        
            $path = 'compilerFile/'.$rand;
            $files = scandir($path);
            foreach($files as $file){
                $ext = pathinfo($file, PATHINFO_EXTENSION);
                if($ext == 'png'){
                    echo '<img src="compilerFile/'.$rand.'/'.$file.'" class="img-view-matlab" width="300" height="300">';
                }
            }
          

                ?>
            </div>


        <?php
    }
   
 
}else if($lang == 'Kotlin'){
        $handle = fopen('compilerFile\\'.$rand.'.kt','w');
        fwrite($handle,$code);
        fclose($handle);
      exec('"C:\kotlinc\bin\kotlinc"  compilerFile\\'.$rand.'.kt -include-runtime -d compilerFile\\'.$rand.'.jar 2>&1',$output,$return_value);//kotlin
      exec('"C:\Program Files\Java\jdk1.8.0_151\bin\java" -Xmx128M -Xms16M -jar compilerFile\\'.$rand.'.jar 2>&1',$output,$return_value);//kotlin
     if($return_value == 0){
        ?>
        <p>Result</p>
            <div class="result-ok">
             <?php 
             
                echo '<p>'.$output[0].'</p>';
        
                ?>
            </div>


        <?php
    }else{
        ?>
        <p>Error</p>
        <div class="result-error">
        <?php
     
                echo '<p>'.$output[0].'</p>';
             
             ?>
       </div>
       <?php
    }
 
    
}else if($lang == 'NodeJS'){
    $handle = fopen('compilerFile\\'.$rand.'.js','w');
        fwrite($handle,$code);
        fclose($handle);
         exec('"node"  compilerFile\\'.$rand.'.js  2>&1',$output,$return_value);//kotlin
         if($return_value == 0){
            ?>
            <p>Result</p>
                <div class="result-ok">
                 <?php 
                 
                    echo '<p>'.$output[0].'</p>';
            
                    ?>
                </div>
    
    
            <?php
        }else{
            ?>
            <p>Error</p>
            <div class="result-error">
            <?php
         
                    echo '<p>'.$output[0].'</p>';
                 
                 ?>
           </div>
           <?php
        }

}
    




}