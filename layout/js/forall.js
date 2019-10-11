$(function(){
    $('.newGroup').on('click',function(e){
        e.preventDefault();
        $('.new-group').show();
        $('.imag-group').val('');
        $('.group-name-one').val('');
        $('.des-group').val('');
        $('.error-cont-dis').html('');
    })

    $('.close-btn-ngroup').on('click',function(){
        $('.new-group').hide();
    })
  
    $('.btn-new-group').on('click',function(){
        console.log("hi");
        // if($('.group-name').val() == '' || $('.des-group').val() == '' || $('.imag-group').val()==''){
        //     alert('some input empty')
        // }else{
            data = new FormData();
            console.log($('.group-name-one').html());
           data.append('img',$('.imag-group')[0].files[0]);
           data.append('name',$('.group-name-one').val());
           data.append('des',$('.des-group').val());
           xml = new XMLHttpRequest();
           xml.onreadystatechange = function(){
            if(xml.readyState == 4 && xml.status == 200){
                console.log(xml.responseText);
              $('.error-cont-dis').html(xml.responseText);
              $('.new-group').hide();
            }
          }
          xml.open('POST','new-group.php');
          xml.send(data);
        
    })


    $('.searchinput').on('keyup',function(){
        if($(this).val() == ''){
          $('.container-search').removeClass('active');
          $('.container-search i.fa-search').css('color','#000');
        }else{
      $('.container-search').addClass('active');
      $('.container-search i.fa-search').css('color','#fff');
        }
      
      $('.box-show').hide();
      var query = $(this).val();
      var inputId =$('.box-show').children('input[checked="checked"]').attr('id');
      if(inputId == 'box-1'){
          status = 1;
      }else if(inputId == 'box-2'){
          status = 2;
      }else if(inputId == 'box-5'){
          status = 5;
      }else{
          status='none';
      }
      
      console.log(status);
      if(query != ''){
          $.ajax({
              url:"searchAjax.php",
              method:"POST",
              data:{query:query,status:status},
              success:function(data){
                  $('.search-AutoComplete').show();
                  $('.search-AutoComplete').html(data);
  
              }
              })
      }else{
          $('.search-AutoComplete').hide();
      }
     
    })

    $('body').on('click','.search-AutoComplete li',function(){
          $('.searchinput').val($(this).children('p').text())
          $('.search-AutoComplete').hide();
    })
     $('.box-show input[type="checkbox"]').on('click',function(){
         $(this).attr('checked','checked');
        $(this).siblings('input').removeAttr('checked');
    })

    $('.add-friendSearch').on('click',function(){
        xml = new XMLHttpRequest();
        id = $(this).data('id');
        $(this).removeClass('btn-default');
        $(this).removeClass('add-friendSearch');
        $(this).addClass('btn-success remove-friendSearch');
        $(this).text('Friend');
        xml.onreadystatechange = function(){
            if(xml.readyState == 4 && xml.status == 200){
               
               
               
            }
        }
        xml.open('POST','AddFriendJoinGroup.php?status=1&id='+id+'');
        xml.send();
    })
    $('.remove-friendSearch').on('click',function(){

        xml = new XMLHttpRequest();
        id = $(this).data('id');
        $(this).removeClass('btn-success');
        $(this).removeClass('remove-friendSearch');
        $(this).addClass('btn-default add-friendSearch');
        $(this).text('+ add Friend');
        xml.onreadystatechange = function(){
            if(xml.readyState == 4 && xml.status == 200){
               
               console.log(xml.responseText);
               
            }
        }
        xml.open('POST','AddFriendJoinGroup.php?status=2&id='+id+'');
        xml.send();
    })
    $('.private-chat').on('click',function(){
        $(this).css('border-bottom','3px solid #fff');
        $('.group-chat').css('border','none');
        $('.group-chat-content').hide();
        $('.friend-chat').show();
        $('.chat-user').css('background','#03A9F5');
    })
    $('.group-chat').on('click',function(){
        $(this).css('border-bottom','3px solid #fff');
        $('.private-chat').css('border','none');
        $('.group-chat-content').show();
        $('.friend-chat').hide();
        $('.chat-user').css('background','#87f387')
    })
    $('.group-name').on('click',function(){
        var id = $(this).data('frid');
        console.log(id)
        $(this).addClass('active').siblings().removeClass('active');
        xml = new XMLHttpRequest();
        xml.onreadystatechange = function(){
            if(xml.readyState == 4 && xml.status == 200){
                console.log(xml.responseText);
            }
        }
        xml.open('POST','new-chat-group.php?frid='+id+'');
        xml.send();
    });
    $('body').on('click','.btn-djoin-group',function(){
        grid = $(this).data('gid');
        $(this).removeClass('btn-success btn-djoin-group');
        $(this).addClass('btn-default btn-join-group');
        xml = new XMLHttpRequest();
        xml.onreadystatechange = function(){
            if(xml.readyState == 4 && xml.status ==200){
                console.log(xml.responseText)
            }
        }
        xml.open('POST','groupJointserach.php?status=1&gid='+grid+'');
        xml.send();
    })
    $('body').on('click','.btn-join-group',function(){
        grid = $(this).data('gid');
        $(this).removeClass('btn-default btn-join-group');
        $(this).addClass('btn-success btn-djoin-group');
        xml = new XMLHttpRequest();
        xml.onreadystatechange = function(){
            if(xml.readyState == 4 && xml.status ==200){
                console.log(xml.responseText)
            }
        }
        xml.open('POST','groupJointserach.php?status=2&gid='+grid+'');
        xml.send();
    })
    $('')
 
});