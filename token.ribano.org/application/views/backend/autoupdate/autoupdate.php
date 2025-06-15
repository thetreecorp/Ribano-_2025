<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-body">

            <?php if ($latest_version!=$current_version) { ?>
                <?php echo form_open_multipart("backend/autoupdate/update") ?>
                    <div class="row">
                        <div class="form-group col-lg-8 col-sm-offset-2">
                            <blink class="text-success text-center auto-update-msg-txt"><?php echo html_escape(@$message_txt) ?></blink>
                            <blink class="text-waring text-center auto-update-msg-txt"><?php echo html_escape(@$exception_txt) ?></blink>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="alert alert-success text-center auto-update-version"><?php echo display('latest_version'); ?> <br>V-<?php echo html_escape($latest_version) ?></div>
                                </div> 
                                <div class="col-lg-6">
                                    <div class="alert alert-danger text-center auto-update-version"><?php echo display('current_version'); ?> <br>V-<?php echo html_escape($current_version) ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="form-group col-lg-6 col-sm-offset-3">
                            <p class="alert auto-update-warning-text">note: strongly recomanded to backup your <b>SOURCE FILE</b> and <b>DATABASE</b> before update.</p>
                            <label>Licence/Purchase key <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="purchase_key">
                        </div>
                    </div> 
                    <div>
                        <button type="submit" class="btn btn-success col-sm-offset-5" onclick="return confirm('are you sure want to update?')"><i class="fa fa-wrench" aria-hidden="true"></i> <?php echo display('update'); ?></button>
                    </div>
                <?php echo form_close() ?>

                <?php } else{  ?>
                    <div class="row">
                        <div class="form-group col-lg-4 col-sm-offset-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="alert alert-success text-center auto-update-version"><?php echo display('current_version'); ?> <br>V-<?php echo html_escape($current_version) ?></div>
                                    <h2 class="text-center"><?php echo display('no_update_available'); ?></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>