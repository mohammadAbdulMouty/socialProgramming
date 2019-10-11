<?php

session_start();
$noNotfication='';
$bgColor='';
include 'init.php';
date_default_timezone_set('Asia/Damascus');
if(isset($_COOKIE['SPID'])){
        $stmt =$con->prepare("SELECT users.* FROM users INNER JOIN cookies_token ON users.id = cookies_token.userid WHERE cookies_token.token = :cookies_token");
         $stmt->execute(array(
             ":cookies_token"=>sha1($_COOKIE['SPID'])
         ));
         $rowlogin = $stmt->fetchAll();
         $idlogin = $rowlogin[0]['id'];
         $_SESSION['projectID'] = $_GET['pid'];
         
         ?>
    
        <div class="col-md-7">
            
            <div class="content-editor" data-gid="<?php echo $_GET['pid'] ?>">
                <div class="name-file">
                    <p class="file-name"></p>
                    <sup class="stares" style="display:none">*</sup>
                </div><!--end div.name-file-->    
                <div id="editor4"></div>
                   
            </div>
        </div><!--end div.col-md-8-->
        <?php
                    $path = getcwd().'\projects';
                    $stmtName = $con->prepare('SELECT Name FROM `project` WHERE id=:id');
                    $stmtName->bindParam(':id',$_GET['pid']);
                    $stmtName->execute();
                    $rowsName = $stmtName->fetchAll();?>
        <div class="col-md-5">
            <div class="content-info-folder" data-proid="<?php echo $_GET['pid']?>">
                <div class="panel panel-default">
                    <div class="panel-heading">Recent Files: <?php echo "<p>".$rowsName[0]['Name']."</p>" ?><i class="fa fa-arrow-left"></i><i class="fa fa-download"></i></div>
                    <div class="panel-body">
                    
                   <?php
                    $fileName = array();
                    $dir = $path."\\".$rowsName[0]['Name'];
                    $checkon = $con->prepare('SELECT * FROM `user_project` WHERE projectid = :project');
                    $checkon->bindParam(':project',$_GET['pid']);
                    $checkon->execute();
                    $rows = $checkon->fetchAll();
                    foreach($rows as $row){
                        if(strtotime($row['data_open']) >= time()-5){

                            array_push($fileName,$row['file_name']);
                        }
                    }
                    

                    $r = scandir($dir);
                    for($i = 2 ;$i<count($r);$i++){
                        $path_info = pathinfo($r[$i]);
                        
                        if(isset($path_info['extension'])){
                            if(file_exists("layout/icons/".$path_info['extension'].".svg")){
                                echo '<object data="layout/icons/'.$path_info['extension'].'.svg"></object>';
                            }else{
                                if($path_info['extension'] == 'js'){
                                    echo '<object data="layout/icons/javascript.svg"></object>';
                                }else if($path_info['extension'] == 'jpg'||$path_info['extension'] == 'gif'||$path_info['extension'] == 'bmp'||$path_info['extension'] == 'png'){
                                    echo '<object data="layout/icons/image.svg"></object>';
                                }else{
                                echo '<object data="layout/icons/file.svg"></object>';
                                }
                            }
                        }else{
                            echo '<span class="glyphicon glyphicon-folder-open"></span>';
                        }
                        if(in_array(trim($r[$i]),$fileName)){
                            echo "<div class='file-check no-open-file'>".
                        trim($r[$i])."";
                       
                        
                        echo "</div>";

                        }else{
                            echo "<div class='file-check file-Name'>".
                            trim($r[$i])."";
                           
                            
                            echo "</div>";
                        }
                        
                        
                     
                    }
                    ?>
                    </div>
                    
                    
                </div><!--end div.panel panel-default-->
                <div class="btn btn-success col-md-5 btn-save-object" disabled>Save</div>
                <div class="space col-md-2"></div>
                <div class="btn btn-danger col-md-5">Delete</div>
                <div class="btn btn-primary btn-block btn-library">Chosse The CDN Libraries</div>
                <div class="btn btn-info btn-block btn-add-partners">Add Partners</div>
                <div class="overlay-partners">
                
                    <div class="friends-par">
                    <i class="fa fa-close btn-close-overlay-part"></i>
                      <div class="friend-content">

                      </div>  
                    </div><!--end div.friends-par-->
                </div>
            </div><!--end div.content-info-folder--> 
        </div><!--end div.col-md-5-->
        <div class="overlay-libray">
            <i class="fa fa-close"></i>
            <div class="content-libray">
                <div class="overlay-search">
                    <input type="text" class="input-search-lib" placeholder="Search The CDN  Library" >
                </div><!--end div.overlay-search-->
                <div class="result-search">
                    <div class="watiing-api">
                       
                    </div><!--end div.watiing-api-->
                </div>
            </div><!--end div.content-library-->
        </div><!--end div .overlay-libray-->
        <div class="context-menu-project">
            <ul>
                <li class="delete">Delete</li>
                <li class="rename">Rename</li>
            </ul>
        </div><!--end div.context-menu-->
        <div class="overlay-rename">
            <div class="rename-div">
                <p>Please enter a new name for the item:</p>
                <input type="text" class="new-name">
                <div class="btn btn-success btn-rename-save">Save</div>       
                <div class="btn btn-danger btn-rename-close">Close</div>       
            </div><!--end div.rename-div-->
        </div><!--end div.overlay-rename-->
<?php

}else{
    header('Location: login.php');
    
}?>
    <script src="<?php echo $lib; ?>src-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>
    
    <script src="<?php echo $lib; ?>src-noconflict/ext-language_tools.js"></script>
    <script src="<?php echo $lib; ?>src-noconflict/ext-language_tools.js"></script>
    <script src="layout/js/jquery-1.12.1.min.js"></script> 
    <script src="<?php echo $js; ?>bootstrap.min.js"></script>
    <script src="<?php echo $js; ?>clipboard.min.js"></script>
    <script src="layout/js/endProject.js"></script>
   
     
</body>
</html>