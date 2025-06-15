<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h2><?php echo (!empty($title) ? html_escape($title) : null) ?></h2>
                    <div class="pull-right"><a href="<?php echo base_url('backend/cms/web_language/language_list'); ?>"
                            class="btn btn-success"><?php echo display('language_list'); ?></a></div>
                </div>
            </div>

            <div class="panel-body">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="border_preview">
                        <?php echo form_open_multipart("backend/cms/web_language/" . @$language->id) ?>
                        <?php echo form_hidden('id', html_escape(@$language->id)) ?>

                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label"><?php echo display('language_name'); ?><i
                                    class="text-danger">*</i></label>
                            <div class="col-sm-10">
                                <select class="form-control" name="lang_name" id="lang_name" required>
                                    <option value=""><?php echo display('select_option') ?></option>
                                    <?php
                                    foreach ($lang_list as $key => $value) {

                                        echo "<option value='" . html_escape($value['name']) . "." . html_escape($key) . "'>" . html_escape($value['name']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="flag" class="col-sm-2 col-form-label"><?php echo display('flag') ?><i
                                    class="text-danger">*</i></label>
                            <div class="col-sm-10">
                                <select class="form-control" name="flag" id="flag" required>
                                    <option value=""><?php echo display('select_option') ?></option>
                                    <?php
                                    foreach ($flag_list as $key => $flag) {

                                        echo "<option data-image='" . base_url("assets/images/flags/" . strtolower(html_escape($flag->iso)) . ".png") . "' value='" . html_escape($flag->iso) . "'>$flag->name</option>";
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
                                    class="btn btn-success  w-md m-b-5"><?php echo display("create"); ?></button>
                            </div>
                        </div>
                        <?php echo form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>