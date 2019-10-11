$(function(){
    document.getElementsByClassName('postonload')[0].onload = function(){
        
        var ajax = new XMLHttpRequest();
        var idGroup = $('.post-group-timeline').data('gid');
        ajax.onreadystatechange = function(){
        if(ajax.readyState == 4 && ajax.status == 200){
            
            var el = jQuery(ajax.responseText);
            jQuery(".post-group-timeline").html(el).masonry( 'appended', el, true );
            
        }}
        ajax.open('POST','ajaxPostGroup.php?gid='+idGroup+'');
        ajax.send();
    }
    $('.send-post-pic-group').on('click',function(e){
        e.preventDefault();
        
        var xml = new XMLHttpRequest();
        var idgroup = $(this).parents('.new-post-group').data('gid');
        var data = new FormData();
        var bodyPost = $('.textarea-img-group').val();
        var postPic = document.getElementById('upload-photo');
        if(bodyPost =='' && postPic.files.length == 0){
            alert('Please Dont Send Empty Post');
        }else{
        data.append('post', bodyPost);
        data.append('idgroup', idgroup);
        
        for( i=0;i<postPic.files.length;i++){
            data.append('file[]', postPic.files[i]);
        }
        
        $('.textarea-img-group').val('');
        $('.post-img-group .show-img .gallery').html('');
        xml.onreadystatechange = function(){
            if(xml.readyState == 4 && xml.status == 200){
                console.log(xml.responseText);
                var el = jQuery(xml.responseText);
                jQuery(".post-group-timeline").html(el).masonry( 'prepended', el, true );
                $('.post-group-timeline').masonry( 'reloadItems' );
                $('.post-group-timeline').masonry( 'layout' );
                $('.alert-noPost').hide();
                $('.overlay-new-post-group').hide();
            }
        }
        xml.open('POST','ajaxPostGroup.php?status=1&gid='+idgroup+'');
        xml.send(data);
    }
    });
    $('.sendCodeGroup').on('click',function(){
        var ajax = new XMLHttpRequest();
        var idgroup = $(this).parents('.new-post-group').data('gid');
        var editor = ace.edit("editorGroup");
        var selectVal = document.getElementById('ace-mode').value;
        var textareaVal = $('.textarea-code-group').val();
        var codeVal = editor.getSession().getValue();
        var data = new FormData();
        data.append('idGroup',idgroup);
        data.append('selectVal',selectVal);
        data.append('textareaVal',textareaVal);
        data.append('codeVal',codeVal);
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200){
                
                var el = jQuery(ajax.responseText);
                jQuery(".post-group-timeline").html(el).masonry('appended', el, true );
                $('.post-group-timeline').masonry( 'reloadItems' );
                $('.post-group-timeline').masonry( 'layout' );
                $('.textarea-code-group').val('');
                editor.setValue('');
                $('.alert-noPost').hide();
                $('#ace-mode').prop('selectedIndex',0);
                $('.overlay-new-post-group').hide();
            }
        }
        ajax.open('POST','ajaxPostGroup.php?status=2&gid='+idgroup+'');
        ajax.send(data);
    })
   $('body').on('click','#uploadShowProgress',function(){
       var xml = new XMLHttpRequest();
       var data = new FormData();
      var fileName = $(this).siblings('.name-pdf').data('name');
      var idgroup = $(this).parents('.new-post-group').data('gid');
      
      var descripe = $('.post-file-textare').val();
      $(this).siblings('.name-pdf').remove();
      $(this).siblings('i').remove();
      $(this).remove();
      var parent = $('.post-file-group');
      var inputfile = document.createElement('input');
      inputfile.setAttribute('type', 'file');
      inputfile.setAttribute('class','filepdf');
      inputfile.setAttribute('id','filepdfupload');
      inputfile.setAttribute('name','fileup');
      inputfile.style.display = 'none';
      inputfile.setAttribute('accept','.pdf,.txt');
      parent.append(inputfile);
      var labelupload = document.createElement('label');
      labelupload.setAttribute('for','filepdfupload');
      labelupload.setAttribute('id','labelfile');
      labelupload.setAttribute('class','btn btn-success');
      textnode = document.createTextNode("please Choose The File");
      labelupload.append(textnode);
      parent.append(labelupload);
      data.append('fileName', fileName);
      data.append('idGroup', idgroup);
      data.append('descripe', descripe);
      xml.onreadystatechange = function(){
          if(xml.readyState == 4 && xml.status == 200){
            var el = jQuery(xml.responseText);
            jQuery(".post-group-timeline").html(el).masonry( 'appended', el, true );
            $('.post-group-timeline').masonry( 'reloadItems' );
            $('.post-group-timeline').masonry( 'layout' );
            $('.post-file-textare').val('');
            $('.alert-noPost').hide();
            $('.overlay-new-post-group').hide(); 
              
          }
      }
      xml.open('POST','ajaxPostGroup.php?status=3&gid='+idgroup+'');
      xml.send(data);
      
      
   })
   $('html').on('click','.btn-like',function(){
    var ajax = new XMLHttpRequest();
    
    var print = $(this).parent();
    var likeBtn = $(this);
    var dislikeBtn = $(this).next();
    var status;
    var post = $(this).parents().siblings('.panel-body').find('.post-body');
    var idPost = $(this).parents().siblings('.panel-body').find('.post-body').data('id');
    if(likeBtn.hasClass('like-active')){
        status = 'active';
    }else{
        status = 'notActive';
    }
    ajax.onreadystatechange = function(){
    if(ajax.readyState == 4 && ajax.status == 200){
             print.html(ajax.responseText); 
             if(status == 'active'){
                likeBtn.removeClass('like-active');
                dislikeBtn.removeClass('dislike-active');
            }
                if(status == 'notActive'){
                    likeBtn.addClass('like-active');
                   dislikeBtn.removeClass('dislike-active');
              }
        }
    }
    ajax.open('POST','like-ajax.php?status='+status+'&do=like&idpost='+idPost+'');
    ajax.send();
    });
    $('html').on('click','.btn-dislike',function(){
        var ajax = new XMLHttpRequest();
        var print = $(this).parent();
        var dislikBtn = $(this);
        var likeBtn = $(this).prev();
        var status;
        var post = $(this).parents().siblings('.post-body');
        var idPost = $(this).parents().siblings('.panel-body').find('.post-body').data('id');
         if(dislikBtn.hasClass('dislike-active')){
                 status = 'active';
            }else{
                status = 'notActive';
            }
            ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200){
                    print.html(ajax.responseText); 
                    if(status == 'active'){
                        dislikBtn.removeClass('dislike-active');
                        likeBtn.removeClass('like-active');
                    }
                        if(status == 'notActive'){
                            dislikBtn.addClass('dislike-active');
                        likeBtn.removeClass('like-active');
                    }
                }
            }
            ajax.open('POST','like-ajax.php?status='+status+'&do=dislike&idpost='+idPost+'');
            ajax.send();
    });   
   $('*').one('mouseenter mouseleave',function(){
    $('pre code').each(function(i, block) {
        hljs.highlightBlock(block);
        $('.post-group-timeline').masonry( 'reloadItems' );
        $('.post-group-timeline').masonry( 'layout' );
      });
        
  })
});