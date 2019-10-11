
$(function(){
    if($('.searchinput').val() == ''){
        $('.container-search').removeClass('active');
        $('.container-search i.fa-search').css('color','#000');
      }else{
    $('.container-search').addClass('active');
    $('.container-search i.fa-search').css('color','#fff');
      }
    
    $('#name').keyup(function(){
        var username = $(this).val();
        console.log(username);
        $.ajax({
            url:"check.php",
            method:"POST",
            data:{user_name:username},
            dataType:"html",
            success:function(rt){
                $('#chk-user').html(rt);
            }
            

        });
    });
    //to show the password
    $('.moveeye').click(function(){
        if($(this).hasClass('fa-eye-slash')){
            $(this).removeClass('fa-eye-slash').addClass('fa-eye');
            $(this).siblings('input[type="password"]').attr('type','text');

        }
        else if($(this).hasClass('fa-eye')){
            $(this).removeClass('fa-eye').addClass('fa-eye-slash');
            $(this).siblings('input[type="text"]').attr('type','password');

        }

        }
    );
    //to check password is match
    $('#repassword').blur(function(){
        if($(this).val() !== ''){
            if($(this).val()!== $('#password').val()){
                $(this).css('border','2px solid rgb(226, 20, 20)');
                $('input[type="submit"]').attr('disabled','disabled ');
            }else{
                $(this).css('border','1px solid #ccc');
            }
        }
    });

    //post textarea 
    $('.postInProfile .post textarea').focus(function(){
        $('.postInProfile .post span').animate({
            color: "#E91E63",
            top:'30px',
           fontSize:'14px',
            
        },400);
        $(this).css('border-bottom-color','#E91E63');
    });
   
    $('.postInProfile .post textarea').on('blur',function(){
      if($(this).val()==''){
        $('.postInProfile .post span').animate({
            color: "#333",
            top:'61px',
           fontSize:'20px',
            
        },400);
        $(this).css('border-bottom-color','#333');
    }
    });
    //move tabe in post
    $('.formprof li').click(function(){
        $('div.'+$(this).data("u")).css('display','block').siblings('div').hide();
        $(this).addClass('active').siblings('li').removeClass('active');
    });

    //view the image preview file upload 
  
        // Multiple images preview in browser
        var imagesPreview = function(input, placeToInsertImagePreview) {
    
            if (input.files) {
                var filesAmount = input.files.length;
                
                for (i = 0; i < filesAmount; i++) {
                    
                    var reader = new FileReader();
                    reader.onload = function(event) {
                       
                        $('<img>').addClass("imgpost-display").attr('src', event.target.result).css('float','left').appendTo(placeToInsertImagePreview);
                    }
    
                    reader.readAsDataURL(input.files[i]);

                }
            }
    
        };
    
        
        $('#post_pic').on('change', function() {
            imagesPreview(this, 'div.gallery');
        });
    
        function removeLine(obj)
            {
            $('#post_pic').val('');
            var jqObj = $(obj);
            var container = jqObj.closest('div');
            var index = container.attr("id").split('_')[1];
            container.remove(); 

            delete finalFiles[index];
            //console.log(finalFiles);
            };

    //ace editor options
    

if(document.getElementById('editor')){ 
    ace.require("ace/ext/language_tools");
    var editor = ace.edit("editor");
    editor.setOptions({
    useWrapMode: true,   // wrap text to view
    indentedSoftWrap: false, 
    behavioursEnabled: false, // disable autopairing of brackets and tags
    showLineNumbers: false, // hide the gutter
    theme: "ace/theme/tomorrow"
    });    
editor.session.setUseWrapMode(true);
editor.setOptions({
    maxLines: 13,
    enableBasicAutocompletion: true,
    enableSnippets: true,
    enableLiveAutocompletion: true,
    fontSize: "10pt",
    autoScrollEditorIntoView: true
    
});

    editor.setTheme("tomorrow");
    $('#ace-mode').on('change',function(){
        editor.getSession().setMode("ace/mode/"+$(this).val().toLowerCase());
    });
}

    var edit = ace.edit("editor2");
    edit.setOptions({
        useWrapMode: true,   // wrap text to view
        indentedSoftWrap: false, 
        behavioursEnabled: false, // disable autopairing of brackets and tags
        showLineNumbers: false, // hide the gutter
        theme: "ace/theme/tomorrow"
        });
        edit.session.setUseWrapMode(true);
        edit.setOptions({
            maxLines: 13,
            enableBasicAutocompletion: true,
            enableSnippets: true,
            enableLiveAutocompletion: true,
            fontSize: "10pt",
            autoScrollEditorIntoView: true,
            readOnly: true,
            highlightActiveLine: false,
            highlightGutterLine: false
            
        });
        edit.setShowPrintMargin(false);
            edit.setTheme("tomorrow");
            $('#ace-mode').on('change',function(){
                editor.getSession().setMode("ace/mode/"+$(this).val().toLowerCase());
            });
               
            var edittest = ace.edit("editor3");
            edittest.setOptions({
                useWrapMode: true,   // wrap text to view
                indentedSoftWrap: false, 
                behavioursEnabled: false, // disable autopairing of brackets and tags
                showLineNumbers: false, // hide the gutter
                theme: "ace/theme/tomorrow"
                });
                edittest.session.setUseWrapMode(true);
                edittest.setOptions({
                    maxLines: 13,
                    enableBasicAutocompletion: true,
                    enableSnippets: true,
                    enableLiveAutocompletion: true,
                    fontSize: "10pt",
                    autoScrollEditorIntoView: true,
                    highlightActiveLine: false,
                    highlightGutterLine: false
                    
                });
                edittest.setShowPrintMargin(false);
                edittest.setTheme("tomorrow");     
    $('#filepdfupload').on('change',function(event){
        //var fileName = $(this).files[0].name;
        var name =$(this).val();
        var extention=name.slice((name.lastIndexOf('.') + 1));
        
      
        
    });
      
    
    var ajax = new XMLHttpRequest();
    var data = new FormData();
    $('body').on("change",'.filepdf',function(){
        var fileUploadInput = document.getElementById('filepdfupload');
        var labelfileUploadInput = document.getElementById('filepdfuploadd');
        var fileName=$(this).val();
        extention = fileName.slice((fileName.lastIndexOf('.') + 1)); 
        var file = $('.filepdf')[0].files[0];
        if($('.filepdf')[0].files.length>1){
            alert('Please choose the one PDF');
        }else{
           if(extention != 'pdf'){
               alert('please chosse the PDF file');
           }else{
               var nameFile = Math.random()+'_'+file.name; 
        data.append("resim",file)
        ajax.open('POST','file_upload_parser.php?name='+nameFile);
        //<input type="submit" class="btn btn-info" id="uploadShowProgress"  value="upload file" >
        var child = document.createElement('input');
        child.setAttribute('type','submit');
        child.setAttribute('class','btn btn-info');
        child.setAttribute('id','uploadShowProgress');
        child.setAttribute('value','post');
        var iconPdf = document.createElement("i");
        iconPdf.setAttribute('class', 'fa fa-file-pdf-o');
        iconPdf.style.color = "#d80c0c";
        iconPdf.style.fontSize ="50px";
        var textNamePdf = document.createElement('p');
        textNamePdf.setAttribute('class','name-pdf');
        textNamePdf.setAttribute('data-name',nameFile);
        var t= document.createTextNode(file.name);
        textNamePdf.appendChild(t);
        textNamePdf.style.fontSize = '15px';
        parent = document.getElementsByClassName('file')[0];
        
        var progress = $('.progress-bar');
        progress.css('visibility','visible');
        ajax.upload.onprogress = function(e){

            progress.css('width',Math.floor(((e.loaded / e.total) * 100))+"%");
            $('.prcent').html(Math.floor(((e.loaded / e.total) * 100))+"%");
            if(Math.floor(((e.loaded / e.total) * 100))==100){
                
                progress.css('visibility','hidden');
                parent.append(child);
                parent.append(iconPdf);
                parent.append(textNamePdf);
                fileUploadInput.remove();
                labelfileUploadInput.remove();
            }
        }
       ajax.send(data);
    }//close the else type
    }//close the else
    }
    
    );
   
    $('body').on('click','.next',function(){
        var count = $(this).parent().children('img').length;
        
        console.log(count);
        console.log($('img.active').data('fin'));
        if($(this).parent().children('img.active').data('fin')== count-1){
            $(this).parent().children('img.active').removeClass('active');
            $(this).parent().children('img').first().addClass('active');
        }else{
            $(this).parent().children('img.active').removeClass('active').next('img').addClass('active');
        }
    });
    $('body').on('click','.prev',function(){
        var count = $(this).parent().children('img').length;
        
        console.log(count);
        console.log($('img.active').data('fin'));
        if($(this).parent().children('img.active').data('fin')== 0){
            $(this).parent().children('img.active').removeClass('active');
            $(this).parent().children('img').last().addClass('active');
        }else{
            $(this).parent().children('img.active').removeClass('active').prev('img').addClass('active');
        }
    })
    $('body').on('DOMNodeInserted', '#code', function () {
        var editor = ace.edit("code");
        editor.setOptions({
        useWrapMode: true,   // wrap text to view
        indentedSoftWrap: false, 
        behavioursEnabled: false, // disable autopairing of brackets and tags
        showLineNumbers: false, // hide the gutter
        theme: "ace/theme/tomorrow"
        });
  });
 
  $('*').one('mouseenter mouseleave',function(){
    $('pre code').each(function(i, block) {
        hljs.highlightBlock(block);
      });
        
  })
  $('.show-check-div').click(function(){
    $('.box-show').toggle(200);
    
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
$('body').on('click','pre span.glyphicon-fullscreen',function(){
  var codepost = $(this).prev().data('par');
   var  xml = new XMLHttpRequest();
   var ajax = new XMLHttpRequest();
    var idPost = $(this).parent().siblings('.post-body').data('id');
    var langCode = $(this).siblings('code').attr('class').split(' ')[0];
    ajax.onreadystatechange = function(){
        if(ajax.readyState == 4 && ajax.status == 200){
            $('.ul-list-programming').html(ajax.responseText);
        }
    }
    xml.onreadystatechange = function(){
        if(xml.readyState == 4 && xml.status == 200){
            edit.setValue(xml.responseText, 1);
            edit.getSession().setMode("ace/mode/"+langCode.toLowerCase());
            $('.overlay-editor').show();
            $('.overlay-editor').attr('data-parent',codepost);
        }
    }
    xml.open('POST','codeEditor.php?postid='+idPost+'')
    ajax.open('POST','onFullScreenCode.php?postcode='+codepost+'');
    xml.send();
    ajax.send();
})
$('.overlay-editor i.fa-close').click(function(){
    $('.overlay-editor').hide();
})
$('body').on('keydown','.editMesaage',function(e){
    var xml = new XMLHttpRequest();
    console.log();
    if(e.keyCode == 13){
        var val = $(this).val();
        $(this).val("");
        var postid = $(this).parent().parent().siblings('.post-body').data('id');
        e.preventDefault();
        xml.onreadystatechange = function(){
            if(xml.readyState == 4 && xml.status == 200){
                $('.comment-displayAjax').html(xml.responseText);
                
            }
        }
        console.log();
        xml.open('POST','show_comments.php?body='+val+'&status=1&postid='+postid+'');
        xml.send();
    }
})
$('body').on('click','.btn-show-comments',function(){
    var postid = $(this).siblings('.post-body').data('id');
    $(this).siblings('.comments').show();
    $(this).removeClass('btn-show-comments');
    $(this).addClass('btn-hide-comments');
    $(this).children('div').html("Hide Comments");
    var xml = new XMLHttpRequest();
    xml.onreadystatechange = function(){
        if(xml.readyState == 4 && xml.status == 200){
           $('.comment-displayAjax').html(xml.responseText);
        }
    }
    
    xml.open('POST','show_comments.php?postid='+postid+'');
    xml.send();
    
})
$('body').on('click','.btn-hide-comments',function(){
    
    $(this).siblings('.comments').hide();
    $(this).removeClass('btn-hide-comments');
    $(this).addClass('btn-show-comments');
    $(this).children('div').html("Show Comments");
    console.log();
})
$('body').on('click','.comment-list span',function(){
    $(this).parent().next().toggle();

})
$('body').on('keyup','.child-textarea',function(e){
    var parentComment = $(this).parent().parent().siblings('.comment-body').children('.comment-text').data('parent');
    var postid = $(this).parents('.comments').siblings('.post-body').data('id');
    xml = new XMLHttpRequest();
    if(e.keyCode == 13){
        
        var childVal = $(this).val();
        $(this).val("");
        e.preventDefault();
    xml.onreadystatechange = function(){
        
        $('.comment-displayAjax').html(xml.responseText);
    }
    }
    xml.open('POST','show_comments.php?prentId='+parentComment+'&childval='+childVal+'&status=2&postid='+postid+'');
    xml.send();
})

$('body').on('click','.btnAddFriend',function(){
    console.log("hi");
     xml = new XMLHttpRequest();
    var idprofile = $(this).data('id');
    var parnet = $(this).parent('.addFriend');
       xml.onreadystatechange = function(){
        if(xml.readyState == 4 && xml.status == 200){
            parnet.html(xml.responseText);
          }
    
    }
    xml.open('POST','friends-ajax.php?idProfile='+idprofile+'');
    xml.send();
})
$('.album-photos img').click(function(){
    console.log('hi');
})
$('.add-new-programmin').on('click',function(){
    $.ajax({
        url:"new-solution.php",
        type:"POST",
        success:function(data){
            $('.ul-list-programming').append(data);
            $('#editor3').show();
            edittest.setValue('', 1);
            $('#editor2').hide();
            
            
        }
    })
});
$('body').on('click','.btn-save-solution',function(){
    var parent = $(this).parents('.overlay-editor').data('parent');
    var xml = new XMLHttpRequest();
    var data = new FormData();
    data.append('form',edittest.getSession().getValue());
    data.append('parent',parent);
    xml.onreadystatechange = function(){
        if(xml.readyState == 4 && xml.status == 200){
                $('.ul-list-programming').html(xml.responseText);
                $('#editor2').show();
                edit.setValue(edittest.getSession().getValue(),1);
                $('#editor3').hide();
                
        }
    }
    xml.open('POST','save-solution.php?status=1');
    xml.send(data);
     
});
$('body').on('click','.menu-list-programmer .ul-list-programming li.list-prog',function(){
    
    var xml = new XMLHttpRequest();
    var data = new FormData();
    data.append('data',$(this).data('child'));
    data.append('parent',$(this).parents('.overlay-editor').data('parent'));
    xml.onreadystatechange = function(){
        if(xml.readyState == 4 && xml.status == 200){
            edit.setValue(xml.responseText);
        }
    }
    xml.open('POST','save-solution.php?status=2');
    xml.send(data);
});
$('body').on('click','.btn-edit-name',function(){
    $('.overlay-edit-name').show();
});
$('body').on('click','.btn-close-overlay',function(e){
    e.preventDefault();
    $('.overlay-edit-name').hide();

})
$('body').on('click','.btn-save-new-name',function(e){
    e.preventDefault();
        var newName = $('#input-new-name').val();
        var data = new FormData();
        data.append('Name',newName);
        var ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200){
                $('.infoprof h3 span').html(ajax.responseText);
                $('.overlay-edit-name').hide();
            }
        }
        ajax.open('POST','changeName.php');
        ajax.send(data);
});
$uploadCrop = $('#upload-demo').croppie({
    enableExif: true,
    viewport: {
        width: 200,
        height: 200
    },
    boundary: {
        width: 300,
        height: 300
    }
});

$('#upload').on('change', function () { 
	var reader = new FileReader();
    reader.onload = function (e) {
    	$uploadCrop.croppie('bind', {
    		url: e.target.result
    	}).then(function(){
    		console.log('jQuery bind complete');
    	});
    	
    }
    reader.readAsDataURL(this.files[0]);
});

$('.upload-result').on('click', function (ev) {
	$uploadCrop.croppie('result', {
		type: 'canvas',
		size: 'viewport'
	}).then(function (resp) {

		$.ajax({
			url: "ajaxpro.php",
			type: "POST",
			data: {"image":resp},
			success: function (data) {
				
				$(".profile-img").attr('src',resp);
			}
        });
        $('.img-change-overlay').hide();
	});
});
$('body').on('click','.btn-edit-post',function(){
    var value = $(this).parents('.info-img').siblings('.post-body').find('p').text();
    var idpost = $(this).parents('.info-img').siblings('.post-body').data('id');

    $('textarea.change-text').text(value);
     $('.text-change').attr('data-id',idpost);
    $('.overlay-change-post').show();
});
$('body').on('click','.overlay-change-post i.fa-close',function(){
    $('.overlay-change-post').hide();
})
$('body').on('click','.btn-save-new-val',function(){
    var val = $(this).prev().val();
    var idpost = $(this).parents('.text-change').data('id');
    var xml = new XMLHttpRequest();
    var data = new FormData();
    data.append('id',idpost);
    data.append('val',val);
    xml.onreadystatechange = function(){
        if(xml.readyState == 4 && xml.status == 200){
            $('.post-body[data-id=' + idpost +']').find('p').html(xml.responseText);
            $('.overlay-change-post').hide();
        }
    }
    xml.open('POST','changePost.php');
    xml.send(data);
});
$('body').on('click','.btn-change-pic',function(){
    $('.img-change-overlay').show();
});
$('.img-change-overlay .fa-close').click(function(){
    $('.img-change-overlay').hide();
})
$('.send-report').on('click',function(){
    idprofile = $(this).data('idprofile');
    textmessage = $('.report-text').val();
    xml = new XMLHttpRequest();
    xml.onreadystatechange = function(){
        if(xml.readyState == 4 && xml.status == 200){
            console.log(xml.responseText)
        }
    }
    xml.open('POST','userNewReport.php?idprofile='+idprofile+'&mess='+textmessage+'');
    xml.send();
})
$('.overlay-report .fa-close').on('click',function(){
    $('.overlay-report').hide();
})
$('html').on('click','.reportUser',function(e){
    e.preventDefault();
    $('.overlay-report').show();
})
});
