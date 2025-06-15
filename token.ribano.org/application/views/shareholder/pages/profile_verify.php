<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 lobipanel-parent-sortable ui-sortable" data-lobipanel-child-inner-id="5lmZlfyErQ">
        
        <!-- alert message -->
            <div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo display('check_your_email'); ?> 
            </div> 
            


        <div class="panel panel-bd lobidrag lobipanel lobipanel-sortable" data-inner-id="5lmZlfyErQ" data-index="0">
            <div class="panel-heading ui-sortable-handle">
                <div class="panel-title max-width-calc">
                    <h4><?php echo display('change_verify')?></h4>
                </div>
            </div>

            <?php 

            ?>

            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                        <div class="border_preview">
                            <div class="table-responsive">
                                <?php 
                                    $att = array('name'=>'verify');
                                    echo form_open('#',html_escape($att));
                                ?>
                                <table class="table">
                                    <tbody>

                                        <tr>
                                            <th><?php echo display('enter_verify_code');?></th>
                                            <td><input class="form-control" type="text" name="code" id="code"></td>
                                        </tr>

                                    </tbody>
                                </table>
                                <?php echo form_close();?>
                            </div>
                            <div class="text-right">
                                <button type="button" class="btn btn-success w-md m-b-5" id="profile_verify_confirm"><?php echo display('confirm');?></button>
                                <button type="button" class="btn btn-danger w-md m-b-5"><?php echo display('cancle');?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>