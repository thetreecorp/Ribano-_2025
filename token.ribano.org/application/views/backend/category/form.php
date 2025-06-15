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
                <?php echo form_open_multipart("backend/cms/category/form/$category->cat_id") ?>
                <?php echo form_hidden('cat_id', html_escape($category->cat_id)) ?> 

                    <div class="form-group row">
                        <label for="cat_name" class="col-sm-4 col-form-label"><?php echo display('category_name'); ?><i class="text-danger">*</i></label>
                        <div class="col-sm-8">
                            <input name="cat_name" value="<?php echo html_escape($category->slug); ?>" class="form-control" type="text" id="cat_name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="parent_id" class="col-sm-4 col-form-label"><?php echo display('parent_category'); ?><i class="text-danger">*</i></label>
                        <div class="col-sm-8">
                            <select class="form-control" name="parent_id" id="parent_id">
                                <option value=""><?php echo display('select_option') ?></option>
                                <?php
                                    if(!empty($parent_menu)){
                                        foreach ($parent_menu as $key => $value) {
                                ?>
                                        <?php if(strtolower($value->slug)=="blog"){ ?>
                                            <option value='<?php echo html_escape($value->cat_id); ?>' <?php echo $category->parent_id==$value->cat_id?'selected':null; ?> ><?php echo html_escape($value->slug); ?></option>
                                        <?php } ?>
                                <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="position_serial" class="col-sm-4 col-form-label"><?php echo display('position_serial'); ?><i class="text-danger">*</i></label>
                        <div class="col-sm-8">
                            <input name="position_serial" class="form-control" value="<?php echo html_escape($category->position_serial); ?>" type="number" id="position_serial">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="status" class="col-sm-4 col-form-label"><?php echo display('status') ?></label>
                        <div class="col-sm-8">
                            <label class="radio-inline">
                                <?php echo form_radio('status', '1', (($category->status==1 || $category->status==null)?true:false)); ?><?php echo display('active'); ?>
                             </label>
                            <label class="radio-inline">
                                <?php echo form_radio('status', '0', (($category->status=="0")?true:false) ); ?><?php echo display('inactive'); ?>
                             </label> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-9 col-sm-offset-3">
                            <a href="<?php echo base_url('admin'); ?>" class="btn btn-primary  w-md m-b-5"><?php echo display("cancel") ?></a>
                            <button type="submit" class="btn btn-success  w-md m-b-5"><?php echo $category->cat_id?display("update"):display("create") ?></button>
                        </div>
                    </div>
                <?php echo form_close() ?>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

 