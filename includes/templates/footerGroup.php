<script src="<?php echo $js; ?>jquery-1.12.1.min.js"></script>
<script src="<?php echo $js; ?>jquery-ui.min.js"></script>
<script src="https://js.pusher.com/4.1/pusher.min.js"></script>
<script src="<?php echo $js; ?>jquery.form.min.js"></script>
<script src="<?php echo $js; ?>bootstrap.min.js"></script>
<script src="<?php echo $js; ?>jquery.selectBoxIt.min.js"></script>
<script src="<?php echo $js; ?>jquery.nicescroll.min.js"></script>
<script src="<?php echo $js; ?>chat.js"></script>
<script src="<?php echo $js; ?>highlight.pack.js"></script>
<script src="<?php echo $js; ?>postGroupUpload.js"></script>
<script src="<?php echo $js; ?>masonry.pkgd.min.js"></script>
<script src="<?php echo $js; ?>pusher.me.js"></script>
<script src="<?php echo $lib; ?>src-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo $lib; ?>src-noconflict/ext-language_tools.js"></script>
<script src="<?php echo $js; ?>forall.js"></script>
<script src="<?php echo $js; ?>endGroup.js"></script>
<script>
    $('body').on('click','.container-not',function(){
            xml = new XMLHttpRequest();
            xml.onreadystatechange = function(){
                if(xml.readyState == 4 && xml.status == 200){
                    $('.notification-overlay').fadeToggle();
                }
            }
            xml.open('POST','display_notification.php');
            xml.send();

        })
        $('.show-check-div').click(function(){
      $('.box-show').toggle(200);
    })
    </script>
</body>
</html>