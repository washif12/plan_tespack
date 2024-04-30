<?php
/*require __DIR__.'/../../assets/api/classes/database.php';
$db_connection = new Database();
$conn = $db_connection->dbConnection();*/
if($role=='3'):
    try{
        $select = "SELECT * FROM devices where country=:country";
        $select_stmt = $conn->prepare($select);
        $select_stmt->bindValue(':country', htmlspecialchars(strip_tags($country)),PDO::PARAM_STR);
        $select_stmt->execute();

        if($select_stmt->rowCount()):
            while($data = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>
                    <td>'.$data["id"].'</td>
                    <td>'.$data["model"].'</td>
                    <td>'.$data["ref"].'</td>
                    <td>'.$data["country"].'</td>
                    <td>'.$data["date"].'</td>
                    <td>'.$data["contact"].'</td>
                    <td>'.$data["note"].'.</td>
                    <td>
                        <a href="" class="waves-effect dropdown-toggle" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="custom-icon-table"><img src="assets/images/icons/edit-blue.svg"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item edit_modal" id="edit_'.$data["id"].'" style="cursor:pointer;">Edit</a>
                            <a class="dropdown-item del_modal" id="del_'.$data["id"].'" name="'.$data['ref'].'" style="cursor:pointer;">Delete</a>
                        </div>
                    </td>
                    <td><a id="view_'.$data["id"].'" href="./smbDetails.php?id='.$data["ssm_id"].'" target="_blank" type="button" class="btn btn-plan view_btn text-white">View</a></td>
                </tr>';
            }
        
        else:
            echo "Sorry! No SSM is added.";

        endif;
        
    }
    catch(PDOException $e){
        echo "There is a problem in server, please try again a few moments later.";
    }
elseif($role=='1'|| $role == '0'):
    try{
        $select = "SELECT * FROM devices";
        $select_stmt = $conn->prepare($select);
        $select_stmt->execute();

        if($select_stmt->rowCount()):
            while($data = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>
                    <td>'.$data["id"].'</td>
                    <td>'.$data["model"].'</td>
                    <td>'.$data["ref"].'</td>
                    <td>'.$data["country"].'</td>
                    <td>'.$data["date"].'</td>
                    <td>'.$data["contact"].'</td>
                    <td>'.$data["note"].'.</td>
                    <td>
                        <a href="" class="waves-effect dropdown-toggle" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="custom-icon-table"><img src="assets/images/icons/edit-blue.svg"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item edit_modal" id="edit_'.$data["id"].'" style="cursor:pointer;">Edit</a>
                            <a class="dropdown-item del_modal" id="del_'.$data["id"].'" name="'.$data['ref'].'" style="cursor:pointer;">Delete</a>
                        </div>
                    </td>
                    <td><a id="view_'.$data["id"].'" href="./smbDetails.php?id='.$data["ssm_id"].'" target="_blank" type="button" class="btn btn-plan view_btn text-white">View</a></td>
                </tr>';
            }
        
        else:
            echo "Sorry! No SSM is added.";

        endif;
        
    }
    catch(PDOException $e){
        echo "There is a problem in server, please try again a few moments later.";
    }
