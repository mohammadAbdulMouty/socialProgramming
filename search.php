<?php
   $bgColor='';
   include 'init.php';
   include $tpl.'navbar.php';
   ?>
 
   <?php
 if(isset($_COOKIE['SPID'])){
    $stmt =$con->prepare("SELECT users.* FROM users INNER JOIN cookies_token ON users.id = cookies_token.userid WHERE cookies_token.token = :cookies_token");
     $stmt->execute(array(
         ":cookies_token"=>sha1($_COOKIE['SPID'])
     ));
     $rowlogin = $stmt->fetchAll();
     $idlogin = $rowlogin[0]['id'];
if($_SERVER['REQUEST_METHOD']=='GET'){
    $lan='';
    if(!empty($_GET['q'])){
        if($_GET['ty']==5){
            $q= $_GET['q'];
            if(isset($_GET['p'])){
                $p=$_GET['p'];
            }else{
                $p=0;    
            }if(isset($_GET['lan'])){
                $lan = $_GET['lan'];
            }
            
            
            $i=0;
            $maxPage =0;
            $val = file_get_contents('https://searchcode.com/api/codesearch_I/?q='.$q.'&p='.$p.'&lan='.$lan.'&loc=0&loc2=10000&src=13');
            $allresult = json_decode($val,true);
            ?>
            <div class="container" >
              <div class="col-md-3">  
                <div class="container-code-result" data-wrsearch="<?php echo $allresult['searchterm'] ?>">
                    <h4>Filter Search Language</h4>
                    <div class="language-fiter">
                        <form method="GET" >
                            <?php 
                            foreach($allresult['language_filters'] as $lag){
                                $lag['language'] = strtolower(str_replace('#','sharp',$lag['language']))
                                ?>
                                
                            <div class=" alert alert-info">
                                
                                <?php
            
                                 echo '<p style="display:inline-block">'.$lag['language'].'</p>';
                                if(file_exists("layout/icons/".strtolower(str_replace('#','sharp',$lag['language'])).".svg")){
                                    echo '<object data="layout/icons/'.strtolower(str_replace('#','sharp',$lag['language'])).'.svg"></object>';
                                }else if(file_exists("layout/icons/file_type_".strtolower(str_replace('#','sharp',$lag['language'])).".svg")){
                                    echo "<object data='layout/icons/file_type_".strtolower(str_replace('#','sharp',$lag['language'])).".svg' ></object>";
                                }else if(file_exists("layout/icons/file_type_".strtolower(substr($lag['language'],0,stripos($lag['language'],' '))).".svg")){
                                    echo "<object data='layout/icons/file_type_".strtolower(substr($lag['language'],0,stripos($lag['language'],' '))).".svg'></object>";
                                }else{
                                    
                                    echo '<object data="layout/icons/html-coding.svg"></object>';
                                }
                               ?>
                                <input type="checkbox" name="lan" value="<?php echo $lag['id'] ?>" style="display:block">
                               
                            </div>
                            <?php 
                            }
                            ?>
                             <input type="hidden" name="q" value="<?php echo $allresult['searchterm'] ?>">
                                <input type="hidden" name="ty" value="5">
                                 <input type="hidden" name="p" value="0">
                            <input type="submit" class="btn btn-info" value="save">
                        </form>
                    </div><!--end div.language-filter-->
                </div><!--end div.contianer-code-result-->
            </div><!--end div.col-md-3-->
            <div class="col-md-8">
               
                    <?php 
                        foreach($allresult['results'] as $reslutCode){
                            ?>
                            <div class="code-search-result">
                            <div class="path-code">
                                <a href="<?php echo $reslutCode['repo'] ?>">
                             <?php echo $reslutCode['repo'] ?>
                             </a>
                             <?php
                             $fixLang = array(
                                'C/C++ Header'=>'c',
                                'C++'=>'cpp',
                                'Objective C'=>'objectivec'
                             );
                             if(array_key_exists($reslutCode["language"],$fixLang)){
                                 $reslutCode['language'] = $fixLang[$reslutCode["language"]];
                             }
                             if(file_exists("layout/icons/".strtolower(str_replace('#','sharp',$reslutCode["language"])).".svg")){
                                    echo '<object data="layout/icons/'.strtolower(str_replace('#','sharp',$reslutCode["language"])).'.svg"></object>';
                                }else if(file_exists("layout/icons/file_type_".strtolower(str_replace('#','sharp',$reslutCode["language"])).".svg")){
                                    echo "<object data='layout/icons/file_type_".strtolower(str_replace('#','sharp',$reslutCode["language"])).".svg' ></object>";
                                }else if(file_exists("layout/icons/file_type_".strtolower(substr($reslutCode["language"],0,stripos($reslutCode["language"],' '))).".svg")){
                                    echo "<object data='layout/icons/file_type_".strtolower(substr($reslutCode["language"],0,stripos($reslutCode["language"],' '))).".svg'></object>";
                                }else{
                                    
                                    echo '<object data="layout/icons/html-coding.svg"></object>';
                    
                                }
                                ?>
                                <mark style="background-color: #ffff002e;"><?php echo $reslutCode["language"] ?></mark>
                             <hr style="border-color:#dccece">
                            </div>
                            <pre>
                            
                            <?php
                            foreach($reslutCode['lines'] as $resultCodelineNum => $Codeline){
                                    if(!empty(trim($Codeline))){
                                        echo '<span style="margin-right:15px;">'.$resultCodelineNum.'</span>';
                                        ?><code class="language-<?php echo strtolower($reslutCode["language"]) ?>"><?php echo htmlspecialchars($Codeline) ?></code><br>;<?php
                                    }
                                    
                            }
                            ?>
                            
                            </pre>
                            </div>

                            <?php
                        }
                    ?>
            </div>
            
            </div><!--end div.container-->
            <div class="pagination-container">
                <ul class="pagination">
                    <?php
                    if(isset($_GET['p'])){
                        if($_GET['p']<5){
                            $start = 0;
                            $end = 9;
                        }else{
                        $start = $_GET['p']-5;
                        $end = $_GET['p']+5;
                        }
                    }else{
                        $start=0;
                        $end=10;
                    }
                    $active = '';
                    $totalPageCal=$allresult['total']/20;
                    if($totalPageCal>49){
                        $maxPage = 50;
                    }else{
                        $maxPage = ceil($totalPageCal);
                    }
                    for($i=$start;$i<$end;$i++){
                        if($i <$maxPage){
                         if($i == $_GET['p']){
                             $active='active';
                         }else{
                            $active = '';
                         } 
                    ?>
                    <li class="<?php echo $active ?>"><a href="?q=<?php echo $allresult['searchterm']?>&ty=5&p=<?php echo $i ?>" ><?php echo $i+1 ?></a></li>
                <?php 
                        }else{
                            break;
                        }
                    }
                ?>
                </ul>
            </div><!--end div.pagination-container-->       
            <?php
            
        
        }
        else if($_GET['ty'] == 1){
            
            $likestmt = '%'.$_GET['q'].'%';
            $stmtlike = $con->prepare('SELECT * FROM `users` WHERE Name LIKE :likes');
            $stmtlike->bindParam(':likes',$likestmt,PDO::PARAM_STR);
            $stmtlike->execute();
            $rows = $stmtlike->fetchAll();
           
            foreach($rows as $row){
                $ifuserfriend = $con->prepare('SELECT * FROM `friends` WHERE friend1 =:friend1 AND friend2 =:friend2');
                $ifuserfriend->bindParam(':friend1',$idlogin,PDO::PARAM_INT);
                $ifuserfriend->bindParam(':friend2',$row['id'],PDO::PARAM_INT);
                $ifuserfriend->execute();
               $countFriend = $ifuserfriend->rowCount();

            ?>
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="user-container">
                            <div class="panel panel-body panel-info">
                                <img src="data\uploads\images\default.jpg">
                                <a href="http://sprogramming/?id=<?=$row['id']?>"><h3><?=$row['Name']?></h3></a>
                                <p>Description</p>
                                <?php
                                if($countFriend){
                                    ?>
                                <div class="btn btn-success remove-friendSearch" data-id="<?= $row['id']?>">Friend</div>
                                    <?php
                                    
                                    }else if($idlogin == $row['id']){?>
                                        <div class="you">you</div>
                                        <?php
                                    }
                                    
                                    else{
                                        ?>
                                        <div class="btn btn-default add-friendSearch" data-id="<?= $row['id']?>">+ Add Friend</div>
                                        <?php
                                    }
                                ?>
                            </div>
                        </div>
                    </div><!--end div.col-md-4-->
                   <?php 
            }
                   ?>
                </div><!--end div.row-->
            </div>


            <?php
        }else if($_GET['ty'] == 2){
            $likestmt = '%'.$_GET['q'].'%';
            $stmtlike = $con->prepare('SELECT * FROM `group` WHERE status = 1 And Group_name LIKE :likes');
            $stmtlike->bindParam(':likes',$likestmt,PDO::PARAM_STR);
            $stmtlike->execute();
            $rows = $stmtlike->fetchAll();
            ?>
                <div class="container">
                <div class="row">
            <?php
            foreach($rows as $row){
                $stmtuserg = $con->prepare('SELECT * FROM `user_group` WHERE Group_id = :groupid AND user_id =:userid');
                $stmtuserg->bindParam(':groupid',$row['id'],PDO::PARAM_INT);
                $stmtuserg->bindParam(':userid',$idlogin,PDO::PARAM_INT);
                $stmtuserg->execute();
                $st = $stmtuserg->fetchAll();
                $count = $stmtuserg->rowCount();
                
            ?>
            
                    <div class="col-md-4">
                        <div class="group-container">
                            <div class="panel panel-body panel-success">
                                <a href="http://sprogramming/group.php?gid=<?=$row['id']?>"><h2><?=$row['Group_name']?></h2></a>
                                <p><?=$row['Description']?></p>
                                <?php 
                                if($count>0){
                                    if(isset($st[0]['permission'])){
                                        if($st[0]['permission'] == 1){
                                        ?>
                                        <div class="alert alert-info">Your Group</div>
    
                                    <?php
                                        }else{
                                            ?>
                                            <div class="btn btn-success btn-djoin-group" data-gid="<?=$row['id']?>">Folowing</div>
    
                                        <?php
                                        }
                                    }else{
                                    ?>
                                        <div class="btn btn-success btn-djoin-group" data-gid="<?=$row['id']?>">Folowing</div>

                                    <?php
                                    }
                                }
                                
                                else{
                                    ?>
                                        <div class="btn btn-default btn-join-group" data-gid="<?=$row['id']?>">Join Group</div>

                                    <?php
                                }
                                ?>
                                
                            </div>    
                        </div>
                    </div>
             

            <?php
        }
        ?>
               </div>
            </div>
        <?php
        }

    }
    
}

?>
<script src="layout/js/jquery-1.12.1.min.js"></script> 
<script src="layout/js/clipboard.min.js"></script> 
<script src="<?php echo $js; ?>bootstrap.min.js"></script>
<script src="<?php echo $js; ?>prism.js"></script>
<script src="<?php echo $js; ?>forall.js"></script>

<?php
 }else{
     
    header('Location: login.php');
 }?>