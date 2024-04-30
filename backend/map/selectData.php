<?php
require __DIR__.'/../../assets/api/classes/database.php';
$db_connection = new Database();
$conn = $db_connection->dbConnection();

function msg($success,$status,$message,$extra = []){
    return array_merge([
        'success' => $success,
        'status' => $status,
        'message' => $message
    ],$extra);
}
$returnData = [];
$projects = [];
$managers = [];
$countries = [];

$country = $_POST['country'];
$project = $_POST['project'];
$pro_manager = $_POST['pro_manager'];

if(!empty($country) && empty($project) && empty($pro_manager)):
    try{
        $check = "SELECT * FROM projects WHERE country=:country";
        $check_stmt = $conn->prepare($check);
        $check_stmt->bindValue(':country', htmlspecialchars(strip_tags($country)),PDO::PARAM_STR);
        $check_stmt->execute();
        if($check_stmt->rowCount()):
            foreach($data_pro = $check_stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                array_push($projects,$row);
            }
        else:
            $projects = [];
    
        endif;
        $pm = "SELECT * FROM users WHERE country=:country AND role=2";
        $pm_stmt = $conn->prepare($pm);
        $pm_stmt->bindValue(':country', htmlspecialchars(strip_tags($country)),PDO::PARAM_STR);
        $pm_stmt->execute();
        if($pm_stmt->rowCount()):
            foreach($data_pm = $pm_stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                array_push($managers,$row);
            }
        else:
            $managers = [];
    
        endif;

        $count_smb = "SELECT count(id) as total_smb FROM devices where country=:country";
        $count_smb_stmt = $conn->prepare($count_smb);
        $count_smb_stmt->bindValue(':country', htmlspecialchars(strip_tags($country)),PDO::PARAM_STR);
        $count_smb_stmt->execute();
        $smb_data = $count_smb_stmt->fetch(PDO::FETCH_ASSOC);

        $values = ['projects' => $projects, 'pm' => $managers, 'smb' => $smb_data['total_smb']];
        $returnData = msg(1,201,'Data Received',$values);
    }
    catch(PDOException $e){
        $returnData = msg(0,500,$e->getMessage());
    }
elseif(empty($country) && !empty($project) && empty($pro_manager)):
    try{
        $check = "SELECT * FROM projects WHERE id=:id";
        $check_stmt = $conn->prepare($check);
        $check_stmt->bindValue(':id', htmlspecialchars(strip_tags($project)),PDO::PARAM_STR);
        $check_stmt->execute();
        if($check_stmt->rowCount()):
            $data = $check_stmt->fetch(PDO::FETCH_ASSOC);
            $team_id = $data["team_id"];
            array_push($countries,$data);
        else:
            $countries = [];
        endif;
        $pm = "SELECT a.* FROM users as a left join project_managers as b on b.reg_id=a.id left join teams as c on c.id=b.team_id where c.id=(SELECT team_id FROM projects where id=:project)";
        $pm_stmt = $conn->prepare($pm);
        $pm_stmt->bindValue(':project', htmlspecialchars(strip_tags($project)),PDO::PARAM_STR);
        $pm_stmt->execute();
        if($pm_stmt->rowCount()):
            foreach($data_pm = $pm_stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                array_push($managers,$row);
            }
        else:
            $managers = [];
    
        endif;

        if($team_id==null):
            $values = ['countries' => $countries, 'pm' => $managers, 'smb' => '0'];
        else:
            $count_smb = "SELECT count(id) as total_smb FROM devices where team_id=:team_id";
            $count_smb_stmt = $conn->prepare($count_smb);
            $count_smb_stmt->bindValue(':team_id', htmlspecialchars(strip_tags($team_id)),PDO::PARAM_STR);
            $count_smb_stmt->execute();
            $smb_data = $count_smb_stmt->fetch(PDO::FETCH_ASSOC);

            $values = ['countries' => $countries, 'pm' => $managers, 'smb' => $smb_data['total_smb']];
        endif;
        $returnData = msg(2,201,'Data Received',$values);
    }
    catch(PDOException $e){
        $returnData = msg(0,500,$e->getMessage());
    }
