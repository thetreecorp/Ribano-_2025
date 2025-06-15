<div class="row">
    <div class="col-sm-12">
        <div class="email_sender_cronjob_view">
            <p>curl --request GET <?php echo base_url('backend/sms/bulk_sms_sender'); ?>
                <br> You can use above link for cron job. Copy and paste at cron job Command box.
            </p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h2><?php echo (!empty($title) ? html_escape($title) : null) ?></h2>
                </div>
            </div>
            <div class="panel-body">
                <div class="border_preview">

                    <?php echo form_open_multipart("backend/sms/sms/send_bulk_sms") ?>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">

                            <div class="row">
                                <div class="form-group col-lg-7">
                                    <label><?php echo display('selected_template'); ?> *</label>
                                    <select class="form-control" name="selected_template" required>
                                        <option value="">--<?php echo display("select_option") ?>--</option>
                                        <?php
                                        foreach ($template as $value) {
                                        ?>
                                        <option value="<?php echo html_escape($value->teamplate_id) ?>">
                                            <?php echo html_escape($value->teamplate_name) ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-lg-7">
                                    <button type="submit"
                                        class="btn btn-success"><?php echo display('send'); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>

            </div>
        </div>
    </div>
</div>