<?php
session_start();
$navTop = '';
$postonload = 'hhh';
$pageTitle = 'Group';
include 'init.php';
include 'connect.php';

if(!isset($_COOKIE['SPID'])){
    
    header('Location: login.php');

}else{
    include 'public_page.php';
    
        $stmtcookies =$con->prepare("SELECT users.* FROM users INNER JOIN cookies_token ON users.id = cookies_token.userid WHERE cookies_token.token = :cookies_token");
        $stmtcookies->execute(array(
            ":cookies_token"=>sha1($_COOKIE['SPID'])
        ));
        $rowlogin =$stmtcookies->fetchAll();
        $idlogin = $rowlogin[0]['id'];

include $tpl.'navbar.php';
$idGroup = (int)$_GET['gid'];
$stmtGroup = $con->prepare('SELECT * FROM `group` WHERE id = :id');
$stmtGroup->bindParam(':id',$_GET['gid'],PDO::PARAM_INT);
$stmtGroup->execute();
$rowGroup = $stmtGroup->fetchAll();
$count = $stmtGroup->rowCount();
if($count > 0){
?>
<div class="group-info-sm hidden-md hidden-lg " data-gid="<?php echo $_GET['gid']?>">
    <div class="img-group-info-sm">
        <img src="data\uploads\group-files\default.jpg">
        <div class="group-nav-info-sm hidden-xs" >
                <div class="group-name-sm" >
                <h3><?php echo $rowGroup[0]['Group_name'] ?></h3>
                </div><!--end div.group-name-->
            <div class="nav-tabs-sm">
                <ul class="list-inline">
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="#">Gallery</a></li>
                    <li><a href="#">Member</a></li>
                </ul>    
            </div><!--end div.nav-tabs-sm-->
            <div class="group-join-sm">
                <?php
                    $stmtuserGroup= $con->prepare('SELECT * FROM `user_group` WHERE user_id=:userid AND Group_id=:groupid');
                    $stmtuserGroup->bindParam(':userid',$idlogin,PDO::PARAM_INT);
                    $stmtuserGroup->bindParam(':groupid',$idGroup,PDO::PARAM_INT);
                    $stmtuserGroup->execute();
                    $countuserGroup = $stmtuserGroup->rowCount();
                    if($countuserGroup >0){
                ?>

                <button class="join-button-sm">Following</button>
                <?php
                }else{
                    ?>
                    <button class="join-button-sm">+ join</button>
                    <?php
                }
        ?>
            </div><!--end div.group-join-->
        </div><!--end div.group-nav-info-sm-->
        <div class="group-info-xs hidden-lg hidden-md hidden-sm text-center">
            <div class="group-name-sm" >
                    <h3><?php echo $rowGroup[0]['Group_name'] ?></h3>
            </div><!--end div.group-name-->
            <div class="group-join-xs">
                <?php
                    $stmtuserGroup= $con->prepare('SELECT * FROM `user_group` WHERE user_id=:userid AND Group_id=:groupid');
                    $stmtuserGroup->bindParam(':userid',$idlogin,PDO::PARAM_INT);
                    $stmtuserGroup->bindParam(':groupid',$idGroup,PDO::PARAM_INT);
                    $stmtuserGroup->execute();
                    $countuserGroup = $stmtuserGroup->rowCount();
                    if($countuserGroup >0){
                ?>

                <button class="join-button-sm">Following</button>
                <?php
                }else{
                    ?>
                    <button class="join-button-sm">+ join</button>
                    <?php
                }
        ?>
            </div><!--end div.group-join-->
            <ul class="list-inline">
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="#">Gallery</a></li>
                    <li><a href="#">Member</a></li>
            </ul>    
        </div><!--end div.group-info-xs-->
    </div>
    
    
</div><!--end div.group-info-->
<div class="group-info  hidden-sm hidden-xs" data-gid="<?php echo $_GET['gid']?>">
    <div class="img-group-info">
        <img src="data\uploads\group-files\default.jpg">
    </div>
    <div class="group-name" >
        <h3><?php echo $rowGroup[0]['Group_name'] ?></h3>
    </div><!--end div.group-name-->
    <div class="group-join">
        <?php
            $stmtuserGroup= $con->prepare('SELECT * FROM `user_group` WHERE user_id=:userid AND Group_id=:groupid');
            $stmtuserGroup->bindParam(':userid',$idlogin,PDO::PARAM_INT);
            $stmtuserGroup->bindParam(':groupid',$idGroup,PDO::PARAM_INT);
            $stmtuserGroup->execute();
            $countuserGroup = $stmtuserGroup->rowCount();
            if($countuserGroup >0){
        ?>
        <button class="join-button">Following</button>
        <?php
        }else{
            ?>
            <button class="join-button">+ join</button>
            <?php
        }
?>
    </div><!--end div.group-join-->
</div><!--end div.group-info-->

<div class="content">
<?php 

if(isset($_GET['gid']) && $count>0){
    $stmtJoin = $con->prepare('SELECT * From user_group WHERE user_id=:id AND Group_id = :groupid');
    $stmtJoin->bindParam(':id',$idlogin,PDO::PARAM_INT);
    $stmtJoin->bindParam(':groupid',$_GET['gid'],PDO::PARAM_INT);
    $stmtJoin->execute();
    if($stmtJoin->rowCount() >0){
        ?>
    <div class="new-post-group-btn">
        <div class="btn btn-success btn-block">New Post</div>
    </div>
    <?php 
    }
    ?>
    <div class="post-group-timeline" data-gid="<?php echo $_GET['gid'] ?>">
       
    </div><!--end div.post-group-timeline-->
</div><!--end div.content-->
<div class="overlay-new-post-group">
        <div class="overlay-width">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" data-nav="post-img-group">picture</a></li>
                <li><a data-toggle="tab" data-nav="post-code-group">code</a></li>
                <li><a data-toggle="tab" data-nav="post-file-group">file</a></li>
                
            </ul>
            <div class="new-post-group" data-gid="<?php echo $idGroup ?>">
                <div class="post-img-group" id="menu1">
                    <form method="POST">
                        <textarea class="textarea-img-group" placeholder="What's new with you?"></textarea>
                        
                        <input type="file" id="upload-photo" name="post_pic[]" multiple accept=".png, .jpg, .jpeg, .bmp">
                        <div class="show-img">
                            <div class="gallery">

                            </div>
                        </div><!--end div.show-img-->
                        <div class="panel-footer">
                            <label for="upload-photo"><i class="fa fa-image"></i></label>
                            <input type="submit" class="btn btn-info send-post-pic-group" disabled="disabled" value="POST">
                    </form>        
                    </div>
                </div><!--end div.post-img-group-->
                <div class="post-code-group" id="menu1">
                    <textarea class="textarea-code-group" placeholder="What's new with you?"></textarea>
                    <div id="editorGroup"></div>
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
                            <option value="C">C</option>
                            <option value="C++">C++</option>
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
                            <option value="Kotlin">Kotlin</option>
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
                            <option value="JavaScript">Node.js</option>
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
                        <div class="btn btn-info sendCodeGroup" disabled="disabled">POST</div>
                        
                </div><!--end div.post-code-group-->
                <div class="post-file-group" id="menu1"> 
                    <textarea class="post-file-textare" placeholder="What's new with you?"></textarea>
                    <label for="fileUpload" id="labelfile">Please chosse the file</label>
                    <input type="file" id="fileUpload" class="filePDFANDTEXT" accept=".pdf,.txt">
                    <div class="progress" style=" position: relative;top: 28px;left: 337px;width: 500px;visibility: hidden;">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                                        <span class="prcent"></span>
                                    </div>

                    </div><!--end div.progress-->
                </div><!--end div.new-file-group-->
                
            </div><!--end div.new-post-group-->
        </div><!--end div.overlay-width-->
        <i class="fa fa-close"></i>    
    </div><!--end div.overlay-new-post-group-->
    <div class="overlay-editor-fullScreen">
        
        <div class="list-user-solution">
            <i class="fa fa-close"></i>
            <div class="user-solution-img">
                
             
            </div><!--end div.user-solution-img-->
            <div class="sava-container">
                <div class="fa fa-plus btn btn-success"></div>
            </div>
            <div class="edit-container">
                
            </div>
            <div class="list-soluiton">
                <div class="orginal active">
                    <p>Name</p>
                    <span></span>
                </div>
            </div>
           
            
        </div><!--end div.list-user-solution-->
        <div id="group-edtior-solution">

        </div>
        <div id="group-edtior-solution-2">

        </div>
        <div id="group-edtior-solution-3">

        </div>
        <div class="compiler-and-run">
            
        </div>
        
    </div><!--end div.overlay-editor-fullScreen-->
    <div class="img-overlay img-matlab">
            <i class="fa fa-close close-overlay"></i>            
            <img src="" alt="">
        
    </div>
<?php

}else{
?>

<?php
}

}else{
    ?>
    <div class="alert alert-danger" style="margin-top: 68px;">The group not found</div>
    <?php
}
include $tpl.'footerGroup.php';
}
?>