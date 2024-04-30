<?php
/*require __DIR__.'/../../assets/api/classes/database.php';
$db_connection = new Database();
$conn = $db_connection->dbConnection();*/
if($role=='1'||$role=='0'):
    try{
        $select = "SELECT * FROM countries";
        $select_stmt = $conn->prepare($select);
        $select_stmt->execute();

        if($select_stmt->rowCount()):
            while($data = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>
                    <td><input type="checkbox" class="checkItem" id="checkItem"></td>
                    <td>'.$data["id"].'</td>
                    <td>
                        
                    </td>
                    <td>'.$data["country"].'</td>
                    <td>'.$data["region"].'</td>
                    <td>'.$data["note"].'.</td>
                    <td>
                        <a href="" class="waves-effect dropdown-toggle" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="custom-icon-table"><img src="assets/images/icons/edit-blue.svg"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item edit_modal" id="edit_'.$data["id"].'" style="cursor:pointer;">Edit</a>
                            <a class="dropdown-item del_modal" id="del_'.$data["id"].'" name="'.$data['country'].'"  style="cursor:pointer;">Delete</a>
                        </div>
                    </td>
                    <td><button id="view_'.$data["id"].'"  type="button" class="btn btn-plan view_btn">View</button></td>
                </tr>';
            }
        
        else:
            echo "Sorry! No country is added.";

        endif;
        
    }
    catch(PDOException $e){
        echo "There is a problem in server, please try again a few moments later.";
    }
elseif($role=='3'):
    try{
        $select = "SELECT * FROM countries where country=:country";
        $select_stmt = $conn->prepare($select);
        $select_stmt->bindValue(':country', htmlspecialchars(strip_tags($country)),PDO::PARAM_STR);
        $select_stmt->execute();

        if($select_stmt->rowCount()):
            while($data = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>
                    <td><input type="checkbox" class="checkItem" id="checkItem"></td>
                    <td>'.$data["id"].'</td>
                    <td>
                        
                    </td>
                    <td>'.$data["country"].'</td>
                    <td>'.$data["region"].'</td>
                    <td>'.$data["note"].'.</td>
                    <td>
                        <a href="" class="waves-effect dropdown-toggle" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="custom-icon-table"><img src="assets/images/icons/edit-blue.svg"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item edit_modal" id="edit_'.$data["id"].'" style="cursor:pointer;">Edit</a>
                            <a class="dropdown-item del_modal" id="del_'.$data["id"].'" style="cursor:pointer;">Delete</a>
                        </div>
                    </td>
                    <td><button id="view_'.$data["id"].'" type="button" class="btn btn-plan view_btn">View</button></td>
                </tr>';
            }
        
        else:
            echo "Sorry! No country is added.";

        endif;
        
    }
    catch(PDOException $e){
        echo "There is a problem in server, please try again a few moments later.";
    }
endif;
