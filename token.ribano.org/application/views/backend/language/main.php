<div class="panel panel-bd lobidrag">

    <div class="panel-heading">
        <?php if(!empty($userrole)){ if($userrole->create_permission==1){ ?>
                    <div class="btn-group"> 
                        <a class="btn btn-success" href="<?php echo base_url("backend/setting/language/phrase") ?>"> <i class="fa fa-plus"></i> <?php echo display('add_phrase'); ?></a> 
                    </div> 
        <?php } }else{ ?>
                <div class="btn-group"> 
                    <a class="btn btn-success" href="<?php echo base_url("backend/setting/language/phrase") ?>"> <i class="fa fa-plus"></i> <?php echo display('add_phrase'); ?></a> 
                </div> 
        <?php } ?>
    </div>


    <div class="panel-body">
      <table class="table table-striped">
        <thead>
            <tr>
                <td colspan="3">
                <?php if(!empty($userrole)){ if($userrole->create_permission==1){ ?>
                    <?php echo  form_open('backend/setting/language/addlanguage', ' class="form-inline" ') ?> 
                        <div class="form-group">
                            <label class="sr-only" for="addLanguage"> <?php echo display('language_name'); ?></label>
                            <input name="language" type="text" class="form-control" id="addLanguage" placeholder="<?php echo display('language_name'); ?>">
                        </div>
                          
                        <button type="submit" class="btn btn-primary"><?php echo display('save'); ?></button>
                    <?php echo  form_close(); ?>
                <?php } }else{ ?>
                        <?php echo  form_open('backend/setting/language/addlanguage', ' class="form-inline" ') ?> 
                            <div class="form-group">
                                <label class="sr-only" for="addLanguage"> <?php echo display('language_name'); ?></label>
                                <input name="language" type="text" class="form-control" id="addLanguage" placeholder="<?php echo display('language_name'); ?>">
                            </div>
                              
                            <button type="submit" class="btn btn-primary"><?php echo display('save'); ?></button>
                        <?php echo  form_close(); ?>
                <?php } ?>
                </td>
            </tr>
            <tr>
                <th><i class="fa fa-th-list"></i></th>
                <th><?php echo display('language'); ?></th>
                <th><i class="fa fa-cogs"></i></th>
            </tr>
        </thead>


        <tbody>
            <?php if (!empty($languages)) {?>
                <?php $sl = 1 ?>
                <?php foreach ($languages as $key => $language) {?>
                <tr>
                    <td><?php echo  html_escape($sl++) ?></td>
                    <td><?php echo  html_escape($language) ?></td>
                    <td>
                    <?php if(!empty($userrole)){ if($userrole->edit_permission==1){ ?>
                        <a href="<?php echo  base_url("backend/setting/language/editPhrase/$key") ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>
                    <?php } }else{ ?>
                        <a href="<?php echo  base_url("backend/setting/language/editPhrase/$key") ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>
                    <?php } ?>
                    </td> 
                </tr>
                <?php } ?>
            <?php } ?>
        </tbody>

      </table>
    </div>
  
</div>

