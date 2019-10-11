$(function(){
  if ($(".join-button").text() == "Following"){
    $(".join-button").animate({ width: '+=45px', left: '-=15px' }, 600, 'easeInOutBack', function () { 
      $(".join-button").css("color", "#fff");
      $(".join-button").text("Following");

      // Animate the background transition from white to green. Using JQuery Color
      $(".join-button").animate({
        backgroundColor: "#2EB82E",
        borderColor: "#2EB82E"
      }, 1000 );
    });
  }
  if ($(".join-button-sm").text() == "Following"){
    $(".join-button-sm").animate({ width: '+=45px', left: '-=15px' }, 600, 'easeInOutBack', function () { 
      $(".join-button-sm").css("color", "#fff");
      $(".join-button-sm").text("Following");

      // Animate the background transition from white to green. Using JQuery Color
      $(".join-button-sm").animate({
        backgroundColor: "#2EB82E",
        borderColor: "#2EB82E"
      }, 1000 );
    });
  }
      $('.post-group-timeline').masonry({
        // options
        itemSelector: '.post-group-item',
        columnWidth: 70
      });
      //declare plugin select box It
     
      $("select").selectBoxIt({
        autoWidth: false
    })
    //remove the active class in navbar
    $('.navbar-nav li').removeClass('active');
    //Start join Group button
    $(".join-button").click(function(){
      groupid = $(this).parents('.group-info').data('gid');
      console.log(groupid)
      console.log($(".join-button").text());
        if ($(".join-button").text() == "+ join"){
         
          
          ajax = new XMLHttpRequest();
          // *** State Change: To Following ***      
          // We want the button to squish (or shrink) by 10px as a reaction to the click and for it to last 100ms    
          ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200){
              console.log(ajax.responseText);
              $(".join-button").animate({ width: '-=10px' }, 100, 'easeInCubic', function () {});
              
              // then now we want the button to expand out to it's full state
              // The left translation is to keep the button centred with it's longer width
              $(".join-button").animate({ width: '+=45px', left: '-=15px' }, 600, 'easeInOutBack', function () { 
                $(".join-button").css("color", "#fff");
                $(".join-button").text("Following");
        
                // Animate the background transition from white to green. Using JQuery Color
                $(".join-button").animate({
                  backgroundColor: "#2EB82E",
                  borderColor: "#2EB82E"
                }, 1000 );
              });
              window.location.reload();
            }
          }
            ajax.open('POST','joinGroup.php?statuss=1&gid='+groupid+'');
            ajax.send();
          
        
        }else{
          xml = new XMLHttpRequest();
          xml.onreadystatechange = function(){
             if(xml.readyState == 4 && xml.status == 200){
               console.log(xml.responseText);
               $(".join-button").animate({ width: '-=25px', left: '+=15px' }, 600, 'easeInOutBack', function () { 
                $(".join-button").text("+ join");
                
                $(".join-button").css("color", "#3399FF");
                $(".join-button").css("background-color", "#ffffff");
                $(".join-button").css("border-color", "#3399FF");
                window.location.reload();
            });
             } 
          }
          xml.open('POST','joinGroup.php?statuss=2&gid='+groupid+'');
          xml.send();
        }
      });
      //End join Group button
      $(".join-button-sm").click(function(){
        groupid = $(this).parents('.group-info-sm').data('gid');
        console.log($(".join-button-sm").text());
          if ($(".join-button-sm").text() == "+ join"){
           
            
            ajax = new XMLHttpRequest();
            // *** State Change: To Following ***      
            // We want the button to squish (or shrink) by 10px as a reaction to the click and for it to last 100ms    
            ajax.onreadystatechange = function(){
              if(ajax.readyState == 4 && ajax.status == 200){
                console.log(ajax.responseText);
                $(".join-button-sm").animate({ width: '-=10px' }, 100, 'easeInCubic', function () {});
                
                // then now we want the button to expand out to it's full state
                // The left translation is to keep the button centred with it's longer width
                $(".join-button-sm").animate({ width: '+=45px', left: '-=15px' }, 600, 'easeInOutBack', function () { 
                  $(".join-button-sm").css("color", "#fff");
                  $(".join-button-sm").text("Following");
          
                  // Animate the background transition from white to green. Using JQuery Color
                  $(".join-button-sm").animate({
                    backgroundColor: "#2EB82E",
                    borderColor: "#2EB82E"
                  }, 1000 );
                });
                window.location.reload();
              }
            }
              ajax.open('POST','joinGroup.php?statuss=1&gid='+groupid+'');
              ajax.send();
            
          
          }else{
            xml = new XMLHttpRequest();
            xml.onreadystatechange = function(){
               if(xml.readyState == 4 && xml.status == 200){
               
                 console.log(xml.responseText);
                 $(".join-button-sm").animate({ width: '-=25px', left: '+=15px' }, 600, 'easeInOutBack', function () { 
                  $(".join-button-sm").text("+ join");
                  
                  $(".join-button-sm").css("color", "#3399FF");
                  $(".join-button-sm").css("background-color", "#ffffff");
                  $(".join-button-sm").css("border-color", "#3399FF");
                  window.location.reload();
              });
               } 
            }
            xml.open('POST','joinGroup.php?statuss=2&gid='+groupid+'');
            xml.send();
          }
        });
      //start display tab in new post group
        $('.overlay-new-post-group ul li a').click(function(){
            $('.'+$(this).data('nav')).css('display','block');
            $('.'+$(this).data('nav')).siblings().hide();
        });
      //End display tab in new post group
      //show overlay-new-post-group 
      $('.content div.btn-success').click(function(){
          $('.overlay-new-post-group').show();
      })


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
        
            
            $('#upload-photo').on('change', function() {
                $('.send-post-pic-group').removeAttr("disabled");
                imagesPreview(this, '.show-img .gallery');
            });

            //to close the new post group
            $('.overlay-new-post-group i.fa-close').click(function(){
              $('.overlay-new-post-group').hide();
            });
            //to declary the Ace Editor
            var edittest = ace.edit("editorGroup");
            edittest.setOptions({
                useWrapMode: true,   // wrap text to view
                indentedSoftWrap: false, 
                behavioursEnabled: false, // disable autopairing of brackets and tags
                showLineNumbers: false, // hide the gutter
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
                edittest.getSession().on('change', function() {
                  if(edittest.getValue() !=''){
                  $('.sendCodeGroup').removeAttr("disabled");
                  }else{
                    $('.sendCodeGroup').attr('disabled','disabled');
                  }
                });
              //chosse the programming language 
              $('#ace-mode').on('change',function(){
                var mod = $(this).val();
               if($(this).val() == 'c#'){
                var mod = 'csharp';
               }else if($(this).val()=='C' || $(this).val() == 'C++'){
                var mod = 'C_Cpp'
               }else{
                var mod = $(this).val();
               }
               
                edittest.getSession().setMode('ace/mode/'+mod.toLowerCase());
              });
              //Send file with progress bar
              var ajax = new XMLHttpRequest();
              var data = new FormData();
              $('body').on("change",'.filePDFANDTEXT',function(){
                
                
                  var fileUploadInput = document.getElementById('fileUpload');
                  var labelfileUploadInput = document.getElementById('labelfile');
                  var fileName=$(this).val();
                  extention = fileName.slice((fileName.lastIndexOf('.') + 1)); 
                  var file = $(this)[0].files[0];
                  if($(this)[0].files.length>1){
                       alert('Please choose the one File');
                  }else{
                  if(extention == 'pdf' || extention == 'txt'){   
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
                  
                  if(extention === 'pdf'){
                  iconPdf.setAttribute('class', 'fa fa-file-pdf-o');
                  iconPdf.style.color = "#d80c0c";
                  iconPdf.style.fontSize ="50px";
                  }
                  if(extention === 'txt'){
                    iconPdf.setAttribute('class', 'fa fa-file-text-o');
                    iconPdf.style.color = "#00f";
                    iconPdf.style.fontSize ="50px";
                    }
                  var textNamePdf = document.createElement('p');
                  textNamePdf.setAttribute('class','name-pdf');
                  textNamePdf.setAttribute('data-name',nameFile);
                  var t= document.createTextNode(file.name);
                  textNamePdf.appendChild(t);
                  textNamePdf.style.fontSize = '15px';
                  parent = document.getElementsByClassName('post-file-group')[0];
                  
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
                
                  
                    }else{
                      alert("Please Chosse the Text or PDF File");
                    }
                  }
              }//close the else
               
              
              );

            
              $('body').on("change",'.inputVideo',function(){
                
                  var ajax = new XMLHttpRequest();
                  var data = new FormData();
                  var fileUploadInput = document.getElementById('descripeVideo');
                  var labelfileUploadInput = document.getElementById('labelVideo');
                  var fileName=$(this).val();
                  extention = fileName.slice((fileName.lastIndexOf('.') + 1)); 
                  console.log(extention);
                  var file = $(this)[0].files[0];
                  console.log(file)
                  if($(this)[0].files.length>1){
                  alert('Please choose the one Video');
                  }else{
                    if(extention !='MP4'){
                        alert('Please choose The MP4 File');
                    }else{
                     var nameFile = Math.random()+'_'+file.name; 
                     data.append("video",file);
                     ajax.onreadystatechange = function(){
                       if(ajax.readyState == 4 && ajax.status == 200){
                         console.log(ajax.responseText);
                       }
                     }
                     ajax.open('POST','file_upload_parser.php?name='+nameFile);
                
                                          var child = document.createElement('input');
                                          child.setAttribute('type','submit');
                                          child.setAttribute('class','btn btn-info');
                                          child.setAttribute('id','uploadShowProgress');
                                          child.setAttribute('value','post');
                                          var iconPdf = document.createElement("i");
                                          console.log(extention);
                                          
                                          iconPdf.setAttribute('class', 'fa fa-file-video-o ');
                                          iconPdf.style.color = "#d80c0c";
                                          iconPdf.style.fontSize ="50px";
    
                                          var textNamePdf = document.createElement('p');
                                          textNamePdf.setAttribute('class','name-pdf');
                                          textNamePdf.setAttribute('data-name',nameFile);
                                          var t= document.createTextNode(file.name);
                                          textNamePdf.appendChild(t);
                                          textNamePdf.style.fontSize = '15px';
                                          parent = document.getElementsByClassName('post-video-group')[0];
                                          
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
                                    }
                    }
              //close the else
               
              
              );
             $('body').on('keyup','.textarea-img-group',function(){
               console.log("hi");
               if($('.textarea-img-group').val() != ''){
                if($('.gallary').html != ''){
                 $('.send-post-pic-group').removeAttr("disabled");
                }
               }else{
                $('.send-post-pic-group').attr('disabled','disabled');
               }
             });
             $('.textarea-code-group').on('keyup',function(){
              if($('.textarea-code-group').val() != ''){

                $('.sendCodeGroup').removeAttr("disabled");
              }else{
                $('.sendCodeGroup').attr('disabled','disabled');
              }
             
            });
            $('body').on('click','.next',function(){
              var count = $(this).parent().children('img').length;
              console.log($('img.active').data('fin'));
              if($(this).parent().children('img.active').data('fin')== count-1){
                  $(this).parent().children('img.active').removeClass('active');
                  $(this).parent().children('img').first().addClass('active');
              }else{
                  $(this).parent().children('img.active').removeClass('active').next('img').addClass('active');
              }
              $('.post-group-timeline').masonry( 'reloadItems' );
              $('.post-group-timeline').masonry( 'layout' );
          });
          $('body').on('click','.prev',function(){
              var count = $(this).parent().children('img').length;
              console.log($('img.active').data('fin'));
              if($(this).parent().children('img.active').data('fin')== 0){
                  $(this).parent().children('img.active').removeClass('active');
                  $(this).parent().children('img').last().addClass('active');
              }else{
                  $(this).parent().children('img.active').removeClass('active').prev('img').addClass('active');
              }
              $('.post-group-timeline').masonry( 'reloadItems' );
              $('.post-group-timeline').masonry( 'layout' );
          })

          $('body').on('click','.full-screen-code',function(){
            $('.edit-container').html('');
            $('.user-solution-img').html('');
            postid = $(this).parents('.panel-default').data('pid');
           
            postCodeID = $(this).parents('pre').data('par');
            
            var lang  = $(this).prev().attr('class').split(' ')[0];
            if(lang == 'C#'){
              lang = 'csharp'
            }else if(lang == 'Go'){
              lang = 'golang'
            }else if(lang == 'C' || lang == 'C++'){
              lang = 'C_Cpp';
            }
            if(lang == 'NodeJS'){
              lang = 'JavaScript';
            }
            
            if(lang == 'MATLAB'){
              $('.user-solution-img').html("<img src='layout/icons/"+lang.toLowerCase()+".png'> <h3>"+lang+"</h3>");
            }else if(lang == 'csharp'){
              $('.user-solution-img').html("<img src='layout/icons/csharp9.svg'> <h3>"+lang+"</h3>");
            }else if(lang == 'Kotlin'){
              $('.user-solution-img').html("<img src='layout/icons/file_type_kotlin.svg'> <h3>"+lang+"</h3>");
            }else if(lang == 'JavaScript'){
              $('.user-solution-img').html("<img src='layout/icons/file_type_node.svg'> <h3>NodeJS</h3>");
              
            }else if(lang == 'PHP'){
              $('.user-solution-img').html("<img src='layout/icons/file_type_php2.svg'> <h3>"+lang+"</h3>");
              
            }else if(lang == 'C_Cpp'){
              $('.user-solution-img').html("<img src='layout/icons/file_type_cpp2.svg'> <h3>"+lang+"</h3>");
              
            }
         
            var groupEditor = ace.edit("group-edtior-solution");
            
            $('#group-edtior-solution').show();
            $('#group-edtior-solution-2').hide();
            $('#group-edtior-solution-3').hide();
            data = new FormData();
            data.append('postid', postid);
            data.append('lang',lang);
            $('.overlay-editor-fullScreen').attr('data-cid',postCodeID);

  
            ajax = new XMLHttpRequest();
            ajax.onreadystatechange= function(){
              if(ajax.readyState == 4 && ajax.status == 200){
                groupEditor.setValue(ajax.responseText, 1);
                console.log(ajax.responseText)
              }
            }
            ajax.open('POST','solutionGroupAjax.php?satatus=2');
            ajax.send(data);
            xml = new XMLHttpRequest();
            xml.onreadystatechange = function(){
              if(xml.readyState == 4 && xml.status == 200){
                  $('.list-soluiton').html(xml.responseText);
              }
            }
            xml.open('POST','solutionGroupAjax.php?satatus=1');
            xml.send(data);
            xml2 = new XMLHttpRequest();
            xml2.onreadystatechange = function(){
              $(".sava-container").html(xml2.responseText);
            
            }
            xml2.open('POST','solutionGroupAjax.php?satatus=3');
            xml2.send(data);
            $('.overlay-editor-fullScreen').show();
            
            groupEditor.setOptions({
                useWrapMode: true,   // wrap text to view
                indentedSoftWrap: false, 
                behavioursEnabled: false, // disable autopairing of brackets and tags
                showLineNumbers: true, // hide the gutter
                });
                groupEditor.session.setUseWrapMode(true);
                groupEditor.setOptions({
                    maxLines: 24,
                    //readOnly: true,
                    enableBasicAutocompletion: true,
                    enableSnippets: true,
                    enableLiveAutocompletion: true,
                    fontSize: "10pt",
                    autoScrollEditorIntoView: true,
                    highlightActiveLine: false,
                    highlightGutterLine: false
                    
                });
                groupEditor.setShowPrintMargin(false);
                if(lang == 'C#'){
                  lang = 'csharp'
                }else if(lang == 'Go'){
                  lang = 'golang'
                }else if(lang == 'C' || lang == 'C++'){
                  lang = 'C_Cpp';
                }
                groupEditor.getSession().setMode('ace/mode/'+lang.toLowerCase());
              
                xmll = new XMLHttpRequest();
                xmll.onreadystatechange = function(){
                  if(xmll.readyState == 4 && xmll.status == 200){
                   $('.compiler-and-run').html(xmll.responseText);
                  }
                }
                xmll.open('POST','solutionGroupAjax.php?satatus=4&gid='+postCodeID+'');
                xmll.send();
                
                
          });




          $('html').on('click','.orginal',function(){
            if($('.orginal').hasClass('new-element')){
              var cof = confirm('do you want delete the new solution');
              if(cof == false){
                
              }else{
                $('.orginal.new-element').remove();
                $('.btn-save-solution').remove();
                $('<div class="fa fa-plus btn btn-success"></div>').appendTo('.sava-container');

            
            var codePostid = $(this).data('cid');
            
            var groupEditor = ace.edit("group-edtior-solution");
            $("#group-edtior-solution-2").hide();
            $("#group-edtior-solution").show();
            $("#group-edtior-solution-3").hide();
            
            $('.list-user-solution').css('background-color',$(this).find('span').css('background-color'))
            $(this).addClass('active').siblings('.orginal').removeClass('active');
            childid = $(this).data('id');
            data = new FormData();
            data.append('child',childid);
            data.append('codePostid1',codePostid);
            xml = new XMLHttpRequest();
            xml.onreadystatechange = function(){
              if(xml.readyState == 4 && xml.status == 200){
                groupEditor.setValue(xml.responseText, 1);
              }
            }
            xml.open("POST",'saveSoltionGroup.php?status=2');
            xml.send(data);
            xml33 = new XMLHttpRequest();
            xml33.onreadystatechange = function(){
              if(xml33.readyState == 4 && xml33.status == 200){
                $('.edit-container').html(xml33.responseText);
              }
            }
            xml33.open("POST",'solutionGroupAjax.php?satatus=5');
            xml33.send(data);
          }
        }else{
           
          var codePostid = $(this).data('cid');
          
          var groupEditor = ace.edit("group-edtior-solution");
          $("#group-edtior-solution-2").hide();
          $("#group-edtior-solution").show();
          $("#group-edtior-solution-3").hide();
          
          $('.list-user-solution').css('background-color',$(this).find('span').css('background-color'))
          $(this).addClass('active').siblings('.orginal').removeClass('active');
          childid = $(this).data('id');
          data = new FormData();
          data.append('child',childid);
          data.append('codePostid1',codePostid);
          xml = new XMLHttpRequest();
          xml.onreadystatechange = function(){
            if(xml.readyState == 4 && xml.status == 200){
              groupEditor.setValue(xml.responseText, 1);
            }
          }
          xml.open("POST",'saveSoltionGroup.php?status=2');
          xml.send(data);
          xml33 = new XMLHttpRequest();
          xml33.onreadystatechange = function(){
            if(xml33.readyState == 4 && xml33.status == 200){
              $('.edit-container').html(xml33.responseText);
            }
          }
          xml33.open("POST",'solutionGroupAjax.php?satatus=5');
          xml33.send(data);
        }
          })



          $('body').on('click','.overlay-editor-fullScreen .list-user-solution i.fa-close',function(){
            if($(this).parent().children('.list-soluiton').children('.orginal').hasClass('new-element')){
               conf = confirm('do you want delete the new solution');
               if(conf==true){
                $('.overlay-editor-fullScreen').hide();
               }else{

               }
            }else{
            $('.overlay-editor-fullScreen').hide();
            }
          })
          $('body').on('click','.btn-show-comment-group',function(){
            $(this).parents('.panel-footer').siblings('.comment-group').show();
            container =$(this).parents('.panel-footer').siblings('.comment-group').find('.comments-read').find('.comments-elements-container');
              xml = new XMLHttpRequest();
              postid = $(this).parents('.panel-default').data('pid');
              data = new FormData();
              data.append('postid', postid);
              xml.onreadystatechange = function(){

                if(xml.readyState <4){
                  $('#loadingProgressG').show();
                }
             
                if(xml.readyState == 4 && xml.status == 200){
                  $('#loadingProgressG').hide();
                  
                  container.html(xml.responseText);
                  $('.post-group-timeline').masonry( 'reloadItems' );
                  $('.post-group-timeline').masonry( 'layout' );
                }
              }
              xml.open('POST','commentDisplayGroup.php');
              xml.send(data);
             
          })
          $('body').on('keypress','.new-comments-group',function(e){
            
            postid = $(this).parents('.panel-default').data('pid');
            container =$(this).parents('.comments-elements-container').children('.comment-with-out-textarea');
            //console.log(container)
            textarea = $(this);
            text = $(this).val();
            if(e.keyCode == 13) {
              e.preventDefault();
              xml =new XMLHttpRequest();
              data = new FormData();
              data.append('postid', postid);
              data.append('textarea', text);
              xml.onreadystatechange = function(){
                if(xml.readyState == 4 && xml.status == 200){
                  //console.log(xml.responseText);
                    container.prepend(xml.responseText);
                    textarea.val('');
                    $('.post-group-timeline').masonry( 'reloadItems' );
                    $('.post-group-timeline').masonry( 'layout' );
                }

              }
              xml.open('POST','commentsGroup.php');
              xml.send(data);
          }
          })
          $('body').on('click','.list-user-solution div.fa-plus',function(){
            $(this).parent().next('.list-soluiton').children('.orginal').removeClass('active');
            xml = new XMLHttpRequest();
            var container =  $(this).parent().next('.list-soluiton');
            
            var savacontainer = $(this).parent();
            divSave = document.createElement('div');
            divSave.setAttribute('class','btn btn-danger btn-save-solution');
            textContainer = document.createTextNode('Save');
            divSave.append(textContainer);
            savacontainer.append(divSave);
            $(this).remove();



            xml.onreadystatechange = function(){
              if(xml.readyState == 4 && xml.status == 200){
                
                  container.append(xml.responseText);
              }
            }
            xml.open('POST','new-solution.php');
            xml.send();
            $('#group-edtior-solution').hide();
            var parent = $('.list-user-solution');
            $('#group-edtior-solution-2').show();
            $('#group-edtior-solution-3').hide();
            var groupEditor2 = ace.edit("group-edtior-solution-2");

              groupEditor2.setOptions({
                  useWrapMode: true,   // wrap text to view
                  indentedSoftWrap: false, 
                  behavioursEnabled: false, // disable autopairing of brackets and tags
                  showLineNumbers: true, // hide the gutter
                  });
                  groupEditor2.session.setUseWrapMode(true);
                  groupEditor2.setOptions({
                      maxLines: 24,
                      enableBasicAutocompletion: true,
                      enableSnippets: true,
                      enableLiveAutocompletion: true,
                      fontSize: "10pt",
                      autoScrollEditorIntoView: true,
                      highlightActiveLine: false,
                      highlightGutterLine: false
                      
                  });
                  groupEditor2.setShowPrintMargin(false);
                  groupEditor2.setValue('');
                  $('.btn-save-solution').attr('disabled','disabled');
                  var groupEditor = ace.edit("group-edtior-solution");
                  mod = groupEditor.getSession().getMode().$id;
                  lang = mod.substr(mod.lastIndexOf('/')+1)
                  if(lang == 'C#'){
                    lang = 'csharp'
                  }else if(lang == 'Go'){
                    lang = 'golang'
                  }
                  groupEditor2.getSession().setMode('ace/mode/'+lang.toLowerCase());
                  
                 
                  
                  
          })

          $('body').on('click','.btn-save-solution',function(){
           
            dataid = $(this).parents('.overlay-editor-fullScreen').data('cid');
            console.log(dataid);
            btn = $(this);
            xml = new XMLHttpRequest();
            
            var groupEditor2 = ace.edit("group-edtior-solution-2");
            var code = groupEditor2.getValue();
            var data = new FormData();
            data.append('code', code);
            data.append('pid',dataid);
            xml.onreadystatechange = function(){
              if(xml.readyState == 4 && xml.status == 200){
                  
                  $('.list-soluiton').html(xml.responseText);
                  $('#group-edtior-solution').show();
                  $('#group-edtior-solution-2').hide();
              }
            }
            xml.open('POST','saveSoltionGroup.php?status=1');
            xml.send(data);
          })
          var groupEditor2 = ace.edit("group-edtior-solution-2");
          groupEditor2.getSession().on('change', function() {
              if(groupEditor2.getValue() == ''){
                $('.btn-save-solution').attr('disabled','disabled');
              }else{
                $('.btn-save-solution').removeAttr('disabled')
              }
            });

      $('body').on('click','.execute-compile',function(){
      var valinput = $('.input-com textarea').val();
      
      var myvar = '<div class="cssload-container2">'+
      '	<div class="cssload-lt"></div>'+
      '	<div class="cssload-rt"></div>'+
      '	<div class="cssload-lb"></div>'+
      '	<div class="cssload-rb"></div>'+
      '</div>';
        var groupEditor = ace.edit("group-edtior-solution");
        var groupEditor3 = ace.edit("group-edtior-solution-3");
        var code = groupEditor.getValue();
        data = new FormData();
        data.append('code', code);
        data.append('inputval', valinput);
        xml = new XMLHttpRequest();
        xml.onreadystatechange = function(){
          if(xml.readyState < 4){
            $('.result-cr').html(myvar);
          }
          if(xml.readyState == 4 && xml.status == 200){
          $('.result-cr').html(xml.responseText);
          }
        }
        xml.open('POST','executeLanguage.php');
        xml.send(data);
      })
      $('body').on('click','.btn-edit-solution',function(){
        console.log("hi");
        var groupEditor = ace.edit("group-edtior-solution");
        var groupEditor3 = ace.edit("group-edtior-solution-3");
        groupEditor3.setOptions({
          useWrapMode: true,   // wrap text to view
          indentedSoftWrap: false, 
          behavioursEnabled: false, // disable autopairing of brackets and tags
          showLineNumbers: true, // hide the gutter
          });
          groupEditor3.session.setUseWrapMode(true);
          groupEditor3.setOptions({
              maxLines: 24,
              enableBasicAutocompletion: true,
              enableSnippets: true,
              enableLiveAutocompletion: true,
              fontSize: "10pt",
              autoScrollEditorIntoView: true,
              highlightActiveLine: false,
              highlightGutterLine: false
              
          });
          groupEditor3.setShowPrintMargin(false);
          mod = groupEditor.getSession().getMode().$id;
          lang = mod.substr(mod.lastIndexOf('/')+1)
          if(lang == 'C#'){
            lang = 'csharp'
          }else if(lang == 'Go'){
            lang = 'golang'
          }
          groupEditor3.getSession().setMode('ace/mode/'+lang.toLowerCase());
      
        $('#group-edtior-solution').hide();
        $('#group-edtior-solution-2').hide();
        $('#group-edtior-solution-3').show();
      
        groupEditor3.setValue(groupEditor.getValue(), 1);


      })
      var groupEditor3 = ace.edit("group-edtior-solution-3");
      groupEditor3.getSession().on('change', function() {
        var cod_id = $('.orginal').data('cid');
        var sloutionid = $('.orginal.active').data('id');
          xml = new XMLHttpRequest();
          form33 = new FormData();
          form33.append('val',groupEditor3.getValue());
          form33.append('cid',cod_id);
          form33.append('sid',sloutionid);
          xml.onreadystatechange = function(){
            if(xml.readyState == 4 && xml.status == 200){
              if(xml.responseText == 'save'){
               $('.edit-container').html('<div class="fa fa-save btn btn-danger btn-save-edit-solution"> Save</div>');
              }else if(xml.responseText == 'no save'){
                $('.edit-container').html('');
              }
            }
          }
          xml.open('POST','CheckSoultionSave.php?status=1');
          xml.send(form33);
          
        });
        $('body').on('click','.btn-save-edit-solution',function(){
          var groupEditor = ace.edit("group-edtior-solution");
          var groupEditor3 = ace.edit("group-edtior-solution-3");
          var cod_id = $('.orginal').data('cid');
          var sloutionid = $('.orginal.active').data('id');
            xml = new XMLHttpRequest();
            form44 = new FormData();
            form44.append('val',groupEditor3.getValue());
            form44.append('cid',cod_id);
            form44.append('sid',sloutionid);
            
          xml = new XMLHttpRequest();
          xml.onreadystatechange = function(){
            if(xml.readyState == 4 && xml.status == 200){
              if(xml.responseText == 'save'){
                alert('Success Save Change');
                $('.edit-container').html('<div class="fa fa-edit btn btn-info btn-edit-solution">Edit</div>');
                $('#group-edtior-solution').show();
        $('#group-edtior-solution-2').hide();
        $('#group-edtior-solution-3').hide();
        groupEditor.setValue(groupEditor3.getValue(),1);
              }

                
             
              }
            }
          
          xml.open('POST','CheckSoultionSave.php?status=2');
          xml.send(form44);
        })
        $('body').on('click','.img-view-matlab',function(){
          
            $('.img-overlay img').attr('src',$(this).attr('src'));
            $('.img-overlay').show();
        })
      
      
        $('.close-overlay').on('click',function(){
          $('.img-overlay').hide();
      })
      $('body').on('click','.delete-post',function(){
        var i = confirm('Are you sure you want to delete the Post');
        if(i == true){
          postid = $(this).data('pid');
          groupid = $(this).data('gid');
          xml  = new XMLHttpRequest();
          xml.onreadystatechange = function(){
            if(xml.readyState == 4 && xml.status == 200){
              var el = jQuery(xml.responseText);
              jQuery(".post-group-timeline").html(el).masonry( 'appended', el, true );
              $('.post-group-timeline').masonry( 'reloadItems' );
              $('.post-group-timeline').masonry( 'layout' );
              $('.post-file-textare').val('');
            }
          }
          xml.open('POST','ajaxPostGroup.php?status=4&pid='+postid+'&gid='+groupid+'');
          xml.send();

        }
      })
      $('body').on('click','span.chosse-io',function(){
        if(!$(this).hasClass('activee')){
          $(this).addClass('activee').siblings('.chosse-io').removeClass('activee');
          $('.'+$(this).data('show')).show();
          $('.'+$(this).data('hide')).hide();
        }
      })
});