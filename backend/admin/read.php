<?php
try{
    $select = "SELECT * FROM users WHERE id!=:userId";
    $select_stmt = $conn->prepare($select);
    $select_stmt->bindValue(':userId', htmlspecialchars(strip_tags($user_id)),PDO::PARAM_STR);
    $select_stmt->execute();

    if($select_stmt->rowCount()):
        while($data = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
            if($data['verified']=='1'):
                if($data['role']=='1'):
                    echo '<tr>
                        <td>'.$data["id"].'</td>
                        <td>'.$data["fname"].' '.$data["lname"].'</td>
                        <td>'.$data["email"].'</td>
                        <td>Global Admin</td>
                        <td><span class="badge badge-success">Active</span></td>
                        <td>'.$data["phone"].'</td>
                        <td>'.$data["country"].'</td>
                        <td>'.$data["address"].'</td>
                        <td><a id="edit_'.$data["id"].'" type="button" class="btn btn-plan edit_modal text-white">Edit</a></td>
                        <td><a id="del_'.$data["id"].'" name="'.$data["fname"].' '.$data["lname"].'" type="button" class="btn btn-plan del_modal text-white">Delete</a></td>
                        <td><a id="reset_'.$data["id"].'" type="button" class="btn btn-plan reset_modal text-white">Reset Password</a></td>
                        <td><a id="activate_'.$data["id"].'" type="button" class="btn btn-danger deactivate_modal text-white">Deactivate</a></td>
                    </tr>';
                elseif($data['role']=='2'):
                    echo '<tr>
                        <td>'.$data["id"].'</td>
                        <td>'.$data["fname"].' '.$data["lname"].'</td>
                        <td>'.$data["email"].'</td>
                        <td>Project Admin</td>
                        <td><span class="badge badge-success">Active</span></td>
                        <td>'.$data["phone"].'</td>
                        <td>'.$data["country"].'</td>
                        <td>'.$data["address"].'</td>
                        <td><a id="edit_'.$data["id"].'" type="button" class="btn btn-plan edit_modal text-white">Edit</a></td>
                        <td><a id="del_'.$data["id"].'" name="'.$data["fname"].' '.$data["lname"].'" type="button" class="btn btn-plan del_modal text-white">Delete</a></td>
                        <td><a id="reset_'.$data["id"].'" type="button" class="btn btn-plan reset_modal text-white">Reset Password</a></td>
                        <td><a id="activate_'.$data["id"].'" type="button" class="btn btn-danger deactivate_modal text-white">Deactivate</a></td>
                    </tr>';
                elseif($data['role']=='3'):
                    echo '<tr>
                        <td>'.$data["id"].'</td>
                        <td>'.$data["fname"].' '.$data["lname"].'</td>
                        <td>'.$data["email"].'</td>
                        <td>Country Admin</td>
                        <td><span class="badge badge-success">Active</span></td>
                        <td>'.$data["phone"].'</td>
                        <td>'.$data["country"].'</td>
                        <td>'.$data["address"].'</td>
                        <td><a id="edit_'.$data["id"].'"  type="button" class="btn btn-plan edit_modal text-white">Edit</a></td>
                        <td><a id="del_'.$data["id"].'" name="'.$data["fname"].' '.$data["lname"].'" type="button" class="btn btn-plan del_modal text-white">Delete</a></td>
                        <td><a id="reset_'.$data["id"].'" type="button" class="btn btn-plan reset_modal text-white">Reset Password</a></td>
                        <td><a id="activate_'.$data["id"].'" type="button" class="btn btn-danger deactivate_modal text-white">Deactivate</a></td>
                    </tr>';
                elseif($data['role']=='4'):
                    echo '<tr>
                        <td>'.$data["id"].'</td>
                        <td>'.$data["fname"].' '.$data["lname"].'</td> 
                        <td>'.$data["email"].'</td>
                        <td>Team Member</td>
                        <td><span class="badge badge-success">Active</span></td>
                        <td>'.$data["phone"].'</td>
                        <td>'.$data["country"].'</td>
                        <td>'.$data["address"].'</td>
                        <td><a id="edit_'.$data["id"].'" type="button" class="btn btn-plan edit_modal text-white">Edit</a></td>
                        <td><a id="del_'.$data["id"].'" name="'.$data["fname"].' '.$data["lname"].'" type="button" class="btn btn-plan del_modal text-white">Delete</a></td>
                        <td><a id="reset_'.$data["id"].'" type="button" class="btn btn-plan reset_modal text-white">Reset Password</a></td>
                        <td><a id="activate_'.$data["id"].'" type="button" class="btn btn-danger deactivate_modal text-white">Deactivate</a></td>
                    </tr>';
                endif;
            elseif($data['verified']=='0'):
                if($data['role']=='1'):
                    echo '<tr>
                        <td>'.$data["id"].'</td>
                        <td>'.$data["fname"].' '.$data["lname"].'</td>
                        <td>'.$data["email"].'</td>
                        <td>Global Admin</td>
                        <td><span class="badge badge-danger">Not Active</span></td>
                        <td>'.$data["phone"].'</td>
                        <td>'.$data["country"].'</td>
                        <td>'.$data["address"].'</td>
                        <td><a id="edit_'.$data["id"].'" type="button" class="btn btn-plan edit_modal text-white">Edit</a></td>
                        <td><a id="del_'.$data["id"].'" name="'.$data["fname"].' '.$data["lname"].'" type="button" class="btn btn-plan del_modal text-white">Delete</a></td>
                        <td><a id="reset_'.$data["id"].'" type="button" class="btn btn-plan reset_modal text-white">Reset Password</a></td>
                        <td><a id="activate_'.$data["id"].'" type="button" class="btn btn-success activate_modal text-white">Activate</a></td>
                    </tr>';
                elseif($data['role']=='2'):
                    echo '<tr>
                        <td>'.$data["id"].'</td>
                        <td>'.$data["fname"].' '.$data["lname"].'</td>
                        <td>'.$data["email"].'</td>
                        <td>Project Admin</td>
                        <td><span class="badge badge-danger">Not Active</span></td>
                        <td>'.$data["phone"].'</td>
                        <td>'.$data["country"].'</td>
                        <td>'.$data["address"].'</td>
                        <td><a id="edit_'.$data["id"].'" type="button" class="btn btn-plan edit_modal text-white">Edit</a></td>
                        <td><a id="del_'.$data["id"].'" name="'.$data["fname"].' '.$data["lname"].'" type="button" class="btn btn-plan del_modal text-white">Delete</a></td>
                        <td><a id="reset_'.$data["id"].'" type="button" class="btn btn-plan reset_modal text-white">Reset Password</a></td>
                        <td><a id="activate_'.$data["id"].'" type="button" class="btn btn-success activate_modal text-white">Activate</a></td>
                    </tr>';
                elseif($data['role']=='3'):
                    echo '<tr>
                        <td>'.$data["id"].'</td>
                        <td>'.$data["fname"].' '.$data["lname"].'</td>
                        <td>'.$data["email"].'</td>
                        <td>Country Admin</td>
                        <td><span class="badge badge-danger">Not Active</span></td>
                        <td>'.$data["phone"].'</td>
                        <td>'.$data["country"].'</td>
                        <td>'.$data["address"].'</td>
                        <td><a id="edit_'.$data["id"].'"  type="button" class="btn btn-plan edit_modal text-white">Edit</a></td>
                        <td><a id="del_'.$data["id"].'" name="'.$data["fname"].' '.$data["lname"].'" type="button" class="btn btn-plan del_modal text-white">Delete</a></td>
                        <td><a id="reset_'.$data["id"].'" type="button" class="btn btn-plan reset_modal text-white">Reset Password</a></td>
                        <td><a id="activate_'.$data["id"].'" type="button" class="btn btn-success activate_modal text-white">Activate</a></td>
                    </tr>';
                elseif($data['role']=='4'):
                    echo '<tr>
                        <td>'.$data["id"].'</td>
                        <td>'.$data["fname"].' '.$data["lname"].'</td>
                        <td>'.$data["email"].'</td>
                        <td>Team Member</td>
                        <td><span class="badge badge-danger">Not Active</span></td>
                        <td>'.$data["phone"].'</td>
                        <td>'.$data["country"].'</td>
                        <td>'.$data["address"].'</td>
                        <td><a id="edit_'.$data["id"].'" type="button" class="btn btn-plan edit_modal text-white">Edit</a></td>
                        <td><a id="del_'.$data["id"].'" name="'.$data["fname"].' '.$data["lname"].'" type="button" class="btn btn-plan del_modal text-white">Delete</a></td>
                        <td><a id="reset_'.$data["id"].'" type="button" class="btn btn-plan reset_modal text-white">Reset Password</a></td>
                        <td><a id="activate_'.$data["id"].'" type="button" class="btn btn-success activate_modal text-white">Activate</a></td>
                    </tr>';
                endif;
            endif;
        }
    
    else:
        echo "Sorry! No User is added.";

    endif;
    
}
catch(PDOException $e){
    echo "There is a problem in server, please try again a few moments later.";
}
?>