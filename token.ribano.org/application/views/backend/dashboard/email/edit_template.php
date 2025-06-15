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
                echo form_open_multipart("backend/email/email/update_template") ?>

                    <input type="hidden"  class="form-control" value="<?php echo html_escape($template->email_temp_id); ?>" name="id">
                
                    <div class="row">

                        <div class="form-group col-lg-12">
                            <label><?php echo display('template_name'); ?> *</label>
                            <input type="text" class="form-control" name="template_subject" value="<?php echo html_escape($template->tem_title) ?>" required="required">
                        </div>

                    </div>
                    <div class="row">

                        <div class="form-group col-lg-12">
                            <label><?php echo display('template'); ?> *</label>
                            <textarea class="form-control" id="summernote" name="email_template" required="required"><?php echo html_escape($template->template) ?></textarea>
                        </div>

                    </div> 

                    <div class="row">
                        <div class="form-group col-lg-12 pull-right">
                            <button type="submit" class="btn btn-success"><?php echo display("update") ?></button>
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