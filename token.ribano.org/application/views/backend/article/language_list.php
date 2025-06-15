<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h2><?php echo (!empty($title)?html_escape($title):null) ?></h2>
                </div>
            </div>
            <div class="panel-body">
                <table class="datatable2 table table-bordered table-hover">
                    <thead>
                        <tr> 
                            <th><?php echo display('sl_no') ?></th>
                            <th><?php echo display('language_name'); ?></th>
                            <th><?php echo display('flag'); ?></th>
                            <th><?php echo display('action'); ?></th>
                        </tr>
                    </thead>    
                    <tbody>
                        <?php if (!empty($language)) ?>
                        <?php $sl = 1; ?>
                        <?php foreach ($language as $value) { ?>
                        <tr>
                            <td><?php echo html_escape($sl++); ?></td> 
                            <td><?php echo html_escape($value->language_name)?></td>
                            <td><img src="<?php echo base_url("assets/images/flags/".html_escape($value->flag).".png"); ?>" alt=""></td>
                            <td>
                                <?php if($value->id!=1) { ?>
                                            <a class="btn btn-danger" title="Delete" href="<?php echo base_url("backend/cms/web_language/delete/$value->id"); ?>"><i class="fa fa-remove"></i></a>
                                <?php }else{
                                    echo "Default";
                                }?>
                            </td>
                        </tr>
                        <?php } ?>  
                    </tbody>
                </table>
            </div> 
        </div>
    </div>
</div>

 