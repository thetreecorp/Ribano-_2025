<div class="row">
    <div class="col-sm-12">
        <div class="email_sender_cronjob_view">
            <p>curl --request GET <?php echo base_url('backend/email/bulk_email_sender'); ?>
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

                <?php echo form_open_multipart("backend/email/email/send_bulk_email") ?>

                <div class="row">
                    <div class="col-md-10 col-md-offset-1">

                        <div class="row">
                            <div class="form-group col-lg-7">
                                <label><?php echo display('subject'); ?> *</label>
                                <input type="text" class="form-control" name="mail_subject" required="required" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-7">
                                <label><?php echo display('selected_template'); ?> *</label>
                                <select class="form-control" name="selected_template" required>
                                    <option value="">--<?php echo display("select_option") ?>--</option>
                                    <?php
                                    foreach ($template as $value) {
                                    ?>
                                    <option value="<?php echo html_escape($value->email_temp_id) ?>">
                                        <?php echo html_escape($value->tem_title) ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-7">
                                <button type="submit" class="btn btn-success"><?php echo display('send'); ?></button>
                            </div>
                        </div>
                        <?php echo form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>