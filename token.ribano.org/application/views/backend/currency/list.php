<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h2><?php echo (!empty($title)?html_escape($title):null) ?></h2>
                <?php if(!empty($userrole)){ if($userrole->create_permission==1){ ?>
                    <div class="col-sm-3 col-md-3 pull-right">
                        <a class="btn btn-success w-md m-b-5 pull-right" href="<?php echo base_url("backend/sto_settings/currency/form") ?>"><i class="fa fa-plus" aria-hidden="true"></i> <?php echo display('currency'); ?></a>
                    </div>
                <?php } }else{ ?>
                    <div class="col-sm-3 col-md-3 pull-right">
                        <a class="btn btn-success w-md m-b-5 pull-right" href="<?php echo base_url("backend/sto_settings/currency/form") ?>"><i class="fa fa-plus" aria-hidden="true"></i> <?php echo display('currency'); ?></a>
                    </div>
                <?php } ?>
                </div>
            </div>
            <div class="panel-body">
                <?php echo form_open('#',array('id'=>'ajaxcointableform','name'=>'ajaxcointableform')); ?>
                <table id="ajaxcointable" class="table table-bordered table-hover">
                    <thead>
                        <tr>                             
                            <th><?php echo display('sl_no') ?></th>
                            <th><?php echo display('name') ?></th>
                            <th><?php echo display('iso_code'); ?></th>
                            <th><?php echo display('rate') ?></th>
                            <th><?php echo display('action') ?></th>
                        </tr>
                    </thead>    
                    <tbody>

                    </tbody>
                </table>
                <?php echo form_close(); ?>
            </div> 
        </div>
    </div>
</div>


 