elseif(empty($country) && empty($project) && !empty($pro_manager)):
    $smb_total=0;
    try{
        $check = "SELECT * FROM users WHERE id=:id";
        $check_stmt = $conn->prepare($check);
        $check_stmt->bindValue(':id', htmlspecialchars(strip_tags($pro_manager)),PDO::PARAM_STR);
        $check_stmt->execute();
        if($check_stmt->rowCount()):
            $data = $check_stmt->fetch(PDO::FETCH_ASSOC);
            array_push($countries,$data);
        else:
            $countries = [];
        endif;
        //$project = "SELECT a.id, a.name FROM projects as a left join team_pm as b on b.team_id=a.team_id left join project_managers as c on c.id=b.pm_id where c.reg_id=:id";
        $project = "SELECT a.* FROM projects as a left join project_managers as b on b.team_id=a.team_id where b.reg_id=:id";
        $project_stmt = $conn->prepare($project);
        $project_stmt->bindValue(':id', htmlspecialchars(strip_tags($pro_manager)),PDO::PARAM_STR);
        $project_stmt->execute();
        if($project_stmt->rowCount()):
            foreach($data_project = $project_stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                array_push($projects,$row);
                $count_smb = "SELECT count(id) as total_smb FROM devices where team_id=:team_id";
                $count_smb_stmt = $conn->prepare($count_smb);
                $count_smb_stmt->bindValue(':team_id', htmlspecialchars(strip_tags($row['team_id'])),PDO::PARAM_STR);
                $count_smb_stmt->execute();
                $smb_data = $count_smb_stmt->fetch(PDO::FETCH_ASSOC);
                $smb_total+= $smb_data['total_smb'];
            }
        else:
            $projects = [];
            $smb_total = 0;
        endif;

        $values = ['countries' => $countries, 'projects' => $projects, 'smb' => $smb_total];
        $returnData = msg(3,201,'Data Received',$values);
    }
    catch(PDOException $e){
        $returnData = msg(0,500,$e->getMessage());
    }
elseif(!empty($country) && !empty($project) && empty($pro_manager)):
    try{
        $check = "SELECT * FROM projects WHERE country=:country";
        $check_stmt = $conn->prepare($check);
        $check_stmt->bindValue(':country', htmlspecialchars(strip_tags($country)),PDO::PARAM_STR);
        $check_stmt->execute();
        if($check_stmt->rowCount()):
            foreach($data_pro = $check_stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                array_push($projects,$row);
            }
        else:
            $projects = [];
        endif;

        $check = "SELECT * FROM projects WHERE id=:id";
        $check_stmt = $conn->prepare($check);
        $check_stmt->bindValue(':id', htmlspecialchars(strip_tags($project)),PDO::PARAM_STR);
        $check_stmt->execute();
        if($check_stmt->rowCount()):
            $data = $check_stmt->fetch(PDO::FETCH_ASSOC);
            $team_id = $data["team_id"];
            array_push($countries,$data);
        else:
            $countries = [];
        endif;
            
        $check = "SELECT * FROM projects WHERE id=:id";
        $check_stmt = $conn->prepare($check);
        $check_stmt->bindValue(':id', htmlspecialchars(strip_tags($project)),PDO::PARAM_STR);
        $check_stmt->execute();
        if($check_stmt->rowCount()):
            $data = $check_stmt->fetch(PDO::FETCH_ASSOC);
            $team_id = $data["team_id"];
        endif;
        $pm = "SELECT a.* FROM users as a left join project_managers as b on b.reg_id=a.id left join teams as c on c.id=b.team_id where a.country=:country AND c.id=(SELECT team_id FROM projects where id=:project)";
        $pm_stmt = $conn->prepare($pm);
        $pm_stmt->bindValue(':project', htmlspecialchars(strip_tags($project)),PDO::PARAM_STR);
        $pm_stmt->bindValue(':country', htmlspecialchars(strip_tags($country)),PDO::PARAM_STR);
        $pm_stmt->execute();
        if($pm_stmt->rowCount()):
            foreach($data_pm = $pm_stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                array_push($managers,$row);
            }
        else:
            $managers = [];
    
        endif;

        $count_smb = "SELECT count(id) as total_smb FROM devices where team_id=:team_id AND country=:country";
        $count_smb_stmt = $conn->prepare($count_smb);
        $count_smb_stmt->bindValue(':team_id', htmlspecialchars(strip_tags($team_id)),PDO::PARAM_STR);
        $count_smb_stmt->bindValue(':country', htmlspecialchars(strip_tags($country)),PDO::PARAM_STR);
        $count_smb_stmt->execute();
        $smb_data = $count_smb_stmt->fetch(PDO::FETCH_ASSOC);

        $values = ['countries' => $countries, 'projects' => $projects, 'pm' => $managers, 'smb' => $smb_data['total_smb']];

        $returnData = msg(4,201,'Data Received',$values);
    }
    catch(PDOException $e){
        $returnData = msg(0,500,$e->getMessage());
    }
