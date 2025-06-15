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
                        <?php echo form_open_multipart("backend/cms/head_line_text/form/" . $headline->id) ?>
                        <?php echo form_hidden('id', html_escape($headline->id)) ?>


                        <?php if (!empty($headlinedetails)) {
                            foreach ($headlinedetails as $key => $value) { ?>

                        <div class="form-group row">
                            <label for="headline_<?php echo html_escape($value->iso); ?>"
                                class="col-sm-3 col-form-label"><?php echo display('head_line_title'); ?>
                                <?php echo html_escape($value->language_name); ?>
                                <?php echo $value->id == 1 ? "<i class='text-danger'>*</i>" : ""; ?></label>
                            <div class="col-sm-9">
                                <input name="headline_<?php echo html_escape($value->iso); ?>"
                                    value="<?php echo html_escape($value->data_headline); ?>" class="form-control"
                                    type="text" id="headline_<?php echo html_escape($value->iso); ?>"
                                    <?php echo $value->id == 1 ? "required" : ""; ?>>
                            </div>
                        </div>
                        <?php
                            }
                        } else {
                            ?>
                        <?php foreach ($web_language as $key => $value) { ?>
                        <div class="form-group row">
                            <label for="headline_<?php echo html_escape($value->iso); ?>"
                                class="col-sm-3 col-form-label"><?php echo display('head_line_title'); ?>
                                <?php echo html_escape($value->language_name); ?>
                                <?php echo $value->id == 1 ? "<i class='text-danger'>*</i>" : ""; ?></label>
                            <div class="col-sm-9">
                                <input name="headline_<?php echo html_escape($value->iso); ?>" class="form-control"
                                    type="text" id="headline_<?php echo html_escape($value->iso); ?>"
                                    <?php echo $value->id == 1 ? "required" : ""; ?>>
                            </div>
                        </div>
                        <?php } ?>
                        <?php
                        }
                        ?>

                        <?php if (!empty($headlinedetails)) {

                            foreach ($headlinedetails as $key => $value) { ?>

                        <div class="form-group row">
                            <label for="article_<?php echo html_escape($value->iso); ?>"
                                class="col-sm-3 col-form-label"><?php echo display('article'); ?>
                                <?php echo html_escape($value->language_name); ?></label>
                            <div class="col-sm-9">
                                <textarea name="article_<?php echo html_escape($value->iso); ?>" class="form-control"
                                    type="text"
                                    id="article_<?php echo html_escape($value->iso); ?>"><?php echo html_escape($value->article_1); ?></textarea>
                            </div>
                        </div>
                        <?php   }
                        } else {
                            ?>
                        <?php foreach ($web_language as $key => $value) { ?>

                        <div class="form-group row">
                            <label for="article_<?php echo html_escape($value->iso); ?>"
                                class="col-sm-3 col-form-label"><?php echo display('article'); ?>
                                <?php echo html_escape($value->language_name); ?></label>
                            <div class="col-sm-9">
                                <textarea name="article_<?php echo html_escape($value->iso); ?>" class="form-control"
                                    type="text" id="article_<?php echo html_escape($value->iso); ?>"></textarea>
                            </div>
                        </div>
                        <?php } ?>
                        <?php
                        }
                        ?>
                        <div class="form-group row">
                            <label for="position_key"
                                class="col-sm-3 col-form-label"><?php echo display('position_key'); ?><i
                                    class='text-danger'>*</i></label>
                            <div class="col-sm-9">
                                <select name="position_key" id="position_key" class="form-control">
                                    <option value=""><?php echo display('select_option'); ?></option>

                                    <?php
                                    for ($i = 1; $i < 10; $i++) {
                                    ?>
                                    <option value='<?php echo html_escape($i); ?>'
                                        <?php echo $headline->position_key == $i ? "Selected" : "" ?>>
                                        <?php echo display('level'); ?> <?php echo html_escape($i); ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-9 col-sm-offset-3">
                                <a href="<?php echo base_url('admin'); ?>"
                                    class="btn btn-primary  w-md m-b-5"><?php echo display("cancel") ?></a>
                                <button type="submit"
                                    class="btn btn-success  w-md m-b-5"><?php echo !empty($headline->id) ? display('update') : display("create") ?></button>
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