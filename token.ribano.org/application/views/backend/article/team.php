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
                <?php echo form_open_multipart("backend/cms/team/form/$article->article_id") ?>
                <?php echo form_hidden('article_id', html_escape($article->article_id)) ?>

                    <div class="form-group row">
                        <label for="category" class="col-sm-2 col-form-label"><?php echo display('select_cat'); ?><i class="text-danger">*</i></label>
                        <div class="col-sm-10">
                            <select class="form-control basic-single" name="category">
                                <option value=""><?php echo display('select_cat') ?></option>
                                <option value="1" <?php echo $article->cat_id==1?"selected":""?>><?php echo display('leader_ship'); ?></option>
                                <option value="2" <?php echo $article->cat_id==2?"selected":""?>><?php echo display('team_member'); ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="member_name" class="col-sm-2 col-form-label"><?php echo display('name') ?><i class="text-danger">*</i></label>
                        <div class="col-sm-10">
                            <input name="member_name" value="<?php echo htmlspecialchars_decode($article->article_data) ?>" class="form-control" placeholder="<?php echo display('name') ?>" type="text" id="member_name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="article_image" class="col-sm-2 col-form-label"><?php echo display('image') ?>(MAX 2MB) 364×364</label>
                        <div class="col-sm-10">
                            <input name="article_image" class="form-control" placeholder="<?php echo display('image') ?>" type="file" id="article_image">
                             <input type="hidden" name="article_image_old" value="<?php echo html_escape($article->article_image) ?>">
                             <?php if (!empty($article->article_image)) { ?>
                                <img src="<?php echo base_url().html_escape($article->article_image ) ?>" width="150">
                             <?php } ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="designation" class="col-sm-2 col-form-label"><?php echo display('designation'); ?> </label>
                        <div class="col-sm-10">
                            <input type="text" name="designation" value="<?php echo html_escape($article->custom_data); ?>" class="form-control" id="designation">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="position_serial" class="col-sm-2 col-form-label"><?php echo display('position_serial') ?><i class="text-danger">*</i></label>
                        <div class="col-sm-10">
                            <input name="position_serial" value="<?php echo html_escape($article->position_serial) ?>" class="form-control" placeholder="<?php echo display('position_serial') ?>" type="text" id="position_serial">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-9 col-sm-offset-3">
                            <a href="<?php echo base_url('admin'); ?>" class="btn btn-primary  w-md m-b-5"><?php echo display("cancel") ?></a>
                            <button type="submit" class="btn btn-success  w-md m-b-5"><?php echo $article->article_id?display("update"):display("create") ?></button>
                        </div>
                    </div>
                <?php echo form_close() ?>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>