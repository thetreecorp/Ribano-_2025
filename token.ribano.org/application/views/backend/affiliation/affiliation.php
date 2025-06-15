<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h2><?php echo (!empty($title)?html_escape($title):null) ?></h2>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                <div class="border_preview">
            <?php if(!empty($userrole)){ if($userrole->create_permission==1){ ?>
                        <?php echo form_open_multipart("backend/setting/affiliation") ?>
            <?php } }else{ ?>
                    <?php echo form_open_multipart("backend/setting/affiliation") ?>
            <?php } ?>
                <?php echo form_hidden('id', html_escape(@$affiliation->id)) ?> 

                    <div class="form-group row">
                        <label for="commission" class="col-sm-4 col-form-label"><?php echo display('commission'); ?><i class="text-danger">*</i></label>
                        <div class="col-sm-8">
                            <input name="commission" value="<?php echo html_escape(@$affiliation->commission) ?>" class="form-control" placeholder="<?php echo display('commission') ?>" type="number" id="commission">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="type" class="col-sm-4 col-form-label"><?php echo display('type'); ?><i class="text-danger">*</i></label>
                        <div class="col-sm-8">
                            <label class="radio-inline">
                                <?php echo form_radio('type', 'PERCENT', ((@$affiliation->type=='PERCENT' || @$affiliation->type==null)?true:false)); ?>Percent
                             </label>
                            <label class="radio-inline">
                                <?php echo form_radio('type', 'FIXED', ((@$affiliation->type=='FIXED')?true:false) ); ?>Fixed
                             </label> 
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="status" class="col-sm-4 col-form-label"><?php echo display('status') ?><i class="text-danger">*</i></label>
                        <div class="col-sm-8">
                            <label class="radio-inline">
                                <?php echo form_radio('status', '1', ((@$affiliation->status==1 || @$affiliation->status==null)?true:false)); ?><?php echo display('active'); ?>
                             </label>
                            <label class="radio-inline">
                                <?php echo form_radio('status', '0', ((@$affiliation->status=="0")?true:false) ); ?><?php echo display('inactive'); ?>
                             </label> 
                        </div>
                    </div>
            <?php if(!empty($userrole)){ if($userrole->create_permission==1){ ?>
                    <div class="row">
                        <div class="col-sm-9 col-sm-offset-3">
                            <a href="<?php echo base_url('admin'); ?>" class="btn btn-primary  w-md m-b-5"><?php echo display("cancel") ?></a>
                            <button type="submit" class="btn btn-success  w-md m-b-5"><?php echo @$affiliation->id?display("update"):display("create") ?></button>
                        </div>
                    </div>
                <?php echo form_close() ?>
             <?php } }else{ ?>
                        <div class="row">
                            <div class="col-sm-9 col-sm-offset-3">
                                <a href="<?php echo base_url('admin'); ?>" class="btn btn-primary  w-md m-b-5"><?php echo display("cancel") ?></a>
                                <button type="submit" class="btn btn-success  w-md m-b-5"><?php echo @$affiliation->id?display("update"):display("create") ?></button>
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

 