<?php
/*require __DIR__.'/../../assets/api/classes/database.php';
$db_connection = new Database();
$conn = $db_connection->dbConnection();*/
if($role=='3'):
    try{
        $select = "SELECT * FROM users WHERE verified='1' AND country=:country AND id!=:userId";
        $select_stmt = $conn->prepare($select);
        $select_stmt->bindValue(':country', htmlspecialchars(strip_tags($country)),PDO::PARAM_STR);
        $select_stmt->bindValue(':userId', htmlspecialchars(strip_tags($user_id)),PDO::PARAM_STR);
        $select_stmt->execute();

        if($select_stmt->rowCount()):
            while($data = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                if($data['role']=='1'):
                    echo '<tr>
                        <td><input type="checkbox" class="checkItem" id="checkItem"></td>
                        <td>'.$data["id"].'</td>
                        <td>'.$data["fname"].' '.$data["lname"].'</td>
                        <td>'.$data["email"].'</td>
                        <td><span class="badge badge-success font-14">Global Admin</span></td>
                        <td>'.$data["phone"].'</td>
                        <td>'.$data["country"].'</td>
                        <td>'.$data["address"].'</td>
                        <td><a id="edit_'.$data["id"].'" type="button" class="btn btn-plan edit_modal text-white">Edit</a></td>
                        <td><a id="del_'.$data["id"].'" name="'.$data["fname"].' '.$data["lname"].'" type="button" class="btn btn-plan del_modal text-white">Delete</a></td>
                    </tr>';
                elseif($data['role']=='2'):
                    echo '<tr>
                        <td><input type="checkbox" class="checkItem" id="checkItem"></td>
                        <td>'.$data["id"].'</td>
                        <td>'.$data["fname"].' '.$data["lname"].'</td>
                        <td>'.$data["email"].'</td>
                        <td><span class="badge badge-plan font-14">Project Admin</span></td>
                        <td>'.$data["phone"].'</td>
                        <td>'.$data["country"].'</td>
                        <td>'.$data["address"].'</td>
                        <td><a id="edit_'.$data["id"].'" type="button" class="btn btn-plan edit_modal text-white">Edit</a></td>
                        <td><a id="del_'.$data["id"].'" type="button" name="'.$data["fname"].' '.$data["lname"].'" class="btn btn-plan del_modal text-white">Delete</a></td>
                    </tr>';
                elseif($data['role']=='3'):
                    echo '<tr>
                        <td><input type="checkbox" class="checkItem" id="checkItem"></td>
                        <td>'.$data["id"].'</td>
                        <td>'.$data["fname"].' '.$data["lname"].'</td>
                        <td>'.$data["email"].'</td>
                        <td><span class="badge badge-warning font-14">Country Admin</span></td>
                        <td>'.$data["phone"].'</td>
                        <td>'.$data["country"].'</td>
                        <td>'.$data["address"].'</td>
                        <td><a id="edit_'.$data["id"].'" type="button" class="btn btn-plan edit_modal text-white">Edit</a></td>
                        <td><a id="del_'.$data["id"].'" type="button" name="'.$data["fname"].' '.$data["lname"].'" class="btn btn-plan del_modal text-white">Delete</a></td>
                    </tr>';
                elseif($data['role']=='4'):
                    echo '<tr>
                        <td><input type="checkbox" class="checkItem" id="checkItem"></td>
                        <td>'.$data["id"].'</td>
                        <td>'.$data["fname"].' '.$data["lname"].'</td>
                        <td>'.$data["email"].'</td>
                        <td><span class="badge badge-purple font-14">Team Member</span></td>
                        <td>'.$data["phone"].'</td>
                        <td>'.$data["country"].'</td>
                        <td>'.$data["address"].'</td>
                        <td><a id="edit_'.$data["id"].'" type="button" class="btn btn-plan edit_modal text-white">Edit</a></td>
                        <td><a id="del_'.$data["id"].'" name="'.$data["fname"].' '.$data["lname"].'" type="button" class="btn btn-plan del_modal text-white">Delete</a></td>
                    </tr>';
                endif;
            }
        
        else:
            echo "Sorry! No Data found.";

        endif;
        
    }
    catch(PDOException $e){
        echo "There is a problem in server, please try again a few moments later.";
    }
