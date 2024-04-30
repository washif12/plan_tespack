<div id="proModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-plan">
                <h5 class="col-11 text-center modal-title mt-0" id="myModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-4 text-center"></div>
                    <div class="col-4 text-center">
                        <div style="margin-bottom: 10px;">
                            <img class="rounded-circle mr-2 pro-img" alt="200x200" style="width:200px;height: 200px;margin-bottom: 10px;" data-holder-rendered="true">
                            <form action="backend/others/profileUpdate.php" class="dropzone profile-img-update" style="border:none; padding:0px;text-align: center;">
                                <div class="fallback text-center">
                                    <input name="file" type="file">
                                </div>
                                <div class="dz-message needsclick" style="margin: 0px;position: relative;">
                                    <img class="dropzone-img" alt="200x200" style="width: 100%;display: block;" data-holder-rendered="true">
                                    <div class="overlay-dropzone"><i class="fa fa-edit edit-overlay text-white"></i> Change Image</div>
                                </div>
                            </form>
                        </div>
                        <div style="border-bottom: 3px solid rgb(223, 223, 223);display:inline-block;">
                            <h5 class="text-plan" id="pro-head"></h5><h5 class="text-plan"><i class="fa fa-edit pro-edit"></i></h5>
                        </div>
                    </div>
                    <div class="col-4 text-center"></div>
                    <div class="col-12">
                        <p class="text-center text-danger font-16" id="errMsgPro"></p>
                        <p class="text-center font-16" style="color:#008037;" id="msgSuccessPro"></p>
                    </div>
                    <div class="col-12 pro-view">
                        <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                            <div class="col-3"><h6 class="text-plan">Name</h6></div>
                            <div class="col-4"><h6 id="viewName"><h6></div>
                        </div>
                        <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                            <div class="col-3"><h6 class="text-plan">Email</h6></div>
                            <div class="col-4"><h6 id="viewEmail"></h6></div>
                        </div>
                        <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                            <div class="col-3"><h6 class="text-plan">Phone</h6></div>
                            <div class="col-4"><h6 id="viewPhone"></h6></div>
                        </div>
                        <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                            <div class="col-3"><h6 class="text-plan">Country</h6></div>
                            <div class="col-4"> <h6 id="viewCountry"></h6></div>
                        </div>
                        <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                            <div class="col-3"><h6 class="text-plan">Address</h6></div>
                            <div class="col-4"> <h6 id="viewAddress"></h6></div>
                        </div>
                    </div>
                    <div class="col-12 pro-form">
                    <input type="hidden" id="user_trc_details" value="<?php echo $db_connection::get_user_track_details()?>">
                    <input type="hidden" value="<?php echo $token_data->data->user_id;?>" id="data-id">
                    <input type="hidden" value="<?php echo $token_data->data->name;?>" id="data-name">
                        <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                            <div class="col-3"><h6 class="text-plan">First Name</h6></div>
                            <div class="col-6">
                                <input class="form-control" id="proFName" required>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                            <div class="col-3"><h6 class="text-plan">Last Name</h6></div>
                            <div class="col-6">
                                <input class="form-control" id="proLName" required>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                            <div class="col-3"><h6 class="text-plan">Email</h6></div>
                            <div class="col-6">
                                <input class="form-control" id="proEmail" readonly>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                            <div class="col-3"><h6 class="text-plan">Phone</h6></div>
                            <div class="col-6">
                                <input class="form-control" id="proPhone" required>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                            <div class="col-3"><h6 class="text-plan">Country</h6></div>
                            <div class="col-6">
                                <input class="form-control" id="proCountry" readonly>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                            <div class="col-3"><h6 class="text-plan">Address</h6></div>
                            <div class="col-6">
                                <textarea class="form-control" id="proAddress" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer pro-footer">
                <button type="button" class="btn btn-secondary pro-cancel">Cancel</button>
                <button type="button" class="btn btn-primary pro_btn">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>