elseif(!empty($country) && empty($project) && !empty($pro_manager)):
    $smb_total=0;
    try{
        $pm = "SELECT * FROM users WHERE country=:country AND role=2";
        $pm_stmt = $conn->prepare($pm);
        $pm_stmt->bindValue(':country', htmlspecialchars(strip_tags($country)),PDO::PARAM_STR);
        $pm_stmt->execute();
        if($pm_stmt->rowCount()):
            foreach($data_pm = $pm_stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                array_push($managers,$row);
            }
        else:
            $managers = [];
        endif;
        $check = "SELECT * FROM users WHERE id=:id";
        $check_stmt = $conn->prepare($check);
        $check_stmt->bindValue(':id', htmlspecialchars(strip_tags($pro_manager)),PDO::PARAM_STR);
        $check_stmt->execute();
        if($check_stmt->rowCount()):
            $data = $check_stmt->fetch(PDO::FETCH_ASSOC);
            array_push($countries,$data);
        else:
            $countries = [];
        endif;
        //$project = "SELECT a.id, a.name FROM projects as a left join team_pm as b on b.team_id=a.team_id left join project_managers as c on c.id=b.pm_id where c.reg_id=:id";
        $project = "SELECT a.* FROM projects as a left join project_managers as b on b.team_id=a.team_id where b.reg_id=:id AND a.country=:country";
        $project_stmt = $conn->prepare($project);
        $project_stmt->bindValue(':id', htmlspecialchars(strip_tags($pro_manager)),PDO::PARAM_STR);
        $project_stmt->bindValue(':country', htmlspecialchars(strip_tags($country)),PDO::PARAM_STR);
        $project_stmt->execute();
        if($project_stmt->rowCount()):
            foreach($data_project = $project_stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                array_push($projects,$row);
                $count_smb = "SELECT count(id) as total_smb FROM devices where team_id=:team_id";
                $count_smb_stmt = $conn->prepare($count_smb);
                $count_smb_stmt->bindValue(':team_id', htmlspecialchars(strip_tags($row['team_id'])),PDO::PARAM_STR);
                $count_smb_stmt->execute();
                $smb_data = $count_smb_stmt->fetch(PDO::FETCH_ASSOC);
                $smb_total+= $smb_data['total_smb'];
            }
        else:
            $projects = [];
            $smb_total = 0;
        endif;

        $values = ['countries' => $countries, 'projects' => $projects, 'pm' => $managers, 'smb' => $smb_total];
        $returnData = msg(5,201,'Data Received',$values);
    }
    catch(PDOException $e){
        $returnData = msg(0,500,$e->getMessage());
    }
