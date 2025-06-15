<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        <div class="panel panel-bd lobidrag ">
            <div class="panel-heading ui-sortable-handle">
                <div class="panel-title max-width-calc">
                    <h4><?php echo display('investment');?></h4>
                </div>
            </div>
            <div class="panel-body">
                <?php if($invest!=NULL){ ?>
                    <div class="border_preview">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered">
                                
                                <thead>
                                    <tr>
                                        <th><?php echo display('num_share');?> (<?php echo html_escape($stoinfo->symbol); ?>)</th>
                                        <th><?php echo display('package_price');?> (<?php echo html_escape($stoinfo->pair_with); ?>)</th>
                                        <th><?php echo display('package_name');?></th>
                                        <th><?php echo display('pak_type');?></th>
                                        <th>Facilities</th>
                                        <th><?php echo display('date');?></th>
                                     </tr>
                                </thead>

                                <tbody>
                                    <?php 
                                        foreach ($invest as $key => $value) {  
                                    ?>
                                    <tr>
                                        <td><?php echo html_escape($value->num_share);?></td>
                                        <td><?php echo html_escape($value->amount);?></td>
                                        <td><?php echo html_escape($value->package_name);?></td>
                                        <td><?php echo html_escape($value->pack_type);?></td>
                                        <td>
                                        <?php if($value->facility_type==1){ ?>

                                            <strong>ROI</strong>
                                        <?php }else{ ?>
                                            <?php
                                                if(!empty($value->data)){
                                                    $i = 2;
                                                    $jsondata = json_decode($value->data,true);
                                                    foreach ($jsondata as $key => $row) {
                                            ?>
                                                        <span><?php echo html_escape($i).". ".html_escape($row); ?></span></br>
                                            <?php
                                                    html_escape($i++);
                                                    }
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo html_escape($value->invest_date);?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php }else{ ?>
                    <center><h3 class="text-danger">No Data Available</h3></center>
                <?php } ?>
            </div>
        </div>
    </div>
</div>