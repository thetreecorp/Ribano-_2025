<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h2><?php echo (!empty($title)?html_escape($title):null) ?></h2>
                </div>
            </div>
            
            <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-3 col-md-3 pull-right">
                            <a class="btn btn-success w-md m-b-5 pull-right" href="<?php echo base_url("backend/sms/sms/add_template") ?>"><i class="fa fa-plus" aria-hidden="true"></i> <?php echo display('add_template'); ?></a>
                        </div>
                        <div class="form-group col-lg-12">
                            <div class="panel-body">
                                <table width="100%" class="datatable2 table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th class=""><?php echo display('template_name');?></th>
                                            <th class=""><?php echo display('active');?></th>
                                            <th class="all"><?php echo display('action');?></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach($template as $value){?>
                                            <tr>
                                                <td><?php echo html_escape($value->teamplate_name) ?></td>
                                                <td> 
                                                    <a class="btn btn-info" href="<?php echo base_url('backend/sms/sms/set_template_status/'); ?><?php echo html_escape($value->teamplate_id) ?>"><span class="glyphicon glyphicon-<?php echo $value->default_status==1?'ok':'remove';?>"></span></a>
                                                </td>
                                                <td>
                                                    <a href="<?php echo base_url('backend/sms/sms/edit_template/'); ?><?php echo html_escape($value->teamplate_id);?>" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                                    <a href="<?php echo base_url('backend/sms/sms/delete_template/'); ?><?php echo html_escape($value->teamplate_id);?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>