elseif(empty($country) && !empty($project) && !empty($pro_manager)):
    $smb_total=0;
    try{
        $check = "SELECT * FROM projects WHERE id=:id";
        $check_stmt = $conn->prepare($check);
        $check_stmt->bindValue(':id', htmlspecialchars(strip_tags($project)),PDO::PARAM_STR);
        $check_stmt->execute();
        if($check_stmt->rowCount()):
            $data = $check_stmt->fetch(PDO::FETCH_ASSOC);
            array_push($countries,$data);
        else:
            $countries = [];
        endif;
        $pm = "SELECT a.* FROM users as a left join project_managers as b on b.reg_id=a.id left join teams as c on c.id=b.team_id where c.id=(SELECT team_id FROM projects where id=:project)";
        $pm_stmt = $conn->prepare($pm);
        $pm_stmt->bindValue(':project', htmlspecialchars(strip_tags($project)),PDO::PARAM_STR);
        $pm_stmt->execute();
        if($pm_stmt->rowCount()):
            foreach($data_pm = $pm_stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                array_push($managers,$row);
            }
        else:
            $managers = [];
        endif;
        $project = "SELECT a.* FROM projects as a left join project_managers as b on b.team_id=a.team_id where b.reg_id=:id";
        $project_stmt = $conn->prepare($project);
        $project_stmt->bindValue(':id', htmlspecialchars(strip_tags($pro_manager)),PDO::PARAM_STR);
        $project_stmt->execute();
        if($project_stmt->rowCount()):
            foreach($data_project = $project_stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                array_push($projects,$row);
                $count_smb = "SELECT count(id) as total_smb FROM devices where team_id=:team_id";
                $count_smb_stmt = $conn->prepare($count_smb);
                $count_smb_stmt->bindValue(':team_id', htmlspecialchars(strip_tags($row['team_id'])),PDO::PARAM_STR);
                $count_smb_stmt->execute();
                $smb_data = $count_smb_stmt->fetch(PDO::FETCH_ASSOC);
                $smb_total+= $smb_data['total_smb'];
            }
        else:
            $projects = [];
            $smb_total = 0;
        endif;

        $values = ['countries' => $countries, 'projects' => $projects, 'pm' => $managers, 'smb' => $smb_total];
        $returnData = msg(6,201,'Data Received',$values);
    }
    catch(PDOException $e){
        $returnData = msg(0,500,$e->getMessage());
    }
endif;






