
<div class="panel panel-bd lobidrag">
 
    <div class="panel-heading">
        <div class="btn-group">  
            <a class="btn btn-primary" href="<?php echo base_url("backend/setting/language") ?>"> <i class="fa fa-list"></i>  <?php echo display('language_list'); ?> </a> 
        </div> 
    </div>


    <div class="panel-body">
      <table class="table table-striped">
        <thead>
            <tr>
                <td colspan="2">
                    <?php echo  form_open('backend/setting/language/addPhrase', ' class="form-inline" ') ?> 
                        <div class="form-group">
                            <label class="sr-only" for="addphrase"> <?php echo display('phrase_name'); ?></label>
                            <input name="phrase[]" type="text" class="form-control" id="addphrase" placeholder="<?php echo display('phrase_name'); ?>">
                        </div>
                          
                        <button type="submit" class="btn btn-primary"><?php echo display('save'); ?></button>
                    <?php echo  form_close(); ?>
                </td>
            </tr>
            <tr>
                <th><i class="fa fa-th-list"></i></th>
                <th><?php echo display('phrase'); ?></th> 
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($phrases)) {?>
                <?php $sl = 1 ?>
                <?php foreach ($phrases as $value) {?>
                <tr>
                    <td><?php echo  html_escape($sl++) ?></td>
                    <td><?php echo  html_escape($value->phrase) ?></td>
                </tr>
                <?php } ?>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr><td colspan="2"><?php echo (!empty($links)?htmlspecialchars_decode($links):null) ?></td></tr>
        </tfoot>
      </table>
    </div>
 

</div>

