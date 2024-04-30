<div id="logoutModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-plan">
                <h5 class="col-11 text-center modal-title mt-0" id="myModalLabel"><i class="dripicons-exit text-white"></i>&nbsp; Logout</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <h6>Are you sure you want to logout?</h6>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-plan waves-effect" data-dismiss="modal">Cancel</button>
                <form method="post" action="backend/logout.php">
                    <input type="text" class="form-control" id="id" name="id" style="display:none;" value='<?php echo $user_id; ?>'>
                    <input type="hidden" id="user_trc_details"  name="user_trc_details" value="<?php echo $db_connection::get_user_track_details()?>">
                    <input type="hidden" value="<?php echo $token_data->data->name; ?>" id="data-name">

                    <input type="hidden" value="<?php echo $token_data->data->user_id;?>" id="data-id">
                    <button name="submit" class="btn btn-danger">Logout</button>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>