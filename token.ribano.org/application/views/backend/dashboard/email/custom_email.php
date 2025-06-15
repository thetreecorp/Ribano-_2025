<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h2><?php echo (!empty($title)?html_escape($title):null) ?></h2>
                </div>
            </div>
            
            <div class="panel-body">

                <?php 
                echo form_open_multipart("backend/email/email/send_custom_email") ?>
                
                    <div class="row">

                        <div class="form-group col-lg-12">
                            <label><?php echo display('receiver_email'); ?> *</label>
                            <input type="email" class="form-control" placeholder="<?php echo display('receiver_email'); ?>" name="receiver_email" required="required">
                        </div>

                    </div>
                    <div class="row">

                        <div class="form-group col-lg-12">
                            <label><?php echo display('subject'); ?> *</label>
                            <input type="text" class="form-control" placeholder="<?php echo display('subject'); ?>" name="email_subject" required="required">
                        </div>

                    </div>
                    <div class="row">

                        <div class="form-group col-lg-12">
                            <label><?php echo display('template'); ?> *</label>
                            <textarea class="form-control" id="summernote" name="email_template" required="required"></textarea>
                        </div>

                    </div> 

                    <div class="row">
                        <div class="form-group col-lg-12 col-md-offset-1">
                            <button type="reset" class="btn btn-danger"><?php echo display('reset'); ?></button>
                            <button type="submit" class="btn btn-success"><?php echo display("send") ?></button>
                        </div>
                    </div>
                <?php echo form_close() ?>

            </div>
        </div>
    </div>
</div>
<!-- summernote css -->
<link href="<?php echo base_url(); ?>assets/plugins/summernote/summernote.css" rel="stylesheet" type="text/css"/>
<!-- summernote js -->
<script src="<?php echo base_url(); ?>assets/plugins/summernote/summernote.min.js" type="text/javascript"></script>