elseif($role=='1'||$role=='0'):
    try{
        $select = "SELECT * FROM users WHERE verified='1' AND id!=:userId";
        $select_stmt = $conn->prepare($select);
        $select_stmt->bindValue(':userId', htmlspecialchars(strip_tags($user_id)),PDO::PARAM_STR);
        $select_stmt->execute();

        if($select_stmt->rowCount()):
            while($data = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                if($data['role']=='1'):
                    echo '<tr>
                        <td><input type="checkbox" class="checkItem" id="checkItem"></td>
                        <td>'.$data["id"].'</td>
                        <td>'.$data["fname"].' '.$data["lname"].'</td>
                        <td>'.$data["email"].'</td>
                        <td><span class="badge badge-success font-14">Global Admin</span></td>
                        <td>'.$data["phone"].'</td>
                        <td>'.$data["country"].'</td>
                        <td>'.$data["address"].'</td>
                        <td><a id="edit_'.$data["id"].'" type="button" class="btn btn-plan edit_modal text-white">Edit</a></td>
                        <td><a id="del_'.$data["id"].'" name="'.$data["fname"].' '.$data["lname"].'" type="button" class="btn btn-plan del_modal text-white">Delete</a></td>
                    </tr>';
                elseif($data['role']=='2'):
                    echo '<tr>
                        <td><input type="checkbox" class="checkItem" id="checkItem"></td>
                        <td>'.$data["id"].'</td>
                        <td>'.$data["fname"].' '.$data["lname"].'</td>
                        <td>'.$data["email"].'</td>
                        <td><span class="badge badge-plan font-14">Project Admin</span></td>
                        <td>'.$data["phone"].'</td>
                        <td>'.$data["country"].'</td>
                        <td>'.$data["address"].'</td>
                        <td><a id="edit_'.$data["id"].'" type="button" class="btn btn-plan edit_modal text-white">Edit</a></td>
                        <td><a id="del_'.$data["id"].'" name="'.$data["fname"].' '.$data["lname"].'" type="button" class="btn btn-plan del_modal text-white">Delete</a></td>
                    </tr>';
                elseif($data['role']=='3'):
                    echo '<tr>
                        <td><input type="checkbox" class="checkItem" id="checkItem"></td>
                        <td>'.$data["id"].'</td>
                        <td>'.$data["fname"].' '.$data["lname"].'</td>
                        <td>'.$data["email"].'</td>
                        <td><span class="badge badge-warning font-14">Country Admin</span></td>
                        <td>'.$data["phone"].'</td>
                        <td>'.$data["country"].'</td>
                        <td>'.$data["address"].'</td>
                        <td><a id="edit_'.$data["id"].'"  type="button" class="btn btn-plan edit_modal text-white">Edit</a></td>
                        <td><a id="del_'.$data["id"].'" name="'.$data["fname"].' '.$data["lname"].'" type="button" class="btn btn-plan del_modal text-white">Delete</a></td>
                    </tr>';
                elseif($data['role']=='4'):
                    echo '<tr>
                        <td><input type="checkbox" class="checkItem" id="checkItem"></td>
                        <td>'.$data["id"].'</td>
                        <td>'.$data["fname"].' '.$data["lname"].'</td>
                        <td>'.$data["email"].'</td>
                        <td><span class="badge badge-purple font-14">Team Member</span></td>
                        <td>'.$data["phone"].'</td>
                        <td>'.$data["country"].'</td>
                        <td>'.$data["address"].'</td>
                        <td><a id="edit_'.$data["id"].'" type="button" class="btn btn-plan edit_modal text-white">Edit</a></td>
                        <td><a id="del_'.$data["id"].'" name="'.$data["fname"].' '.$data["lname"].'" type="button" class="btn btn-plan del_modal text-white">Delete</a></td>
                    </tr>';
                endif;
            }
        
        else:
            echo "Sorry! No User is added.";

        endif;
        
    }
    catch(PDOException $e){
        echo "There is a problem in server, please try again a few moments later.";
    }
elseif($role=='2'):
    $user_info = [];
    try{
        $select = "SELECT * FROM project_managers where reg_id=:login_id limit 1";
        $select_stmt = $conn->prepare($select);
        $select_stmt->bindValue(':login_id', htmlspecialchars(strip_tags($user_id)),PDO::PARAM_STR);
        $select_stmt->execute();

        if($select_stmt->rowCount()):
            $data = $select_stmt->fetch(PDO::FETCH_ASSOC);
            $team_id = $data['team_id'];
            $pm = "SELECT a.* FROM users as a left join project_managers as b on b.reg_id=a.id left join teams as c on c.id=b.team_id where c.id=$team_id and a.id!=:login_id";
            $pm_stmt = $conn->prepare($pm);
            $pm_stmt->bindValue(':login_id', htmlspecialchars(strip_tags($user_id)),PDO::PARAM_STR);
            $pm_stmt->execute();
            foreach($data_pm = $pm_stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                array_push($user_info,$row);
            }
            $tm = "SELECT a.* FROM users as a left join team_members as b on b.reg_id=a.id left join teams as c on c.id=b.team_id where c.id=$team_id";
            $tm_stmt = $conn->prepare($tm);
            $tm_stmt->execute();
            foreach($data_tm = $tm_stmt->fetchAll(PDO::FETCH_ASSOC) as $item) {
                array_push($user_info,$item);
            }
            foreach($user_info as $data) {
                if($data['role']=='2'):
                    echo '<tr>
                        <td><input type="checkbox" class="checkItem" id="checkItem"></td>
                        <td>'.$data["id"].'</td>
                        <td>'.$data["fname"].' '.$data["lname"].'</td>
                        <td>'.$data["email"].'</td>
                        <td><span class="badge badge-plan font-14">Project Admin</span></td>
                        <td>'.$data["phone"].'</td>
                        <td>'.$data["country"].'</td>
                        <td>'.$data["address"].'</td>
                        <td><a id="edit_'.$data["id"].'" type="button" class="btn btn-plan edit_modal text-white">Edit</a></td>
                        <td></td>
                    </tr>';
                elseif($data['role']=='4'):
                    echo '<tr>
                        <td><input type="checkbox" class="checkItem" id="checkItem"></td>
                        <td>'.$data["id"].'</td>
                        <td>'.$data["fname"].' '.$data["lname"].'</td>
                        <td>'.$data["email"].'</td>
                        <td><span class="badge badge-purple font-14">Team Member</span></td>
                        <td>'.$data["phone"].'</td>
                        <td>'.$data["country"].'</td>
                        <td>'.$data["address"].'</td>
                        <td><a id="edit_'.$data["id"].'"  type="button" class="btn btn-plan edit_modal text-white">Edit</a></td>
                        <td></td>
                    </tr>';
                endif;
            }
        
        else:
            echo "Sorry! No Projects under this Manager";

        endif;
        
    }
    catch(PDOException $e){
        echo "There is a problem in server, please try again a few moments later.";
    }
endif;
?>