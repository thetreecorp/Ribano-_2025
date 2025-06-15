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
                <?php echo form_open_multipart("backend/cms/about_coin/form/$article->article_id") ?>
                <?php echo form_hidden('article_id', html_escape($article->article_id)) ?>

                <?php if(!empty($article_details)){

                        foreach ($article_details as $key => $value) { ?>

                            <div class="form-group row">
                                <label for="headline_<?php echo html_escape($value->iso); ?>" class="col-sm-3 col-form-label">Value <?php echo html_escape($value->language_name); ?><?php echo $value->id==1?"<i class='text-danger'>*</i>":""; ?></label>
                                <div class="col-sm-9">
                                    <input name="headline_<?php echo html_escape($value->iso); ?>" value="<?php echo html_escape($value->data_headline); ?>" class="form-control" type="text" id="headline_<?php echo html_escape($value->iso); ?>">
                                </div>
                            </div>
                    <?php   } 
                        }
                        else{
                    ?>
                            <?php foreach ($web_language as $key => $value) { ?>

                                <div class="form-group row">
                                    <label for="headline_<?php echo html_escape($value->iso); ?>" class="col-sm-3 col-form-label">Value <?php echo html_escape($value->language_name); ?><?php echo $value->id==1?"<i class='text-danger'>*</i>":""; ?></label>
                                    <div class="col-sm-9">
                                        <input name="headline_<?php echo html_escape($value->iso); ?>" class="form-control" type="text" id="headline_<?php echo html_escape($value->iso); ?>">
                                    </div>
                                </div>
                            <?php } ?>
                    <?php
                        }
                    ?>

                    <?php if(!empty($article_details)){

                            foreach ($article_details as $key => $value) { ?>

                                <div class="form-group row">
                                    <label for="article1_<?php echo html_escape($value->iso); ?>" class="col-sm-3 col-form-label">Text <?php echo html_escape($value->language_name); ?></label>
                                    <div class="col-sm-9">
                                        <textarea name="article1_<?php echo html_escape($value->iso); ?>" class="form-control" type="text" id="article1_<?php echo html_escape($value->iso); ?>"><?php echo htmlspecialchars_decode($value->article_1); ?></textarea>
                                    </div>
                                </div>
                    <?php   } 
                        }
                        else{
                    ?>
                            <?php foreach ($web_language as $key => $value) { ?>

                                <div class="form-group row">
                                    <label for="article1_<?php echo html_escape($value->iso); ?>" class="col-sm-3 col-form-label">Text <?php echo html_escape($value->language_name); ?></label>
                                    <div class="col-sm-9">
                                        <textarea name="article1_<?php echo html_escape($value->iso); ?>" class="form-control" type="text" id="article1_<?php echo html_escape($value->iso); ?>"></textarea>
                                    </div>
                                </div>
                            <?php } ?>
                    <?php
                        }
                    ?>
                    <div class="row">
                        <div class="col-sm-9 col-sm-offset-3">
                            <a href="<?php echo base_url('admin'); ?>" class="btn btn-primary  w-md m-b-5"><?php echo display("cancel") ?></a>
                            <button type="submit" class="btn btn-success w-md m-b-5"><?php echo $article->article_id?display("update"):display("create") ?></button>
                        </div>
                    </div>
                <?php echo form_close() ?>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- summernote css -->
<link href="<?php echo base_url(); ?>assets/plugins/summernote/summernote.css" rel="stylesheet" type="text/css"/>
<!-- summernote js -->
<script src="<?php echo base_url(); ?>assets/plugins/summernote/summernote.min.js" type="text/javascript"></script>