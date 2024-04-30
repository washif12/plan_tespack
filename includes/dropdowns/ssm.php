<?php if ($role == '1' || $role == '0') : ?>
<select class="form-control text-white bg-plan" id="ssm_device">
    <option selected disabled>SSM</option>
    <?php
    $ssm = "SELECT * FROM devices";
    $ssm_stmt = $conn->prepare($ssm);
    $ssm_stmt->execute();

    if ($ssm_stmt->rowCount()) :
        while ($data_ssm = $ssm_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
            <option value="<?php echo $data_ssm["ssm_id"]; ?>">
                <?php echo $data_ssm["ref"]; ?></option><?php
                                                    }
                                                else :
                                                    echo "Sorry! SSM Found.";

                                                endif;
                                                        ?>
</select>
<?php elseif ($role == '3') : ?>
<select class="form-control text-white bg-plan" id="ssm_device">
    <option selected disabled>SSM</option>
    <?php
    $ssm = "SELECT * FROM devices WHERE country=:country";
    $ssm_stmt = $conn->prepare($ssm);
    $ssm_stmt->bindValue(':country', htmlspecialchars(strip_tags($country)),PDO::PARAM_STR);
    $ssm_stmt->execute();

    if ($ssm_stmt->rowCount()) :
        while ($data_ssm = $ssm_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
            <option value="<?php echo $data_ssm["ssm_id"]; ?>">
                <?php echo $data_ssm["ref"]; ?></option><?php
                                                    }
                                                else :
                                                    echo "Sorry! No SSM Found.";

                                                endif;
                                                        ?>
</select>
<?php elseif ($role == '2') : ?>
<select class="form-control text-white bg-plan" id="ssm_device">
    <option selected disabled>SSM</option>
    <?php
    $ssm = "SELECT a.* FROM devices as a left join project_managers as b on a.team_id=b.team_id WHERE b.reg_id=:login_id";
    $ssm_stmt = $conn->prepare($ssm);
    $ssm_stmt->bindValue(':login_id', htmlspecialchars(strip_tags($user_id)),PDO::PARAM_STR);
    $ssm_stmt->execute();

    if ($ssm_stmt->rowCount()) :
        while ($data_ssm = $ssm_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
            <option value="<?php echo $data_ssm["ssm_id"]; ?>">
                <?php echo $data_ssm["ref"]; ?></option><?php
                                                    }
                                                else :
                                                    echo "Sorry! No SSM Found.";

                                                endif;
                                                        ?>
</select>
<?php elseif ($role == '4') : ?>
<select class="form-control text-white bg-plan" id="ssm_device">
    <option selected disabled>SSM</option>
    <?php
    $ssm = "SELECT a.* FROM devices as a left join team_members as b on a.team_id=b.team_id WHERE b.reg_id=:login_id";
    $ssm_stmt = $conn->prepare($ssm);
    $ssm_stmt->bindValue(':login_id', htmlspecialchars(strip_tags($user_id)),PDO::PARAM_STR);
    $ssm_stmt->execute();

    if ($ssm_stmt->rowCount()) :
        while ($data_ssm = $ssm_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
            <option value="<?php echo $data_ssm["ssm_id"]; ?>">
                <?php echo $data_ssm["ref"]; ?></option><?php
                                                    }
                                                else :
                                                    echo "Sorry! No SSM Found.";

                                                endif;
                                                        ?>
</select>
<?php endif; ?>