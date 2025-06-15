<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h2><?php echo (!empty($title) ? html_escape($title) : null) ?></h2>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="border_preview">
                        <?php echo form_open_multipart("backend/cms/page_content/form/" . $article->article_id) ?>
                        <?php echo form_hidden('article_id', html_escape($article->article_id)) ?>


                        <?php if (!empty($articledetails)) {

                            foreach ($articledetails as $key => $value) { ?>

                        <div class="form-group row">
                            <label for="headline_<?php echo html_escape($value->iso); ?>"
                                class="col-sm-3 col-form-label">Head Line Text
                                <?php echo html_escape($value->language_name); ?>
                                <?php echo $value->id == 1 ? "<i class='text-danger'>*</i>" : ""; ?></label>
                            <div class="col-sm-9">
                                <input name="headline_<?php echo html_escape($value->iso); ?>"
                                    value="<?php echo html_escape($value->data_headline); ?>" class="form-control"
                                    type="text" id="headline_<?php echo html_escape($value->iso); ?>"
                                    <?php echo $value->id == 1 ? "required" : ""; ?>>
                            </div>
                        </div>
                        <?php   }
                        } else {
                            ?>
                        <?php foreach ($web_language as $key => $value) { ?>

                        <div class="form-group row">
                            <label for="headline_<?php echo html_escape($value->iso); ?>"
                                class="col-sm-3 col-form-label">Head Line Text
                                <?php echo html_escape($value->language_name); ?>
                                <?php echo $value->id == 1 ? "<i class='text-danger'>*</i>" : ""; ?></label>
                            <div class="col-sm-9">
                                <input name="headline_<?php echo html_escape($value->iso); ?>" value=""
                                    class="form-control" type="text"
                                    id="headline_<?php echo html_escape($value->iso); ?>"
                                    <?php echo $value->id == 1 ? "required" : ""; ?>>
                            </div>
                        </div>
                        <?php } ?>
                        <?php
                        }
                        ?>

                        <?php if (!empty($articledetails)) {

                            foreach ($articledetails as $key => $value) { ?>

                        <div class="form-group row">
                            <label for="progress_title_<?php echo html_escape($value->iso); ?>"
                                class="col-sm-3 col-form-label">Data Title
                                <?php echo html_escape($value->language_name); ?></label>
                            <div class="col-sm-9">
                                <textarea name="progress_title_<?php echo html_escape($value->iso); ?>"
                                    class="form-control" type="text"
                                    id="progress_title_<?php echo html_escape($value->iso); ?>"><?php echo html_escape($value->data_title); ?></textarea>
                            </div>
                        </div>
                        <?php   }
                        } else {
                            ?>
                        <?php foreach ($web_language as $key => $value) { ?>

                        <div class="form-group row">
                            <label for="progress_title_<?php echo html_escape($value->iso); ?>"
                                class="col-sm-3 col-form-label">Data Title
                                <?php echo html_escape($value->language_name); ?></label>
                            <div class="col-sm-9">
                                <textarea name="progress_title_<?php echo html_escape($value->iso); ?>"
                                    class="form-control" type="text"
                                    id="progress_title_<?php echo html_escape($value->iso); ?>"></textarea>
                            </div>
                        </div>
                        <?php } ?>
                        <?php
                        }
                        ?>
                        <?php if (!empty($article->article_image)) { ?>
                        <div class="form-group row">
                            <label for="article_image"
                                class="col-sm-3 col-form-label"><?php echo display('image') ?>(MAX 2MB) 500×475</label>
                            <div class="col-sm-9">
                                <input name="article_image" class="form-control"
                                    placeholder="<?php echo display('image') ?>" type="file" id="article_image">
                                <input type="hidden" name="article_image_old"
                                    value="<?php echo html_escape($article->article_image) ?>">
                                <?php if (!empty($article->article_image)) { ?>
                                <img src="<?php echo base_url() . html_escape($article->article_image) ?>" width="150">
                                <?php } ?>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="form-group row">
                            <label for="video" class="col-sm-3 col-form-label"><?php echo display('video') ?></label>
                            <div class="col-sm-9">
                                <input name="video" value="<?php echo html_escape($article->video) ?>"
                                    class="form-control" placeholder="<?php echo display('video') ?>" type="text"
                                    id="video">
                            </div>
                        </div>
                        <?php if (!empty($articledetails)) {
                            foreach ($articledetails as $key => $value) { ?>

                        <div class="form-group row">
                            <label for="article1_<?php echo html_escape($value->iso); ?>"
                                class="col-sm-3 col-form-label">Article
                                <?php echo html_escape($value->language_name); ?></label>
                            <div class="col-sm-9">
                                <textarea id="article1_<?php echo html_escape($value->iso); ?>"
                                    name="article1_<?php echo html_escape($value->iso); ?>" class="form-control editor"
                                    placeholder="Article <?php echo html_escape($value->language_name); ?>"
                                    type="text"><?php echo htmlspecialchars_decode($value->article_1) ?></textarea>
                            </div>
                        </div>
                        <?php
                            }
                        } else {
                            ?>
                        <?php foreach ($web_language as $key => $value) { ?>

                        <div class="form-group row">
                            <label for="article1_<?php echo html_escape($value->iso); ?>"
                                class="col-sm-3 col-form-label">Article
                                <?php echo html_escape($value->language_name); ?></label>
                            <div class="col-sm-9">
                                <textarea id="article1_<?php echo html_escape($value->iso); ?>"
                                    name="article1_<?php echo html_escape($value->iso); ?>" class="form-control editor"
                                    placeholder="Article <?php echo html_escape($value->language_name); ?>"
                                    type="text"></textarea>
                            </div>
                        </div>
                        <?php } ?>
                        <?php
                        }
                        ?>


                        <div class="form-group row">
                            <label for="cat_id" class="col-sm-3 col-form-label"><?php echo display('select_cat') ?><i
                                    class="text-danger">*</i></label>
                            <div class="col-sm-9">
                                <select class="form-control basic-single" name="cat_id">
                                    <option value=""><?php echo display('select_cat') ?></option>
                                    <?php foreach ($parent_cat as $key => $value) { ?>
                                    <option value="<?php echo html_escape($value->cat_id); ?>"
                                        <?php echo ($article->cat_id == $value->cat_id) ? 'Selected' : '' ?>>
                                        <?php echo html_escape($value->slug); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="position_serial"
                                class="col-sm-3 col-form-label"><?php echo display('position_serial') ?><i
                                    class="text-danger">*</i></label>
                            <div class="col-sm-9">
                                <input name="position_serial"
                                    value="<?php echo html_escape($article->position_serial) ?>" class="form-control"
                                    placeholder="<?php echo display('position_serial') ?>" type="text"
                                    id="position_serial">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-9 col-sm-offset-3">
                                <a href="<?php echo base_url('admin'); ?>"
                                    class="btn btn-primary  w-md m-b-5"><?php echo display("cancel") ?></a>
                                <button type="submit"
                                    class="btn btn-success  w-md m-b-5"><?php echo $article->article_id ? display('update') : display("create") ?></button>
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
<link href="<?php echo base_url(); ?>assets/plugins/summernote/summernote.css" rel="stylesheet" type="text/css" />
<!-- summernote js -->
<script src="<?php echo base_url(); ?>assets/plugins/summernote/summernote.min.js" type="text/javascript"></script>