/*if(isset($_POST['type']) && isset($_POST['value'])):
    $type = $_POST['type'];
    $val = $_POST['value'];
    if($type == 'country'):
        try{
            $check = "SELECT * FROM projects WHERE country=:country";
            $check_stmt = $conn->prepare($check);
            $check_stmt->bindValue(':country', htmlspecialchars(strip_tags($val)),PDO::PARAM_STR);
            $check_stmt->execute();
            if($check_stmt->rowCount()):
                foreach($data_pro = $check_stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                    array_push($projects,$row);
                }
            else:
                $projects = [];
        
            endif;
            $pm = "SELECT * FROM users WHERE country=:country AND role=2";
            $pm_stmt = $conn->prepare($pm);
            $pm_stmt->bindValue(':country', htmlspecialchars(strip_tags($val)),PDO::PARAM_STR);
            $pm_stmt->execute();
            if($pm_stmt->rowCount()):
                foreach($data_pm = $pm_stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                    array_push($managers,$row);
                }
            else:
                $managers = [];
        
            endif;

            $count_smb = "SELECT count(id) as total_smb FROM devices where country=:country";
            $count_smb_stmt = $conn->prepare($count_smb);
            $count_smb_stmt->bindValue(':country', htmlspecialchars(strip_tags($val)),PDO::PARAM_STR);
            $count_smb_stmt->execute();
            $smb_data = $count_smb_stmt->fetch(PDO::FETCH_ASSOC);

            $values = ['projects' => $projects, 'pm' => $managers, 'smb' => $smb_data['total_smb']];
            $returnData = msg(1,201,'Data Received',$values);
        }
        catch(PDOException $e){
            $returnData = msg(0,500,$e->getMessage());
        }
    elseif($type == 'project'):
        try{
            $check = "SELECT * FROM projects WHERE id=:id";
            $check_stmt = $conn->prepare($check);
            $check_stmt->bindValue(':id', htmlspecialchars(strip_tags($val)),PDO::PARAM_STR);
            $check_stmt->execute();
            if($check_stmt->rowCount()):
                $data = $check_stmt->fetch(PDO::FETCH_ASSOC);
                $team_id = $data["team_id"];
                array_push($countries,$data);
            else:
                $countries = [];
            endif;
            $pm = "SELECT * FROM users as a left join project_managers as b on b.reg_id=a.id left join team_pm as c on c.pm_id=b.id left join teams as d on d.id=c.team_id where d.id=(SELECT team_id FROM projects where id=:project)";
            $pm_stmt = $conn->prepare($pm);
            $pm_stmt->bindValue(':project', htmlspecialchars(strip_tags($val)),PDO::PARAM_STR);
            $pm_stmt->execute();
            if($pm_stmt->rowCount()):
                foreach($data_pm = $pm_stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                    array_push($managers,$row);
                }
            else:
                $managers = [];
        
            endif;

            if($team_id==null):
                $values = ['countries' => $countries, 'pm' => $managers, 'smb' => '0'];
            else:
                $count_smb = "SELECT count(id) as total_smb FROM devices where team_id=:team_id";
                $count_smb_stmt = $conn->prepare($count_smb);
                $count_smb_stmt->bindValue(':team_id', htmlspecialchars(strip_tags($team_id)),PDO::PARAM_STR);
                $count_smb_stmt->execute();
                $smb_data = $count_smb_stmt->fetch(PDO::FETCH_ASSOC);
    
                $values = ['countries' => $countries, 'pm' => $managers, 'smb' => $smb_data['total_smb']];
            endif;
            $returnData = msg(2,201,'Data Received',$values);
        }
        catch(PDOException $e){
            $returnData = msg(0,500,$e->getMessage());
        }
    elseif($type == 'pro_manager'):
        try{
            $check = "SELECT * FROM users WHERE id=:id";
            $check_stmt = $conn->prepare($check);
            $check_stmt->bindValue(':id', htmlspecialchars(strip_tags($val)),PDO::PARAM_STR);
            $check_stmt->execute();
            if($check_stmt->rowCount()):
                $data = $check_stmt->fetch(PDO::FETCH_ASSOC);
                array_push($countries,$data);
            else:
                $countries = [];
            endif;
            //$project = "SELECT a.id, a.name FROM projects as a left join team_pm as b on b.team_id=a.team_id left join project_managers as c on c.id=b.pm_id where c.reg_id=:id";
            $project = "SELECT a.id, a.name FROM projects as a left join project_managers as b on b.team_id=a.team_id where b.reg_id=:id";
            $project_stmt = $conn->prepare($project);
            $project_stmt->bindValue(':id', htmlspecialchars(strip_tags($val)),PDO::PARAM_STR);
            $project_stmt->execute();
            if($project_stmt->rowCount()):
                foreach($data_project = $project_stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                    array_push($projects,$row);
                }
            else:
                $projects = [];
        
            endif;

            $values = ['countries' => $countries, 'projects' => $projects];
            $returnData = msg(3,201,'Data Received',$values);
        }
        catch(PDOException $e){
            $returnData = msg(0,500,$e->getMessage());
        }
    endif;
endif;*/

echo json_encode($returnData);
?>