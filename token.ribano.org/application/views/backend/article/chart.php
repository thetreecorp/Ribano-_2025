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
                <?php echo form_open_multipart("backend/cms/chart/form/$article->article_id") ?>
                <?php echo form_hidden('article_id', html_escape($article->article_id)) ?>
                    <div class="form-group row">
                        <label for="chart" class="col-sm-2 col-form-label">Select Chart<i class="text-danger">*</i></label>
                        <div class="col-sm-10">
                            <select class="form-control basic-single" name="chart">
                                <option value=""><?php echo display('select_option') ?></option>
                                <option value="1" <?php echo $article->cat_id==1?"selected":""?>>Chart One</option>
                                <option value="2" <?php echo $article->cat_id==2?"selected":""?>>Chart Two</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="article_data" class="col-sm-2 col-form-label">Lebel<i class="text-danger">*</i></label>
                        <div class="col-sm-10">
                            <input name="article_data" value="<?php echo htmlspecialchars_decode($article->article_data) ?>" class="form-control" type="text" id="article_data">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="article_color" class="col-sm-2 col-form-label"><?php echo display('color'); ?></label>
                        <div class="col-sm-10">
                            <input name="article_color" value="<?php echo html_escape($article->article_image) ?>" class="form-control" placeholder="" type="text" id="article_color">
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