elseif($role=='2'):
    // try{
    //     //$team = "SELECT a.* FROM projects as a left join team_pm as b on b.team_id=a.team_id left join project_managers as c on b.pm_id=c.id where c.reg_id=:login_id";
    //     $team = "SELECT * FROM project_managers where reg_id=:login_id";
    //     $team_stmt = $conn->prepare($team);
    //     $team_stmt->bindValue(':login_id', htmlspecialchars(strip_tags($user_id)),PDO::PARAM_STR);
    //     $team_stmt->execute();

    //     if($team_stmt->rowCount()):
    //         $data = $team_stmt->fetch(PDO::FETCH_ASSOC);
    //         $team_id = $data['team_id'];
    //         if($team_id == NULL):
    //             echo "Sorry! No SSM assigned to this Project Manager.";
    //         else:
    //             $select = "SELECT * FROM devices where team_id=:team_id";
    //             $select_stmt = $conn->prepare($select);
    //             $select_stmt->bindValue(':team_id', htmlspecialchars(strip_tags($team_id)),PDO::PARAM_STR);
    //             $select_stmt->execute();

    //             if($select_stmt->rowCount()):
    //                 while($data = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
    //                     echo '<tr>
    //                         <td><input type="checkbox" class="checkItem" id="checkItem"></td>
    //                         <td>'.$data["id"].'</td>
    //                         <td>'.$data["model"].'</td>
    //                         <td>'.$data["ref"].'</td>
    //                         <td>'.$data["country"].'</td>
    //                         <td>'.$data["date"].'</td>
    //                         <td>'.$data["contact"].'</td>
    //                         <td>'.$data["note"].'.</td>
    //                         <td>
    //                             <a href="" class="waves-effect dropdown-toggle" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    //                             <div class="custom-icon-table"><img src="assets/images/icons/edit-blue.svg"></div>
    //                             </a>
    //                             <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
    //                                 <a class="dropdown-item edit_modal" id="edit_'.$data["id"].'" style="cursor:pointer;">Edit</a>
    //                                 <a class="dropdown-item del_modal" id="del_'.$data["id"].'"  name="'.$data['ref'].'" style="cursor:pointer;">Delete</a>
    //                             </div>
    //                         </td>
    //                         <td><a id="view_'.$data["id"].'" href="./smbDetails.php?id='.$data["ssm_id"].'" target="_blank" type="button" class="btn btn-plan view_btn text-white">View</a></td>
    //                     </tr>';
    //                 }
                
    //             else:
    //                 echo "Sorry! No SSM Added.";

    //             endif;
    //         endif;
    //     else:
    //         echo "Sorry! No SSM under this Project Manager.";
    //     endif;
        
    // }
    // catch(PDOException $e){
    //     echo $e->getMessage();
    // }
    try{
        //$team = "SELECT a.* FROM projects as a left join team_pm as b on b.team_id=a.team_id left join project_managers as c on b.pm_id=c.id where c.reg_id=:login_id";
        $team = "SELECT * FROM project_managers where reg_id=:login_id";
        $team_stmt = $conn->prepare($team);
        $team_stmt->bindValue(':login_id', htmlspecialchars(strip_tags($user_id)),PDO::PARAM_STR);
        $team_stmt->execute();

        if($team_stmt->rowCount()):
            $data_manager = $team_stmt->fetch(PDO::FETCH_ASSOC);
            $team_id = $data_manager['id'];
            if($team_id == NULL):
                echo "Sorry! No SSM assigned to this Project Manager.";
            else:
                $select = "SELECT * FROM smb_resp where pm_id=:team_id";
                $select_stmt = $conn->prepare($select);
                $select_stmt->bindValue(':team_id', htmlspecialchars(strip_tags($team_id)),PDO::PARAM_STR);
                $select_stmt->execute();

                if($select_stmt->rowCount()):
                    while($data_pm = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                        $device = "SELECT * FROM devices where id=:device_id";
                        $device_stmt = $conn->prepare($device);
                        $device_stmt->bindValue(':device_id', htmlspecialchars(strip_tags($data_pm["smb_id"])),PDO::PARAM_STR);
                        $device_stmt->execute();
                        if($device_stmt->rowCount()):
                            $data = $device_stmt->fetch(PDO::FETCH_ASSOC);
                            echo '<tr>
                                <td>'.$data["id"].'</td>
                                <td>'.$data["model"].'</td>
                                <td>'.$data["ref"].'</td>
                                <td>'.$data["country"].'</td>
                                <td>'.$data["date"].'</td>
                                <td>'.$data["contact"].'</td>
                                <td>'.$data["note"].'.</td>
                                <td><a id="edit_'.$data["id"].'" type="button" class="btn btn-plan edit_modal text-white">Edit</a></td>
                                <td><a id="view_'.$data["id"].'" href="./smbDetails.php?id='.$data["ssm_id"].'" target="_blank" type="button" class="btn btn-plan view_btn text-white">View</a></td>
                            </tr>';
                        else:
                            echo "Sorry! No SSM Added.";
                        endif;    
                    }
                
                else:
                    echo "Sorry! No SSM Added.";
                endif;
            endif;
        else:
            echo "Sorry! No SSM under this Project Manager.";
        endif;
        
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }
elseif($role=='4'):
    try{
        //$team = "SELECT a.* FROM projects as a left join team_tm as b on b.team_id=a.team_id left join team_members as c on b.tm_id=c.id where c.reg_id=:login_id";
        $team = "SELECT * FROM team_members where reg_id=:login_id";
        $team_stmt = $conn->prepare($team);
        $team_stmt->bindValue(':login_id', htmlspecialchars(strip_tags($user_id)),PDO::PARAM_STR);
        $team_stmt->execute();

        if($team_stmt->rowCount()):
            $data = $team_stmt->fetch(PDO::FETCH_ASSOC);
            $team_id = $data['team_id'];
            if($team_id == NULL):
                echo "Sorry! No SSM assigned to this Project.";
            else:
                $select = "SELECT * FROM devices where team_id=:team_id";
                $select_stmt = $conn->prepare($select);
                $select_stmt->bindValue(':team_id', htmlspecialchars(strip_tags($team_id)),PDO::PARAM_STR);
                $select_stmt->execute();

                if($select_stmt->rowCount()):
                    while($data = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo '<tr>
                            <td>'.$data["id"].'</td>
                            <td>'.$data["model"].'</td>
                            <td>'.$data["ref"].'</td>
                            <td>'.$data["country"].'</td>
                            <td>'.$data["date"].'</td>
                            <td>'.$data["contact"].'</td>
                            <td>'.$data["note"].'.</td>
                            <td><a id="view_'.$data["id"].'" href="./smbDetails.php?id='.$data["ssm_id"].'" target="_blank" type="button" class="btn btn-plan view_btn text-white">View</a></td>
                            <td></td>
                        </tr>';
                    }
                
                else:
                    echo "Sorry! No SSM Added.";

                endif;
            endif;
        else:
            echo "Sorry! No SSM under this User.";
        endif;
        
    }
    catch(PDOException $e){
        echo "There is a problem in server, please try again a few moments later.";
    }
endif;
?>