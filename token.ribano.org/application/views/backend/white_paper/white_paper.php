<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h2><?php echo (!empty($title)?html_escape($title):null) ?></h2>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="border_preview">
            <?php if(!empty($userrole)){ if($userrole->create_permission==1 || $userrole->edit_permission==1){ ?>
                        <?php echo form_open_multipart("backend/sto_settings/white_paper/form") ?>
            <?php } }else{ ?>
                        <?php echo form_open_multipart("backend/sto_settings/white_paper/form") ?>
            <?php } ?>
                

                    <?php if(!empty($white_paper->white_paper)){?>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <iframe class="white-paper-ifrma" src="<?php echo base_url($white_paper->white_paper);?>"></iframe>
                            </div>
                        </div>
                    <?php }?>
                    <div class="form-group row">
                        <label for="white_paper_pdf" class="col-sm-4 col-form-label"><?php echo display('white_paper_pdf'); ?><i class="text-danger">*</i></label>
                        <div class="col-sm-7">
                            <input name="white_paper_pdf" class="form-control" placeholder="PDF" type="file" id="white_paper_pdf" required>
                        </div>
                    </div>
            <?php if(!empty($userrole)){ if($userrole->create_permission==1 || $userrole->edit_permission==1){ ?>
                    <div class="row">
                        <div class="col-sm-9 col-sm-offset-3">
                            <button type="submit" class="btn btn-success  w-md m-b-5"><?php echo display("update") ?></button>
                        </div>
                    </div>
                <?php echo form_close() ?>
            <?php } }else{ ?>
                        <div class="row">
                            <div class="col-sm-9 col-sm-offset-3">
                                <button type="submit" class="btn btn-success  w-md m-b-5"><?php echo display("update") ?></button>
                            </div>
                        </div>
                    <?php echo form_close() ?>
            <?php } ?>
                    
                </div>
                </div>
            </div>
        </div>
    </div>
</div>


