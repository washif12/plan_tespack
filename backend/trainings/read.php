<?php
/*require __DIR__.'/../../assets/api/classes/database.php';
$db_connection = new Database();
$conn = $db_connection->dbConnection();*/
if($role=='3'||$role=='2'||$role=='1'||$role=='0'):
    try{
        $select = "SELECT * FROM ssm_tutorials";
        $select_stmt = $conn->prepare($select);
        $select_stmt->execute();

        if($select_stmt->rowCount()):
            while($data = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                $imgId = str_replace('https://www.youtube.com/watch?v=', '', $data["link"]);
                $imgSrc = "http://img.youtube.com/vi/".$imgId."/0.jpg";
                echo '<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12 m-b-20">
                        <div class="card" style="width: 90%;margin: auto;">
                            <img src="'.$imgSrc.'" class="card-img-top" alt="...">
                            <a class="edit_modal" id="edit_'.$data["id"].'" style="cursor:pointer;">
                                <i class="fa fa-edit edit-overlay text-plan"></i>
                            </a>
                            <a class="del_modal" id="del_'.$data["id"].'" name="'.$data["title"].'"style="cursor:pointer;">
                                <i class="mdi mdi-delete del-overlay text-plan"></i>
                            </a>
                            <a href="'.$data["link"].'" class="popup-youtube">
                                <img src="assets/images/play.png" class="overlay" width="60px">
                            </a>
                            <div class="card-body text-center">
                            <h5 class="card-title">'.$data["title"].'</h5>
                            <p class="card-text">'.$data["description"].'</p>
                            </div>
                        </div>
                    </div>';
            }
        
        else:
            echo '<div class="col-12 text-center"><h3 class="text-plan">Sorry! No Video added.</h3></div>';

        endif;
        
    }
    catch(PDOException $e){
        echo "There is a problem in server, please try again a few moments later.";
    }
else:
    try{
        $select = "SELECT * FROM ssm_tutorials";
        $select_stmt = $conn->prepare($select);
        $select_stmt->execute();

        if($select_stmt->rowCount()):
            while($data = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                $imgId = str_replace('https://www.youtube.com/watch?v=', '', $data["link"]);
                $imgSrc = "http://img.youtube.com/vi/".$imgId."/0.jpg";
                echo '<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="card" style="width: 90%;margin: auto;">
                            <img src="'.$imgSrc.'" class="card-img-top" alt="...">
                            <a href="'.$data["link"].'" class="popup-youtube">
                                <img src="assets/images/play.png" class="overlay" width="60px">
                            </a>
                            <div class="card-body text-center">
                            <h5 class="card-title">'.$data["title"].'</h5>
                            <p class="card-text">'.$data["description"].'</p>
                            </div>
                        </div>
                    </div>';
            }
        
        else:
            echo '<div class="col-12 text-center"><h3 class="text-plan">Sorry! No Video added.</h3></div>';

        endif;
        
    }
    catch(PDOException $e){
        echo "There is a problem in server, please try again a few moments later.";
    }
endif;
?>