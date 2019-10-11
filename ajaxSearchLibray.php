<?php

$val = file_get_contents('https://api.cdnjs.com/libraries?search='.$_POST['val'].'');

$cdn = json_decode($val,true);

foreach($cdn['results'] as $c){
    $extension = end(explode('.',$c['latest']));
    // 
    //     $copyCdn = "<link rel="stylesheet" href='.$c["latest"].></link>";
    // }else if($extension == 'js'){
    //     $copyCdn = '<script src='.$c["latest"].'></script>';
    // }

?>
<div class="cdn-element">
    <div class="content-name">
    <h3><?php echo $c['name'] ?></h3>
    <?php 
if($extension == 'css'){
echo '<span class="copy" data-clipboard-text="<link rel=\'stylesheet\' href=\''.$c["latest"].'\'></link>">copy'.'</span>';
}else if($extension == 'js'){
    echo '<span class="copy" data-clipboard-text="<script  src=\''.$c["latest"].'\'></script>">copy'.'</span>';
}
?>
    </div>
    
    <div class="content-cdn"><?php echo $c['latest'] ?></div>
    
</div><!--end div.cdn-element-->

<?php
}
?>