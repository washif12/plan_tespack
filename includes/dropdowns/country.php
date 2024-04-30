<?php if ($role == '3'||$role == '2'||$role == '4') : ?>
    <select class="form-control text-white bg-plan" id="country" readonly>
        <option selected disabled value="<?php echo $country; ?>"><?php echo $country; ?></option>
    </select>
<?php else : ?>
    <select class="form-control text-white bg-plan" id="country">
        <option selected disabled>Country</option>
        <?php
        $sql = "SELECT DISTINCT country FROM countries";
        $sql_stmt = $conn->prepare($sql);
        $sql_stmt->execute();

        if ($sql_stmt->rowCount()) :
            while ($data = $sql_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                <option value="<?php echo $data["country"]; ?>">
                    <?php echo $data["country"]; ?></option><?php
                                                        }
                                                    else :
                                                        echo "Sorry! No Country Found.";

                                                    endif;
                                                            ?>
    </select>
<?php endif; ?>