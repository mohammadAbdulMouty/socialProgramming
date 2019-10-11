
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php getTitle();  ?></title>
    <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo $css; ?>font-awesome.min.css" />
    <link rel="shortcut icon" href="logo.png">
    <link rel="stylesheet"
      href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/default.min.css">
    
    <link rel="stylesheet" href="<?php echo $css; ?>jquery-ui.min.css" />
    <link rel="stylesheet" href="<?php echo $css; ?>croppie.css" />
    <link rel="stylesheet" href="<?php echo $css; ?>jquery.selectBoxIt.css" />
    <link rel="stylesheet" href="<?php echo $css; ?>jquery.selectBoxIt.css" />
    <link rel="stylesheet" href="<?php echo $css; ?>prism.css" />
    <link rel="stylesheet" href="<?php echo $css; ?>font-mfizz.css" />
    <link rel="stylesheet" href="<?php echo $css; ?>github.css" />
    <link rel="stylesheet" href="<?php echo $css; ?>style.css" />
  

</head>
<?php
if(isset($postonload)){
    echo "<body class='postonload'>";
}
else{
    if(isset($bgColor)){
    echo "<body style='background-color:#fff;'>";
    }else if(isset($loginbg)){
        echo "<body class='loginbg postonload'>";
    }else{
        echo "<body>";
    }
}


?>
