$(function(){
    var clipboard = new Clipboard('.copy');
    function mouseX(evt) {
        if (evt.pageX) {
            return evt.pageX;
        } else if (evt.clientX) {
           return evt.clientX + (document.documentElement.scrollLeft ?
               document.documentElement.scrollLeft :
               document.body.scrollLeft);
        } else {
            return null;
        }
    }
    
    function mouseY(evt) {
        if (evt.pageY) {
            return evt.pageY;
        } else if (evt.clientY) {
           return evt.clientY + (document.documentElement.scrollTop ?
           document.documentElement.scrollTop :
           document.body.scrollTop);
        } else {
            return null;
        }
    }
    $("body").on('contextmenu','.file-Name',function(e){
        fileName = $(this).text();
        
        $('.context-menu-project').attr('data-file',fileName);
        $('.context-menu-project').show();
        var offset = $(this).offset();
        $('.context-menu-project').offset(
            {left:e.pageX+200,top:e.pageY+10}
        );
        e.preventDefault();
        xml = new XMLHttpRequest();
        xml.onreadystatechange = function(){
            if(xml.readyState == 4 && xml.status == 200){
                console.log(xml.responseText);
            }
        }
        xml.open('POST','saveSessionNameFile.php?fileName='+fileName+'');
        xml.send();
      }
      );
      $(document).bind("click", function(event) {
        $('.context-menu-project').removeAttr('data-file');
        $('.context-menu-project').hide();
    });
    $('.upload-Project').on('click',function(){
        $('.overlay-upload-drag').show();
    })
   
    
    $('#dropzone').on("dragenter dragstart dragend dragleave dragover drag drop", function (e) {
        e.preventDefault();
    });
    if ($('#dropzone').length > 0) {
    console.log('hi');
   var drop = document.getElementById('dropzone');
   drop.ondrop = function(e){
    upload(e.dataTransfer.files);
   }
   var upload = function(files){
    var formData = new FormData(),
         xml = new XMLHttpRequest(),
         x;
         
         if(files.length > 1){
            alert("please chosse the one file")
         }else{
                if(files[0]['type'] != 'application/x-zip-compressed'){
                    alert('Please Chosse the Zip File');
                }else{
                    formData.append('file',files[0]);
                    xml.onload = function(){
                        var data = this.responseText;
                        console.log(data)
                    }
                    var progress = $('.progress');
                    progress.show();
                    xml.upload.onprogress = function(e){
                        $('.progressDrag').css('width',Math.floor(((e.loaded / e.total) * 100))+"%");
                                    $('.prcent').html(Math.floor(((e.loaded / e.total) * 100))+"%");
                                    if(Math.floor(((e.loaded / e.total) * 100))==100){
                                       
                                    }
                                }
                                xml.onreadystatechange = function(){
                                    if(xml.readyState == 4 && xml.status == 200){
                                        window.location.reload();
                                    }
                                }
                xml.open('POST','uploadProjectDrag.php');
                xml.send(formData);
                }
         }
}
    
}
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
        $('.body-folder').on('mouseenter',function(){
           $(this).children('.control-project').show();
        })
        $('.body-folder').on('mouseleave',function(){
            $('.control-project').hide();
        })
        //to add new project
        $('.btn-add-project').on('click',function(){
            xml = new XMLHttpRequest();
                xml.onreadystatechange = function(){
                    if(xml.readyState == 4 && xml.status == 200){

                       $('.container-projects').html(xml.responseText);
                       window.location.reload();
                    }
                }
                xml.open('POST','new_project.php');
                xml.send();
            
        })
        if($('#editor4').length >0){
        var edittest = ace.edit("editor4");
        edittest.setOptions({
            useWrapMode: true,   // wrap text to view
            indentedSoftWrap: false, 
            behavioursEnabled: false, // disable autopairing of brackets and tags
            showLineNumbers: true, // hide the gutter
            theme: "ace/theme/tomorrow"
            });
            edittest.session.setUseWrapMode(true);
            edittest.setOptions({
                maxLines: 30,
                enableBasicAutocompletion: true,
                enableSnippets: true,
                enableLiveAutocompletion: true,
                fontSize: "10pt",
                autoScrollEditorIntoView: true,
                highlightActiveLine: false,
                highlightGutterLine: false
                
            });
            edittest.setShowPrintMargin(false);
            var filePath = "style.css";
           var extension = filePath.split('.').pop();
          
            var nameOverrides = {
                ObjectiveC: "Objective-C",
                CSharp: "C#",
                golang: "Go",
                C_Cpp: "C and C++",
                Csound_Document: "Csound Document",
                Csound_Orchestra: "Csound",
                Csound_Score: "Csound Score",
                coffee: "CoffeeScript",
                HTML_Ruby: "HTML (Ruby)",
                HTML_Elixir: "HTML (Elixir)",
                FTL: "FreeMarker"
            };
            var modesByName = {};
            
            $('.input-search-lib').keyup(function(){
                
            var myvar = '<div class=\'sk-cube-grid\'>'+
                '<div class=\'sk-cube sk-cube1\'></div>'+
                '<div class=\'sk-cube sk-cube2\'></div>'+
                '<div class=\'sk-cube sk-cube3\'></div>'+
                '<div class=\'sk-cube sk-cube4\'></div>'+
                '<div class=\'sk-cube sk-cube5\'></div>'+
                '<div class=\'sk-cube sk-cube6\'></div>'+
                '<div class=\'sk-cube sk-cube7\'></div>'+
                '<div class=\'sk-cube sk-cube8\'></div>'+
                '<div class=\'sk-cube sk-cube9\'></div>'+
                '</div><!--end div.sk-cube-grid-->';
                
    
                var myvar2 = '<div class="label-nolib">We are sorry, the library you\'re searching for cannot be found</div>';
    
    
                xml = new XMLHttpRequest();
                val = $(this).val();
                if(val != ''){
                data = new FormData();
                data.append('val',val);
                xml.onreadystatechange = function(){
                    if(xml.readyState <4){
                        $('.result-search').html(myvar);
                        $('.watiing-api').show();
                    }
                    if(xml.readyState ==4 && xml.status == 200){
                        $('.watiing-api').hide();
                        if(xml.responseText !=''){
                            $('.result-search').html(xml.responseText);
                         }else{
                            $('.result-search').html(myvar2);
                         }
                    }
                }
                xml.open('POST','ajaxSearchLibray.php');
                xml.send(data);
            }else{
                $('.watiing-api').hide();
                $('.result-search').html('');
            }
            })
            // $('body').on('click','.cdn-element span.copy',function(){
            //     cdn = $(this).parents('.content-name').siblings('.content-cdn');
            //     cdn.select();
            //     document.execCommand("Copy");
                
                
            // })
            $('.overlay-libray i.fa-close').on('click',function(){
                $('.overlay-libray').hide();
            })
            $('.content-info-folder div.btn-primary').on('click',function(){
                $('.result-search').html('');
                $('.input-search-lib').val('');
                $('.overlay-libray').show();
            })
            
            $('.content-info-folder .panel .panel-heading i.fa-arrow-left').on('click',function(){
               
                var parentFolder = $(".panel-heading p").text().split('\\').slice(0,-1).join('\\');
                if(parentFolder.lastIndexOf('\\') == -1){
                    $(this).hide();
                }
                xml = new XMLHttpRequest();
                xml.onreadystatechange = function(){
                    if(xml.readyState == 4 && xml.status == 200){
                        $('.panel-heading p').html(parentFolder);
                        $('.panel-body').html(xml.responseText);
                    }
                }
                xml.open('POST','parentFolder.php?parentFolder='+parentFolder+'');
                xml.send();
            })
           $('body').on('click','.content-info-folder .panel .panel-body .file-Name',function(){
            $('#editor4').hide();
            var val = $(this).text();
           
            if(val.lastIndexOf(".") ==-1){
                var folderid = $(this).parents('.content-info-folder').data('proid');
                ajax = new XMLHttpRequest();
                
                $('.panel-heading p').append('\\'+val.split('\\').pop());
                if($(".panel-heading p").text().lastIndexOf('\\') != -1){
                   $('.content-info-folder .panel .panel-heading i.fa-arrow-left').css('display','inline-block');
                }
                console.log();
                var data = new FormData();
                data.append('val',val);
                data.append('folderid',folderid);
                ajax.onreadystatechange = function(){
                    if(ajax.readyState == 4 && ajax.status == 200){
                        $('.panel-body').html(ajax.responseText);
                    }
                }
                ajax.open('POST','folderOpen.php');
                ajax.send(data);
            }else{
                
            $('.content-editor .name-file .file-name').text(val.split('\\').pop());
            $('.content-editor').attr('data-file',val);
            var folderid = $(this).parents('.content-info-folder').data('proid');
            var extension = val.split('.').pop();
         
            var supportedModes = {
                ABAP:        ["abap"],
                ABC:         ["abc"],
                ActionScript:["as"],
                ADA:         ["ada","adb"],
                Apache_Conf: ["^htaccess","^htgroups","^htpasswd","^conf","htaccess","htgroups","htpasswd"],
                AsciiDoc:    ["asciidoc","adoc"],
                Assembly_x86:["asm","a"],
                AutoHotKey:  ["ahk"],
                BatchFile:   ["bat","cmd"],
                Bro:         ["bro"],
                C_Cpp:       ["cpp","c","cc","cxx","h","hh","hpp","ino"],
                C9Search:    ["c9search_results"],
                Cirru:       ["cirru","cr"],
                Clojure:     ["clj","cljs"],
                Cobol:       ["CBL","COB"],
                coffee:      ["coffee","cf","cson","^Cakefile"],
                ColdFusion:  ["cfm"],
                CSharp:      ["cs"],
                Csound_Document: ["csd"],
                Csound_Orchestra: ["orc"],
                Csound_Score: ["sco"],
                CSS:         ["css"],
                Curly:       ["curly"],
                D:           ["d","di"],
                Dart:        ["dart"],
                Diff:        ["diff","patch"],
                Dockerfile:  ["^Dockerfile"],
                Dot:         ["dot"],
                Drools:      ["drl"],
                Dummy:       ["dummy"],
                DummySyntax: ["dummy"],
                Eiffel:      ["e","ge"],
                EJS:         ["ejs"],
                Elixir:      ["ex","exs"],
                Elm:         ["elm"],
                Erlang:      ["erl","hrl"],
                Forth:       ["frt","fs","ldr","fth","4th"],
                Fortran:     ["f","f90"],
                FTL:         ["ftl"],
                Gcode:       ["gcode"],
                Gherkin:     ["feature"],
                Gitignore:   ["^.gitignore"],
                Glsl:        ["glsl","frag","vert"],
                Gobstones:   ["gbs"],
                golang:      ["go"],
                GraphQLSchema: ["gql"],
                Groovy:      ["groovy"],
                HAML:        ["haml"],
                Handlebars:  ["hbs","handlebars","tpl","mustache"],
                Haskell:     ["hs"],
                Haskell_Cabal:     ["cabal"],
                haXe:        ["hx"],
                Hjson:       ["hjson"],
                HTML:        ["html","htm","xhtml","vue","we","wpy"],
                HTML_Elixir: ["eex","html.eex"],
                HTML_Ruby:   ["erb","rhtml","html.erb"],
                INI:         ["ini","conf","cfg","prefs"],
                Io:          ["io"],
                Jack:        ["jack"],
                Jade:        ["jade","pug"],
                Java:        ["java"],
                JavaScript:  ["js","jsm","jsx"],
                JSON:        ["json"],
                JSONiq:      ["jq"],
                JSP:         ["jsp"],
                JSSM:        ["jssm","jssm_state"],
                JSX:         ["jsx"],
                Julia:       ["jl"],
                Kotlin:      ["kt","kts"],
                LaTeX:       ["tex","latex","ltx","bib"],
                LESS:        ["less"],
                Liquid:      ["liquid"],
                Lisp:        ["lisp"],
                LiveScript:  ["ls"],
                LogiQL:      ["logic","lql"],
                LSL:         ["lsl"],
                Lua:         ["lua"],
                LuaPage:     ["lp"],
                Lucene:      ["lucene"],
                Makefile:    ["^Makefile","^GNUmakefile","^makefile","^OCamlMakefile","make"],
                Markdown:    ["md","markdown"],
                Mask:        ["mask"],
                MATLAB:      ["matlab"],
                Maze:        ["mz"],
                MEL:         ["mel"],
                MUSHCode:    ["mc","mush"],
                MySQL:       ["mysql"],
                Nix:         ["nix"],
                NSIS:        ["nsi","nsh"],
                ObjectiveC:  ["m","mm"],
                OCaml:       ["ml","mli"],
                Pascal:      ["pas","p"],
                Perl:        ["pl","pm"],
                pgSQL:       ["pgsql"],
                PHP:         ["php","phtml","shtml","php3","php4","php5","phps","phpt","aw","ctp","module"],
                Pig:         ["pig"],
                Powershell:  ["ps1"],
                Praat:       ["praat","praatscript","psc","proc"],
                Prolog:      ["plg","prolog"],
                Properties:  ["properties"],
                Protobuf:    ["proto"],
                Python:      ["py"],
                R:           ["r"],
                Razor:       ["cshtml","asp"],
                RDoc:        ["Rd"],
                Red:         ["red","reds"],
                RHTML:       ["Rhtml"],
                RST:         ["rst"],
                Ruby:        ["rb","ru","gemspec","rake","^Guardfile","^Rakefile","^Gemfile"],
                Rust:        ["rs"],
                SASS:        ["sass"],
                SCAD:        ["scad"],
                Scala:       ["scala"],
                Scheme:      ["scm","sm","rkt","oak","scheme"],
                SCSS:        ["scss"],
                SH:          ["sh","bash","^.bashrc"],
                SJS:         ["sjs"],
                Smarty:      ["smarty","tpl"],
                snippets:    ["snippets"],
                Soy_Template:["soy"],
                Space:       ["space"],
                SQL:         ["sql"],
                SQLServer:   ["sqlserver"],
                Stylus:      ["styl","stylus"],
                SVG:         ["svg"],
                Swift:       ["swift"],
                Tcl:         ["tcl"],
                Tex:         ["tex"],
                Text:        ["txt"],
                Textile:     ["textile"],
                Toml:        ["toml"],
                TSX:         ["tsx"],
                Twig:        ["twig","swig"],
                Typescript:  ["ts","typescript","str"],
                Vala:        ["vala"],
                VBScript:    ["vbs","vb"],
                Velocity:    ["vm"],
                Verilog:     ["v","vh","sv","svh"],
                VHDL:        ["vhd","vhdl"],
                Wollok:      ["wlk","wpgm","wtest"],
                XML:         ["xml","rdf","rss","wsdl","xslt","atom","mathml","mml","xul","xbl","xaml"],
                XQuery:      ["xq"],
                YAML:        ["yaml","yml"],
                Django:      ["html"]
            };
            var cons = 'Text';
            for (var name in supportedModes) {
                var data = supportedModes[name];
                
                if(Array.isArray(data)){
                    
                    if(data.indexOf(extension)>=0){
                        cons = name;
                    }
                    
                    
                } }
               
               
    
                
               data = new FormData();
               data.append('val',val);
               data.append('folderid',folderid);
                
               xml = new XMLHttpRequest();
               xml.onreadystatechange = function(){
                   if(xml.readyState == 4 && xml.status == 200){
                       $('#editor4').show();
                    var edittest = ace.edit("editor4");
                        edittest.setValue(xml.responseText,1);
                        edittest.getSession().setMode("ace/mode/"+cons.toLowerCase());

                        console.log(xml.responseText)
                   }
               }
               xml.open('POST','getCodeProject.php');
               xml.send(data);
            }
           })
           var edittest = ace.edit("editor4");
           edittest.getSession().on('change', function() {
            var editorVal = edittest.getValue();
            
            var idfileProject = $('.content-editor').data('gid');
            var data = new FormData();
            data.append('idfile', idfileProject);
            data.append('newVal', editorVal);
            xml = new XMLHttpRequest();
            xml.onreadystatechange = function(){
                if(xml.readyState == 4 && xml.status == 200){
                    console.log(xml.responseText)
                    if(xml.responseText == 'no save'){
                        $('.btn-save-object').attr('disabled','disabled');
                        $('.stares').hide();
                    }else{
                        $('.btn-save-object').removeAttr('disabled','disabled');
                        $('.stares').show();
                       
                    }
                }
            }
            xml.open('POST','fileEqualToSave.php');
            xml.send(data);
            
           })
           $('.btn-save-object').on('click',function(){
               var folderid = $('.content-info-folder').data('proid');
               data = new FormData();
               data.append('data',folderid);
               var edittest = ace.edit("editor4");
               var val = edittest.getValue();
               data.append('val',val);
                xml = new XMLHttpRequest();
                xml.onreadystatechange = function(){
                    $('.btn-save-object').attr('disabled','disabled');
                    $('.stares').hide();
                  
                }
                xml.open('POST','btnSaveChangeFile.php');
                xml.send(data);
           })
        }
           $('.content-info-folder .panel .panel-heading i.fa-download').on('click',function(){
               xml = new XMLHttpRequest();
               xml.onreadystatechange = function(){
                if(xml.readyState == 4 && xml.status == 200){
                        console.log(xml.responseText);
                }
               }
               xml.open('POST','DownloadProject.php');
               xml.send();
           })
           $('.pagination li').on('click',function(){
               $(this).addClass('active').siblings().removeClass('active');
           })
          
        //    $('.show-check-div').click(function(){
        //     $('.box-show').toggle(200);
        //   })
        $('.context-menu-project li.delete').on('click',function(){
            xml = new XMLHttpRequest();
            xml.onreadystatechange = function(){
                if(xml.readyState == 4 && xml.status == 200){
                    $('.panel-body').html(xml.responseText);
                }
            }
            xml.open('POST','editFileProject.php?status=1');
            xml.send();
        })
        $('.context-menu-project li.rename').on('click',function(){
            xml = new XMLHttpRequest();
            $('.overlay-rename .new-name').val('');
            xml.onreadystatechange= function(){
                if(xml.readyState == 4 && xml.status == 200){
                    $('.overlay-rename').show();
                    $('.overlay-rename .new-name').val(xml.responseText);
                }
            }
            xml.open('POST','show_name_file.php');
            xml.send();
            
        })
        $('.rename-div .btn-rename-close').on('click',function(){
            $('.overlay-rename').hide();
        })
        $('.btn-rename-save').on('click',function(){
            newName = $('.overlay-rename .new-name').val();
            xml = new XMLHttpRequest();
            xml.onreadystatechange = function(){
                if(xml.readyState == 4 && xml.status == 200){
                    $('.panel-body').html(xml.responseText);
                    $('.overlay-rename').hide();
                }
            }
            xml.open('POST','editFileProject.php?status=2&new='+newName+'');
            xml.send();
        })

        $('.btn-add-partners').on('click',function(){
            $('.overlay-partners').show();
            xml = new XMLHttpRequest();
            xml.onreadystatechange = function(){
                if(xml.readyState == 4 && xml.status == 200){
                    $('.friend-content').html(xml.responseText);
                }
            }
            xml.open('POST','newFriendPartner.php');
            xml.send();
        })
        $('body').on('click','.add-friend-partners',function(){
            id = $(this).data('id');
            xml = new XMLHttpRequest();
            xml.onreadystatechange = function(){
                if(xml.readyState == 4 && xml.status == 200){
                    $('.friend-content').html(xml.responseText);
                }
            }
            xml.open('POST','newFriendPartner.php?status=1&id='+id+'');
            xml.send();
        })
        $('body').on('click','.remove-friend-partners',function(){
            id = $(this).data('id');
            xml = new XMLHttpRequest();
            xml.onreadystatechange = function(){
                if(xml.readyState == 4 && xml.status == 200){
                    $('.friend-content').html(xml.responseText);
                }
            }
            xml.open('POST','newFriendPartner.php?status=2&id='+id+'');
            xml.send();
        })
        $('.btn-close-overlay-part').on('click',function(){
            $('.overlay-partners').hide();
        })
        setInterval(function(){
            
               
            var array= '';
          var c =  $('.panel-heading p').text();
            ajax = new XMLHttpRequest();
            ajax.onreadystatechange = function(){
                
                if(ajax.responseText !=''){
                    var array = JSON.parse(ajax.responseText);
                    var len = array.length;
                    for(var i = 0 ;i<len;i++){
                        $('.file-check').each(function(){
                            if($(this).text() == array[i]){
                                if(!$(this).hasClass('no-open-file')){
                                    $(this).addClass('no-open-file');
                                    $(this).removeClass('file-Name');
                                }
                                
                                
                                
                            }else{
                                $(this).removeClass('no-open-file');
                                if(!$(this).hasClass('file-Name')){
                                    $(this).addClass('file-Name');
                                }
                                
                            }
                        })
                    }
                
                   
                }else{
                    $('.file-check').each(function(){
                        $(this).removeClass('no-open-file');
                        if(!$(this).hasClass('file-Name')){
                            $(this).addClass('file-Name');
                        }
                    });
                }
               
            }
            ajax.open('POST','checkFile.php?c='+c+'');
            ajax.send();
            if($('.content-editor .name-file p').text() !==''){
                namefile = $('.content-editor .name-file p').text();
                xml = new XMLHttpRequest();
                xml.onreadystatechange = function(){
                    if(xml.readyState == 4 && xml.status == 200){
                    
                    }
                   
                }
                xml.open('POST','updatefileopen.php?file='+namefile+'');
                    xml.send();
                }

        },3000);
    $('.close-drag').on('click',function(){
        $('.overlay-upload-drag').hide();
    })
    });
    