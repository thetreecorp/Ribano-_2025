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
                echo form_open_multipart("backend/email/email/reserve_key_save") ?>
                
                    <div class="row">

                        <div class="form-group col-lg-12">
                            <label><?php echo display('reserve_key'); ?> *</label>
                            <input class="form-control" type="text" placeholder="<?php echo display('reserve_key'); ?>" name="reserve_key" required="required">
                        </div>

                    </div>
                    <div class="row">

                        <div class="form-group col-lg-12">
                            <label><?php echo display('details'); ?> *</label>
                            <textarea class="form-control" name="reserve_details" required="required"></textarea>
                        </div>

                    </div> 

                    <div>
                        <button type="submit" class="btn btn-success"><?php echo display("save") ?></button>
                    </div>
                <?php echo form_close() ?>
            </div>

            </div>
        </div>
    </div>
</div>