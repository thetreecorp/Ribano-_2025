<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h2><?php echo (!empty($title)?html_escape($title):null) ?></h2>
                </div>
            </div>
            
            <div class="panel-body">
                <div class="border_preview">

                <?php 
                echo form_open_multipart("backend/sms/sms/template_save") ?>
                
                    <div class="row">

                        <div class="form-group col-lg-12">
                            <label><?php echo display('template_name'); ?> *</label>
                            <input type="text" class="form-control" placeholder="<?php echo display('template_name'); ?>" name="template_name" required="required">
                        </div>

                    </div>
                    <div class="row">

                        <div class="form-group col-lg-12">
                            <label><?php echo display('template'); ?> *</label>
                            <textarea rows="8" class="form-control" id="summernote" name="template" required="required"></textarea>
                        </div>

                    </div> 

                    <div class="row">
                        <div class="form-group col-lg-12 col-md-offset-1">
                            <button type="reset" class="btn btn-danger"><?php echo display('reset'); ?></button>
                            <button type="submit" class="btn btn-success"><?php echo display("save") ?></button>
                        </div>
                    </div>
                <?php echo form_close() ?>
            </div>

            </div>
        </div>
    </div>
</div>