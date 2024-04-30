<?php
/*require __DIR__.'/../../assets/api/classes/database.php';
$db_connection = new Database();
$conn = $db_connection->dbConnection();*/
if($role=='1'||$role=='3'|| $role == '0'):
    try{
        $select = "SELECT * FROM teams";
        $select_stmt = $conn->prepare($select);
        $select_stmt->execute();

        if($select_stmt->rowCount()):
            while($data = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                $team_id = $data["id"];
                /* Getting Project Managers */
                $count_pm = "SELECT count(id) as total_pm FROM project_managers where team_id=$team_id";
                $count_pm_stmt = $conn->prepare($count_pm);
                $count_pm_stmt->execute();
                $pm_data = $count_pm_stmt->fetch(PDO::FETCH_ASSOC);
                /* Getting temamembers */
                $count_tm = "SELECT count(id) as total_tm FROM team_members where team_id=$team_id";
                $count_tm_stmt = $conn->prepare($count_tm);
                $count_tm_stmt->execute();
                $tm_data = $count_tm_stmt->fetch(PDO::FETCH_ASSOC);
                /* Getting SMB data */
                $count_smb = "SELECT count(id) as total_smb FROM devices where team_id=$team_id";
                $count_smb_stmt = $conn->prepare($count_smb);
                $count_smb_stmt->execute();
                $smb_data = $count_smb_stmt->fetch(PDO::FETCH_ASSOC);
                echo '<tr>
                    <td>'.$data["id"].'</td>
                    <td>'.$data["name"].'</td>
                    <td><button type="button" class="btn btn-sm btn-plan" id="" data-container="body" data-toggle="popover" data-trigger="hover" data-content="Click View Button to see Details">'.$pm_data["total_pm"].'</button></td>
                    <td>'.$data["contact"].'</td>
                    <td><button type="button" class="btn btn-sm btn-plan" id="" data-container="body" data-toggle="popover" data-trigger="hover" data-content="Click View Button to see Details">'.$tm_data["total_tm"].'</button></td>
                    <td><button type="button" class="btn btn-sm btn-plan" id="" data-container="body" data-toggle="popover" data-trigger="hover" data-content="Click View Button to see Details">'.$smb_data["total_smb"].'</button></td>
                    <td>
                        <a class="waves-effect dropdown-toggle" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="custom-icon-table"><img src="assets/images/icons/edit-blue.svg"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item edit_modal" id="edit_'.$data["id"].'" style="cursor:pointer;">Edit</a>
                            <a class="dropdown-item del_modal" id="del_'.$data["id"].'" name="'.$data["name"].'" style="cursor:pointer;">Delete</a>
                        </div>
                    </td>
                    <td><button id="view_'.$data["id"].'" type="button" class="btn btn-plan view_btn">View</button></td>
                </tr>';
            }
        
        else:
            echo "Sorry! No Team is added.";

        endif;
        
    }
    catch(PDOException $e){
        echo "There is a problem in server, please try again a few moments later.";
    }
