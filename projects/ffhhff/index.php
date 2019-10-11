<?php
    $postonload ="mm";
    $pageTitle = 'Profile';
    include 'init.php';
    include $tpl.'navbar.php';
    $profileID = $_GET['id'];
    if(isset($_COOKIE['SPID'])){
        $stmt =$con->prepare("SELECT users.* FROM users INNER JOIN cookies_token ON users.id = cookies_token.userid WHERE cookies_token.token = :cookies_token");
         $stmt->execute(array(
             ":cookies_token"=>sha1($_COOKIE['SPID'])
         ));
         $rowlogin = $stmt->fetchAll();
         $idlogin = $rowlogin[0]['id'];
         $stmt2=$con->prepare("SELECT * FROM users WHERE id = :id");
         $stmt2->execute(array(':id'=>$profileID));
         $rows = $stmt2->fetchAll();
         
?>

<div class="container">
    <div class="img-cover">
        <img class="cover-image img-responsive" src="data\uploads\images\mb-bg-fb-08.png" alt="alt">
        
        <div class="user-nav hidden-sm hidden-xs">
            <div class="row">
                <div class="col-md-3">
                    <div class="profile-info">
                        
                        <img class="profile-img" src="data\uploads\images\default.jpg" alt="profile Image">
                        <?php
                            if($idlogin == $profileID){
                                echo '<i class="fa fa-edit btn-change-pic"></i>';
                            }
                            ?>
                        <div class="infoprof">
                            <?php
                               $editname = $idlogin == $profileID? ' <i class="fa fa-edit btn-edit-name"></i>': '';

                            ?>
                            <h3><?php echo '<span>'. $rows[0]['Name'].'</span>'; echo $editname  ?></h3>
                            <p>Programming of php</p>
                        </div>    
                    </div>    
                </div>
                <div class="col-md-9">
                    <ul class="list-inline navbar-prof">
                        <li class="btn btn-success"><a href="">TimeLine</a></li>
                        <li><a href="gallary.php?id=<?php echo $_GET['id'] ?>">Album</a></li>
                        <li><a href="friend.php?id=<?php echo $_GET['id'] ?>">Friend</a></li>
                        <li><a href="project.php?id=<?php echo $_GET['id'] ?>">Project</a></li>
                        <li><a href="">About</a></li>
                    </ul>
                    <div class="add-friend">
                    <?php 
                        $stmtFriend = $con->prepare('SELECT * FROM `friends` WHERE friend1=:f1 and friend2=:f2');
                        $stmtFriend->execute(array(':f1'=>$idlogin,':f2'=>$profileID));
                        $count = $stmtFriend->rowCount();
                        if($count>0){
                            ?>
                            <div class="addFriend">
                                <div class="btn btn-danger btnAddFriend" data-id="<?php echo $rows[0]['id']  ?>">Remove Friend</div>
                                <p style="display:inline;">1,299 people friend</p>
                            </div>

                            <?php
                        }else{
                            ?>
                               <div class="addFriend">
                                    <div class="btn btn-default btnAddFriend" data-id="<?php echo $rows[0]['id']  ?>"> + Add Friend</div>
                                    <p style="display:inline;">1,299 people friend</p>
                                </div>


                            <?php
                        }


                    ?>
                       
                    </div>
                    
                </div>    
            </div>
        </div><!--end div.user-nav-->
        
    </div><!--end the div.img-cover-->
    <div class="user-nav-mobile hidden-lg hidden-md">
                <div class="col-md-3">
                            <div class="profile-info-mobile">
                                <img class="profile-img-mobile" src="data\uploads\images\default.jpg" alt="profile Image">
                                <div class="infoprof">
                                    <h3><?php echo $rows[0]['Name']?></h3>
                                    <p>Programming of php</p>
                                </div>    
                            </div>    
                </div>
                <div class="col-md-9">
                    <ul class="list-inline navbar-prof-mobile">
                    <li class="btn btn-default"><a href="">TimeLine</a></li>
                    <li><a href="">Album</a></li>
                    <li><a href="">Friend</a></li>
                    <li><a href="">About</a></li>
                    </ul>
                    <div class="add-friend-mobile">
                        <ul>
                            <li><div class="btn btn-success btnAddFriend">+ Add Friend</div></li>
                            <li><p>1,299 people friend</p></li>
                        </ul>
                    </div>
                    
                </div> 
    </div><!--end div.user-nav-mobile-->
    <div class="postInProfile">
            <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-9">
               
                <div class="formprof">
                    
                    <ul class="nav nav-tabs nav-tabs-profile">
                        <li class="active" data-u ="post"><a href="#">Add Post</a></li>
                        <li data-u ="code"><a href="#" >Add Code</a></li>
                        <li data-u ="file"><a href="#" >Add File</a></li>
                    </ul>

                    <div class="post">
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" >
                            <span>What's on your mind?</span>
                            <textarea id="post-pic-textarea"></textarea>
                            <div class="parentscroll">
                                <div class="gallery"></div>
                            </div>
                            <hr>      
                            
                            <label id="label-file-up" for="post_pic" ><i class="fa fa-picture-o"></i> Select Picture To Upload</label>
                            <input type="file" id="post_pic" name="post_pic[]"  accept=".png, .jpg, .jpeg, .bmp" multiple >
                            <input type="submit" name="post-pic" class="btn btn-info" id="sendpost-pic"  value="Post" data-post="1" >
                        </from>
                    </div>
                        
                    <div class="code">
                        <form method="POST">
                            <textarea placeholder="Please describe the code" id="textareaCode"></textarea>
                            <div id="editor"></div>
                            <select id="ace-mode">
                            <option value="0" selected>chosse the laguage</option>
                            <option value="ABAP">ABAP</option>
                            <option value="ActionScript">ActionScript</option>
                            <option value="ADA">ADA</option>
                            <option value="Apache Conf">Apache Conf</option>
                            <option value="AsciiDoc">AsciiDoc</option>
                            <option value="Assembly x86">Assembly x86</option>
                            <option value="AutoHotKey">AutoHotKey</option>
                            <option value="BatchFile">BatchFile</option>
                            <option value="C/C++">C/C++</option>
                            <option value="C#">C#</option>
                            <option value="C9 Search Results">C9 Search Results</option>
                            <option value="Cirru">Cirru</option>
                            <option value="Clojure">Clojure</option>
                            <option value="Cobol">Cobol</option>
                            <option value="CoffeeScript">CoffeeScript</option>
                            <option value="ColdFusion">ColdFusion</option>
                            <option value="CSS">CSS</option>
                            <option value="Curly">Curly</option>
                            <option value="D">D</option>
                            <option value="Dart">Dart</option>
                            <option value="Diff">Diff</option>
                            <option value="Dockerfile">Dockerfile</option>
                            <option value="Dot">Dot</option>
                            <option value="EJS">EJS</option>
                            <option value="Erlang">Erlang</option>
                            <option value="Forth">Forth</option>
                            <option value="FreeMarker">FreeMarker</option>
                            <option value="Gherkin">Gherkin</option>
                            <option value="Gitignore">Gitignore</option>
                            <option value="Glsl">Glsl</option>
                            <option value="Go">Go</option>
                            <option value="Groovy">Groovy</option>
                            <option value="HAML">HAML</option>
                            <option value="Handlebars">Handlebars</option>
                            <option value="Haskell">Haskell</option>
                            <option value="haXe">haXe</option>
                            <option value="HTML">HTML</option>
                            <option value="HTML (Ruby)">HTML (Ruby)</option>
                            <option value="INI">INI</option>
                            <option value="Jack">Jack</option>
                            <option value="Jade">Jade</option>
                            <option value="Java">Java</option>
                            <option value="JavaScript">JavaScript</option>
                            <option value="JSON">JSON</option>
                            <option value="JSONiq">JSONiq</option>
                            <option value="JSP">JSP</option>
                            <option value="JSX">JSX</option>
                            <option value="Julia">Julia</option>
                            <option value="LaTeX">LaTeX</option>
                            <option value="LESS">LESS</option>
                            <option value="Liquid">Liquid</option>
                            <option value="Lisp">Lisp</option>
                            <option value="LiveScript">LiveScript</option>
                            <option value="LogiQL">LogiQL</option>
                            <option value="LSL">LSL</option>
                            <option value="Lua">Lua</option>
                            <option value="LuaPage">LuaPage</option>
                            <option value="Lucene">Lucene</option>
                            <option value="Makefile">Makefile</option>
                            <option value="Markdown">Markdown</option>
                            <option value="MATLAB">MATLAB</option>
                            <option value="MEL">MEL</option>
                            <option value="MUSHCode">MUSHCode</option>
                            <option value="MySQL">MySQL</option>
                            <option value="Nix">Nix</option>
                            <option value="Nix">Nix</option>
                            <option value="Objective-C">Objective-C</option>
                            <option value="OCaml">OCaml</option>
                            <option value="Pascal">Pascal</option>
                            <option value="Perl">Perl</option>
                            <option value="pgSQL">pgSQL</option>
                            <option value="PHP">PHP</option>
                            <option value="Plain Text">Plain Text</option>
                            <option value="Powershell">Powershell</option>
                            <option value="Prolog">Prolog</option>
                            <option value="Properties">Properties</option>
                            <option value="Protobuf">Protobuf</option>
                            <option value="Python">Python</option>
                            <option value="R">R</option>
                            <option value="RDoc">RDoc</option>
                            <option value="RHTML">RHTML</option>
                            <option value="Ruby">Ruby</option>
                            <option value="Rust">Rust</option>
                            <option value="SASS">SASS</option>
                            <option value="SCAD">SCAD</option>
                            <option value="Scala">Scala</option>
                            <option value="Scheme">Scheme</option>
                            <option value="SCSS" >SCSS</option>
                            <option value="SH">SH</option>
                            <option value="SJS">SJS</option>
                            <option value="Smarty">Smarty</option>
                            <option value="snippets">snippets</option>
                            <option value="Soy Template">Soy Template</option>
                            <option value="Space">Space</option>
                            <option value="SQL">SQL</option>
                            <option value="Stylus">Stylus</option>
                            <option value="SVG">SVG</option>
                            <option value="Tcl">Tcl</option>
                            <option value="Tex">Tex</option>
                            <option value="Text">Text</option>
                            <option value="Textile">Textile</option>
                            <option value="Toml">Toml</option>
                            <option value="Twig">Twig</option>
                            <option value="Typescript">Typescript</option>
                            <option value="Vala">Vala</option>
                            <option value="VBScript">VBScript</option>
                            <option value="Velocity">Velocity</option>
                            <option value="Verilog">Verilog</option>
                            <option value="XML">XML</option>
                            <option value="XQuery">XQuery</option>
                            <option value="YAML">YAML</option>
                        </select>
                        <input type="submit" class="btn btn-info" id="sendpostCode"  value="Post" >
                    </form>
                    </div>            
                    <div class="file">
                            <form   method="post" class="uploadpdf" enctype='multipart/form-data'>
                                <textarea placeholder="describe the file" class="filedescribe" style="margin-top: 10px;width: 100%; height: 101px;resize:none;"></textarea>
                                <label for="filepdfupload" id="filepdfuploadd" class="btn btn-success">please Choose The File</label>
                                <input  type="file" class="filepdf" id="filepdfupload" name="fileup"  style="display:none;" accept=".pdf">
                                <div class="progress" style=" position: relative;top: 28px;left: 337px;width: 500px;visibility: hidden;">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                                        <span class="prcent"></span>
                                    </div>
                                </div>
                                
                               
                            </form>
                    </div>
                    <hr style="border-color:#fff;border-width:2px;">
                   
                </div>
                
           </div>
        </div><!--end .row-->
    </div><!--end div.postInProfile-->



    <div class="timeline">
         
    </div><!--end div.timeline-->
   
</div><!--end the div.container-->
<div class="overlay-editor">
    <i class="fa fa-close"></i>
    <div id="editor2"></div>
    <div id="editor3"></div>
    <div class="menu-list-programmer">
         <ul class="ul-list-programming">
            <li class="list-prog add-new-programmin"><i class="fa fa-plus"></i></li>
            <li class="list-prog"><span>orginal</span></li>            
         </ul>
    </div><!--end div.menu-list-programmer-->
    
</div><!--end div.overlay-editor-->
<?php
        if($idlogin == $profileID){
            ?>
                <div class="overlay-edit-name">
                <form class="form">
                    <div class="form-group">
                    <input type="text" class="form-control" id="input-new-name" placeholder="Input Your New Name">
                    </div>
                    <button type="submit" class="btn btn-success btn-save-new-name">Save</button>
                    <button type="submit" class="btn btn-danger btn-close-overlay">Close</button>
                </form>
                </div>
                <div class="img-change-overlay">

                    <i class="fa fa-close"></i>

                    <div class="overlay">
                        <div class="to-color" style="width: fit-content;margin: auto;background-color: rgba(110, 109, 109, 0.62);margin-top: 30px;">
                            <div >
                            <div id="upload-demo" style="width:350px;padding-top: 30px;margin: auto;"></div>
                            </div>
                            <div  style="padding-top: 29px;padding-left: 31%;">
                            <br/>
                            <label for="upload" class="label-change-photo">Chosse The File</label>
                            <input type="file" id="upload" style="display:none">
                            <br/>
                            <button class="btn btn-success upload-result">Upload Image</button>
                            </div>
                        </div>
                    </div>
                </div><!--end div.img-change-overlay-->
                <div class="overlay-change-post">
                    <i class="fa fa-close"></i>
                    <div class="overlay-edit">
                        <div class="text-change">
                            <textarea class="change-text"></textarea>
                            <button class="btn btn-success btn-save-new-val">Save</button>
                        </div>
                    </div>    
                </div><!--end div.overlay-change-post-->
            <?php
        }
    ?>
<?php
    }else{
        header('Location: login.php');
    }
    include $tpl.'footer.php';
    echo 'hi';
?>