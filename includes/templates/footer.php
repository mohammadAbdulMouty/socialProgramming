



<script src="<?php echo $js; ?>jquery-1.12.1.min.js"></script>
<script src="<?php echo $js; ?>jquery-ui.min.js"></script>
<script src="<?php echo $js; ?>jquery.form.min.js"></script>
<script src="<?php echo $js; ?>croppie.js"></script>
<script src="<?php echo $js; ?>bootstrap.min.js"></script>
<script src="https://js.pusher.com/4.1/pusher.min.js"></script>

<script src="<?php echo $js; ?>jquery.selectBoxIt.min.js"></script>

<script src="<?php echo $js; ?>jquery.nicescroll.min.js"></script>
<script src="<?php echo $js; ?>chat.js"></script>
<script src="<?php echo $js; ?>highlight.pack.js"></script>

<script src="<?php echo $lib; ?>src-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo $lib; ?>src-noconflict/ext-language_tools.js"></script>
<script src="<?php echo $js; ?>ajax-post.js"></script>
<script src="<?php echo $js; ?>pusher.me.js"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
<script src="<?php echo $js; ?>forall.js"></script>
<script src="<?php echo $js; ?>end.js"></script>
<script> 
</script>

<link rel="stylesheet" href="//cdn.jsdelivr.net/highlight.js/9.9.0/styles/default.min.css">
    <script src="//cdn.jsdelivr.net/highlight.js/9.9.0/highlight.min.js"></script>
    <script>
    $('body').on('click','.container-not',function(){
        xml = new XMLHttpRequest();
            xml.onreadystatechange = function(){
                if(xml.readyState == 4 && xml.status == 200){
                    $('.notification-overlay').fadeToggle();
                    $('.notification').html(xml.responseText);
                }
            }
            xml.open('POST','display_notification.php');
            xml.send();

        })
    
    </script>
</body>
</html>