elseif($role=='2'):
    try{
        $select = "SELECT a.* FROM teams as a left join project_managers as b on b.team_id=a.id where b.reg_id=:login_id";
        $select_stmt = $conn->prepare($select);
        $select_stmt->bindValue(':login_id', htmlspecialchars(strip_tags($user_id)),PDO::PARAM_STR);
        $select_stmt->execute();

        if($select_stmt->rowCount()):
            while($data = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                $team_id = $data["id"];
                /* Getting Project Managers */
                $count_pm = "SELECT count(id) as total_pm FROM project_managers where team_id=$team_id";
                $count_pm_stmt = $conn->prepare($count_pm);
                $count_pm_stmt->execute();
                $pm_data = $count_pm_stmt->fetch(PDO::FETCH_ASSOC);
                /* Getting temamembers */
                $count_tm = "SELECT count(id) as total_tm FROM team_members where team_id=$team_id";
                $count_tm_stmt = $conn->prepare($count_tm);
                $count_tm_stmt->execute();
                $tm_data = $count_tm_stmt->fetch(PDO::FETCH_ASSOC);
                /* Getting SMB data */
                $count_smb = "SELECT count(id) as total_smb FROM devices where team_id=$team_id";
                $count_smb_stmt = $conn->prepare($count_smb);
                $count_smb_stmt->execute();
                $smb_data = $count_smb_stmt->fetch(PDO::FETCH_ASSOC);
                echo '<tr>
                    <td>'.$data["id"].'</td>
                    <td>'.$data["name"].'</td>
                    <td><button type="button" class="btn btn-sm btn-plan" id="" data-container="body" data-toggle="popover" data-trigger="hover" data-content="Click View Button to see Details">'.$pm_data["total_pm"].'</button></td>
                    <td>'.$data["contact"].'</td>
                    <td><button type="button" class="btn btn-sm btn-plan" id="" data-container="body" data-toggle="popover" data-trigger="hover" data-content="Click View Button to see Details">'.$tm_data["total_tm"].'</button></td>
                    <td><button type="button" class="btn btn-sm btn-plan" id="" data-container="body" data-toggle="popover" data-trigger="hover" data-content="Click View Button to see Details">'.$smb_data["total_smb"].'</button></td>
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
            echo "Sorry! No Team is added.";

        endif;
        
    }
    catch(PDOException $e){
        echo "There is a problem in server, please try again a few moments later.";
    }
elseif($role=='4'):
    try{
        $select = "SELECT a.* FROM teams as a left join team_members as b on b.team_id=a.id where b.reg_id=:login_id";
        $select_stmt = $conn->prepare($select);
        $select_stmt->bindValue(':login_id', htmlspecialchars(strip_tags($user_id)),PDO::PARAM_STR);
        $select_stmt->execute();

        if($select_stmt->rowCount()):
            while($data = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                $team_id = $data["id"];
                /* Getting Project Managers */
                $count_pm = "SELECT count(id) as total_pm FROM project_managers where team_id=$team_id";
                $count_pm_stmt = $conn->prepare($count_pm);
                $count_pm_stmt->execute();
                $pm_data = $count_pm_stmt->fetch(PDO::FETCH_ASSOC);
                /* Getting temamembers */
                $count_tm = "SELECT count(id) as total_tm FROM team_members where team_id=$team_id";
                $count_tm_stmt = $conn->prepare($count_tm);
                $count_tm_stmt->execute();
                $tm_data = $count_tm_stmt->fetch(PDO::FETCH_ASSOC);
                /* Getting SMB data */
                $count_smb = "SELECT count(id) as total_smb FROM devices where team_id=$team_id";
                $count_smb_stmt = $conn->prepare($count_smb);
                $count_smb_stmt->execute();
                $smb_data = $count_smb_stmt->fetch(PDO::FETCH_ASSOC);
                echo '<tr>
                    <td>'.$data["id"].'</td>
                    <td>'.$data["name"].'</td>
                    <td><button type="button" class="btn btn-sm btn-plan" id="" data-container="body" data-toggle="popover" data-trigger="hover" data-content="Click View Button to see Details">'.$pm_data["total_pm"].'</button></td>
                    <td>'.$data["contact"].'</td>
                    <td><button type="button" class="btn btn-sm btn-plan" id="" data-container="body" data-toggle="popover" data-trigger="hover" data-content="Click View Button to see Details">'.$tm_data["total_tm"].'</button></td>
                    <td><button type="button" class="btn btn-sm btn-plan" id="" data-container="body" data-toggle="popover" data-trigger="hover" data-content="Click View Button to see Details">'.$smb_data["total_smb"].'</button></td>
                    <td><button id="view_'.$data["id"].'" type="button" class="btn btn-plan view_btn">View</button></td>
                    <td></td>
                </tr>';
            }
        
        else:
            echo "Sorry! This user is not assigned to any teams.";

        endif;
        
    }
    catch(PDOException $e){
        echo "There is a problem in server, please try again a few moments later.";
    }
endif;
?>