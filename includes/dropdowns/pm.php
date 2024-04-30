<?php if ($role == '1' || $role == '0') : ?>
<select class="form-control text-white bg-plan" id="pro_manager">
    <option selected disabled>Team Leader</option>
    <?php
    $pm = "SELECT * FROM project_managers";
    $pm_stmt = $conn->prepare($pm);
    $pm_stmt->execute();

    if ($pm_stmt->rowCount()) :
        while ($data_pm = $pm_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
            <option value="<?php echo $data_pm["id"]; ?>">
                <?php echo $data_pm["name"]; ?></option><?php
                                                    }
                                                else :
                                                    echo "Sorry! No Team Leaders Found.";

                                                endif;
                                                        ?>
</select>
<?php elseif ($role == '2') : ?>
<select class="form-control text-white bg-plan" id="pro_manager">
    <!-- <option selected disabled>Team Leader</option> -->
    <?php
    $pm = "SELECT * FROM project_managers WHERE reg_id=:login_id";
    $pm_stmt = $conn->prepare($pm);
    $pm_stmt->bindValue(':login_id', htmlspecialchars(strip_tags($user_id)),PDO::PARAM_STR);
    $pm_stmt->execute();

    if ($pm_stmt->rowCount()) :
        while ($data_pm = $pm_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
            <option value="<?php echo $data_pm["id"]; ?>">
                <?php echo $data_pm["name"]; ?></option><?php
                }
            else: ?> <option selected disabled>Team Leader</option>
            <?php endif;?>
</select>
<?php elseif ($role == '3') : ?>
<select class="form-control text-white bg-plan" id="pro_manager">
    <option selected disabled>Team Leader</option>
    <?php
    $pm = "SELECT a.* FROM project_managers as a left join users as b on b.id=a.reg_id WHERE b.country=:country";
    $pm_stmt = $conn->prepare($pm);
    $pm_stmt->bindValue(':country', htmlspecialchars(strip_tags($country)),PDO::PARAM_STR);
    $pm_stmt->execute();

    if ($pm_stmt->rowCount()) :
        while ($data_pm = $pm_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
            <option value="<?php echo $data_pm["id"]; ?>">
                <?php echo $data_pm["name"]; ?></option><?php
                                                    }
                                                else :
                                                    echo "Sorry! No Team Leaders Found.";

                                                endif;
                                                        ?>
</select>
<?php elseif ($role == '4') : ?>
<select class="form-control text-white bg-plan" id="pro_manager">
    <option selected disabled>Team Leader</option>
    <?php
    $pm = "SELECT a.* FROM project_managers as a left join team_members as b on b.team_id=a.team_id WHERE b.reg_id=:login_id";
    $pm_stmt = $conn->prepare($pm);
    $pm_stmt->bindValue(':login_id', htmlspecialchars(strip_tags($user_id)),PDO::PARAM_STR);
    $pm_stmt->execute();

    if ($pm_stmt->rowCount()) :
        while ($data_pm = $pm_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
            <option value="<?php echo $data_pm["id"]; ?>">
                <?php echo $data_pm["name"]; ?></option><?php
                                                    }
                                                else :
                                                    echo "Sorry! No Team Leaders Found.";

                                                endif;
                                                        ?>
</select>
<?php endif; ?>