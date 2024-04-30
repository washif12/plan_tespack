<?php if ($role == '1' || $role == '0') : ?>
<select class="form-control text-white bg-plan" id="project">
    <option selected disabled>Project</option>
    <?php
    $project = "SELECT * FROM projects";
    $project_stmt = $conn->prepare($project);
    $project_stmt->execute();

    if ($project_stmt->rowCount()) :
        while ($data_project = $project_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
            <option value="<?php echo $data_project["id"]; ?>">
                <?php echo $data_project["name"]; ?></option><?php
                                                            }
                                                        else :
                                                            echo "Sorry! No Projects Found.";

                                                        endif;
                                                                ?>
</select>
<?php elseif ($role == '3') : ?>
<select class="form-control text-white bg-plan" id="project">
    <option selected disabled>Project</option>
    <?php
    $project = "SELECT * FROM projects WHERE country=:country";
    $project_stmt = $conn->prepare($project);
    $project_stmt->bindValue(':country', htmlspecialchars(strip_tags($country)),PDO::PARAM_STR);
    $project_stmt->execute();

    if ($project_stmt->rowCount()) :
        while ($data_project = $project_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
            <option value="<?php echo $data_project["id"]; ?>">
                <?php echo $data_project["name"]; ?></option><?php
                                                            }
                                                        else :
                                                            echo "Sorry! No Projects Found.";

                                                        endif;
                                                                ?>
</select>
<?php elseif ($role == '2') : ?>
<select class="form-control text-white bg-plan" id="project">
    <option selected disabled>Project</option>
    <?php
    $project = "SELECT a.* FROM projects as a left join project_managers as b on b.team_id=a.team_id where b.reg_id=:login_id";
    $project_stmt = $conn->prepare($project);
    $project_stmt->bindValue(':login_id', htmlspecialchars(strip_tags($user_id)),PDO::PARAM_STR);
    $project_stmt->execute();

    if ($project_stmt->rowCount()) :
        while ($data_project = $project_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
            <option value="<?php echo $data_project["id"]; ?>">
                <?php echo $data_project["name"]; ?></option><?php
                                                            }
                                                        else :
                                                            echo "Sorry! No Projects Found.";

                                                        endif;
                                                                ?>
</select>
<?php elseif ($role == '4') : ?>
<select class="form-control text-white bg-plan" id="project">
    <option selected disabled>Project</option>
    <?php
    $project = "SELECT a.* FROM projects as a left join team_members as b on b.team_id=a.team_id where b.reg_id=:login_id";
    $project_stmt = $conn->prepare($project);
    $project_stmt->bindValue(':login_id', htmlspecialchars(strip_tags($user_id)),PDO::PARAM_STR);
    $project_stmt->execute();

    if ($project_stmt->rowCount()) :
        while ($data_project = $project_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
            <option selected value="<?php echo $data_project["id"]; ?>">
                <?php echo $data_project["name"]; ?></option><?php
                                                            }
                                                        else :
                                                            echo "Sorry! No Projects Found.";

                                                        endif;
                                                                ?>
</select>
<?php endif; ?>