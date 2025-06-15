
<div class="panel panel-bd lobidrag">
 
    <div class="panel-heading">
        <div class="btn-group"> 
            <a class="btn btn-success" href="<?php echo base_url("backend/setting/language/phrase") ?>"> <i class="fa fa-plus"></i> <?php echo display('add_phrase'); ?></a>
            <a class="btn btn-primary" href="<?php echo base_url("backend/setting/language") ?>"> <i class="fa fa-list"></i>  <?php echo display('language_list'); ?> </a> 
        </div> 
    </div>


    <div class="panel-body">
        <div class="row">
            <?php echo form_open('backend/setting/language/search/'.$this->uri->segment(5)); ?>
                <div class="col-md-7 col-md-offset-4">
                    <input class="form-control" type="text" name="search_box" placeholder="Search Phrase OR Label" required>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-info"><i class="fa fa-search-plus"></i></button>
                </div>
            <?php echo form_close(); ?>
        </div>
        <?php echo  form_open('backend/setting/language/addlebel') ?>
        <table class="table table-striped">
            <thead> 
                <tr>
                    <td colspan="3"> 
                        <button type="reset" class="btn btn-danger"><?php echo display('reset'); ?></button>
                        <button type="submit" class="btn btn-success"><?php echo display('save'); ?></button>
                    </td>
                </tr>
                <tr>
                    <th><i class="fa fa-th-list"></i></th>
                    <th><?php echo display('phrase'); ?></th>
                    <th><?php echo display('label'); ?></th> 
                </tr>
            </thead>

            <tbody>
                <?php echo  form_hidden('language', $language) ?>
                <?php if (!empty($phrases)) {?>
                    <?php $sl = 1 ?>

                    <?php if($search_result){ ?>

                    <tr class="green-yellow">
                    
                        <td><?php echo  html_escape($sl++) ?></td>
                        <td><input type="text" name="phrase[]" value="<?php echo  html_escape($search_result->phrase) ?>" class="form-control" readonly></td>
                        <td><input type="text" name="lang[]" value="<?php echo  html_escape($search_result->$language) ?>" class="form-control"></td> 
                    </tr>

                    <?php } ?>

                    <?php foreach ($phrases as $value) {?>

                        <?php if(!empty($search_lang_id) && $search_lang_id==$value->id){ continue; }?>
                    <tr class="<?php echo  (empty($value->$language)?"bg-danger":null) ?>">
                    
                        <td><?php echo  html_escape($sl++) ?></td>
                        <td><input type="text" name="phrase[]" value="<?php echo  html_escape($value->phrase) ?>" class="form-control" readonly></td>
                        <td><input type="text" name="lang[]" value="<?php echo html_escape($value->$language) ?>" class="form-control"></td> 
                    </tr>
                    <?php } ?>
                <?php } ?> 
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="1"> 
                        <button type="reset" class="btn btn-danger"><?php echo display('reset'); ?></button>
                        <button type="submit" class="btn btn-success"><?php echo display('save'); ?></button>
                    </td>
                    <td colspan="2">
                        <?php echo (!empty($links)?htmlspecialchars_decode($links):null) ?>
                    </td>
                </tr>
            </tfoot>
        </table>
        <?php echo  form_close() ?>
    </div>
</div>