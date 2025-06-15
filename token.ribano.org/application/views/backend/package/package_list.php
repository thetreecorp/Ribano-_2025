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
                            <th><?php echo display('package_name') ?></th>
                            <th><?php echo display('period') ?>(Day)</th>
                            <th><?php echo display('pak_type') ?></th>
                            <th><?php echo display('num_share') ?></th>
                            <th><?php echo display('package_price') ?></th>
                            <th><?php echo display('facilities'); ?></th>
                            <th><?php echo display('action') ?></th>
                        </tr>
                    </thead>    
                    <tbody>
                        <?php if (!empty($package)) ?>
                        <?php $sl = 1; ?>
                        <?php foreach ($package as $value) { ?>
                        <tr>
                            <td><?php echo html_escape($sl++); ?></td> 
                            <td><?php echo html_escape($value->package_name); ?></td>
                            <td><?php echo html_escape($value->period); ?></td>
                            <td><?php echo html_escape($value->pack_type); ?></td>
                            <td><?php echo html_escape($stoinfo->symbol)." ".html_escape($value->num_share); ?></td>
                            <td><?php echo html_escape($stoinfo->pair_with)." ".html_escape($value->package_price); ?></td>
                            <td>
                            <?php if($value->facility_type==1){ ?>
                                        <span><?php echo display('roi'); ?></span>
                            <?php }else{ ?>

                                <?php
                                    $i=1;
                                    $jdata = $value->data?json_decode($value->data,true):"";
                                    if(!empty($jdata)){
                                ?>
                                <?php foreach($jdata as $key => $row){ ?>
                                            <span><?php echo html_escape($i).". ".html_escape($row); ?></span></br>
                                <?php html_escape($i++); } }?>
                            <?php } ?>
                            </td>
                            <td>
                            <?php if(!empty($userrole)){ if($userrole->edit_permission==1){ ?>
                                <a href="<?php echo base_url("backend/package/add_package/index/$value->package_id") ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="Update"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                            <?php }if($userrole->delete_permission==1){ ?>
                                <a href="<?php echo base_url("backend/package/package_list/delete/$value->package_id") ?>" onclick="return confirm('<?php echo display("are_you_sure") ?>')" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="right" title="Delete "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                            <?php } }else{ ?>
                                <a href="<?php echo base_url("backend/package/add_package/index/$value->package_id") ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="Update"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                <a href="<?php echo base_url("backend/package/package_list/delete/$value->package_id") ?>" onclick="return confirm('<?php echo display("are_you_sure") ?>')" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="right" title="Delete "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                            <?php } ?>
                            </td>
                        </tr>
                        <?php } ?>  
                    </tbody>
                </table>
                <?php echo htmlspecialchars_decode($links); ?>
            </div> 
        </div>
    </div>
</div>

 