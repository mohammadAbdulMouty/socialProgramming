$(function(){
        
    var end = 10;
    $('.friend-name').on('click',function(){
        end = 10;
        $(this).addClass('active').siblings().removeClass('active');
        frCatId = $(this).data('frid');
        form = new FormData();
        form.append('fid',frCatId);
        form.append('end',end);
        ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200){
            $('.message-content-append').attr('data-fid',frCatId);
            $('.message-content-append').html(ajax.responseText);
            $(".message-content-all").scrollTop($(".message-content-append").scrollHeight);
            $('.message-content-all').scrollTop(10000);
            }
        }
        ajax.open('POST','ajaxShowChatFriend.php?status=1');
        ajax.send(form);
    })
    $('.new-message .new-message-input').on('keyup',function(e){
        if(e.keyCode == 13){
            idto = $('.friend-name.active').data('frid');
           val = $(this).val();
           form = new FormData();
           form.append('val',val);
           form.append('idto',idto);
            xml = new XMLHttpRequest();
            xml.onreadystatechange  = function(){
                if(xml.readyState == 4 && xml.status == 200){
                   // $('.message-content-append').append(xml.responseText);
                   
                }
            }
            xml.open('POST','ajaxNewMesgFriend.php');
            xml.send(form);
        }
    })
    $('.message-content-all').on('scroll',function(e){
        if($(this).scrollTop() == 0){
            end = end+10;
            idto = $('.friend-name.active').data('frid');
            ajax = new XMLHttpRequest();
            form = new FormData();
            form.append('end',end);
            form.append('fid',idto);
            ajax.onreadystatechange = function(){
                if(ajax.readyState ==4 && ajax.status == 200){
                    console.log(ajax.responseText);
                    //$('.message-content-append').prepend(ajax.responseText);
                }
            }
            ajax.open('POST','ajaxShowChatFriend.php?status=2');
            ajax.send(form);
        }
    })
    $('.chat-display i.fa-close').on('click',function(){
        $('.chat-display').hide();
    })
    $('.container-chat').on('click',function(){
        console.log("hi");
        $('.chat-display').show();
    })
    

})