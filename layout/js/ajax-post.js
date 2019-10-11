(function(){
    $('body').on('click','.btn-delete-post',function(){
        var ok = confirm('do you want delete the post');
        if(ok == true){
        var postid = $(this).parents('.read-post').children('.post-body').data('id');
        var xml = new XMLHttpRequest();
        var data = new FormData();
        data.append('postid',postid);
        xml.onreadystatechange = function(){
            if(xml.readyState == 4 && xml.status == 200){
                document.getElementsByClassName('timeline')[0].innerHTML = xml.responseText;
            }
        }
        xml.open('POST','display-post.php?status=4');
        xml.send(data);
        }
        
    })    
    document.getElementsByClassName('postonload')[0].onload = function(){
            var ajax = new XMLHttpRequest();
            
            
            ajax.onreadystatechange = function(){
                if(ajax.readyState == 4 && ajax.status == 200){
                  document.getElementsByClassName('timeline')[0].innerHTML = ajax.responseText; 
                }
            }
            ajax.open("POST","display-post.php", true);
            ajax.send();
        };
      
    document.getElementById("sendpost-pic").onclick = function(e){
        e.preventDefault();
        var postPic = document.getElementById("post_pic");
        var data = new FormData();
        for(var i= 0;i<postPic.files.length;i++){
        
        data.append('file[]',postPic.files[i]);
        
        
        }
        
       
        var username = "mohammad goood";
        var bodyPost = document.getElementById('post-pic-textarea').value;
        document.getElementById('post-pic-textarea').value = "";
        document.getElementById('post-pic-textarea').blur();
        document.getElementsByClassName('gallery')[0].innerHTML = '';
        var ajax = new XMLHttpRequest();
        
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200){
                document.getElementsByClassName('timeline')[0].innerHTML = ajax.responseText; 
            }
        }

        ajax.open("POST","display-post.php?status=1&body="+bodyPost+"", true);
        ajax.send(data);
        
  
    }
    
    document.getElementById('sendpostCode').onclick = function(e){
        e.preventDefault();
        var editor = ace.edit("editor");
        var selectval = document.getElementById("ace-mode").value;
        var data = new FormData();
        var myCode = editor.getSession().getValue();
        var postText = document.getElementById('textareaCode').value;
        data.append("code", myCode);
        data.append("postText", postText);
        data.append("selectval2", selectval);
        ace.require("ace/ext/language_tools");
      
        // data = 'code='+myCode+"&post="+postText;
        var ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function(){
            
            if(ajax.readyState == 4 && ajax.status == 200){
                
                
                document.getElementsByClassName('timeline')[0].innerHTML = ajax.responseText;
                
            }
        }

        ajax.open("POST","display-post.php?status=2",true);
        ajax.send(data);
    }
    $('html').on('click','#uploadShowProgress',function(){
        var ajax = new XMLHttpRequest();
        var desripeText = $('.filedescribe').val();
        var uploadName = $(this).siblings('p').data('name');
        $('.filedescribe').val("");
        
       $(this).siblings('.name-pdf').remove();
        $(this).siblings('i').remove();
        $(this).remove();
        var parent = $('form.uploadpdf');
        var inputfile = document.createElement('input');
        inputfile.setAttribute('type', 'file');
        inputfile.setAttribute('class','filepdf');
        inputfile.setAttribute('id','filepdfupload');
        inputfile.setAttribute('name','fileup');
        inputfile.style.display = 'none';
        inputfile.setAttribute('accept','.pdf');
        parent.append(inputfile);
        var labelupload = document.createElement('label');
        labelupload.setAttribute('for','filepdfupload');
        labelupload.setAttribute('id','filepdfuploadd');
        labelupload.setAttribute('class','btn btn-success');
        textnode = document.createTextNode("please Choose The File");
        labelupload.append(textnode);
        
        parent.append(labelupload);
        var data = new FormData();
        
        data.append('desc',desripeText);
        data.append('name',uploadName);
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200){
                document.getElementsByClassName('timeline')[0].innerHTML = ajax.responseText;
            }
        }
        ajax.open("POST","display-post.php?status=3",true);
        ajax.send(data);
})
    $('html').on('click','.btn-like',function(){
        var ajax = new XMLHttpRequest();
        
        var print = $(this).parent();
        var likeBtn = $(this);
        var dislikeBtn = $(this).next();
        var status;
        var post = $(this).parents().siblings('.post-body');
        var idPost = post.data('id');

        console.log(post);
    
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
        var idPost = post.data('id');
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
    
    

   
})();