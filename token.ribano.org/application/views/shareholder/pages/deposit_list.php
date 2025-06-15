<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 lobipanel-parent-sortable ui-sortable" data-lobipanel-child-inner-id="2jd65zBuH9">
        <div class="panel panel-bd lobidrag lobipanel lobipanel-sortable" data-inner-id="2jd65zBuH9" data-index="0">
            <div class="panel-heading ui-sortable-handle">
                <div class="panel-title max-width-calc">
                    <h4><?php echo display('deposit_list');?></h4>
                </div>
            </div>
            <div class="panel-body">
                <?php if($deposit!=NULL){ ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th><?php echo display('deposit_method')?></th>
                                    <th><?php echo display('deposit_amount')?></th>
                                    <th><?php echo display('fees')?></th>
                                    <th><?php echo display('comments')?></th>
                                    <th><?php echo display('date')?></th>
                                    <th><?php echo display('status')?></th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php 
                                    foreach ($deposit as $key => $value) {  
                                ?>
                                <tr>
                                    <td><?php echo html_escape($value->method);?></td>
                                    <td><?php echo html_escape(@$coininfo->pair_with).' '.html_escape($value->amount);?></td>
                                    <td><?php echo html_escape(@$coininfo->pair_with).' '.html_escape($value->fees_amount);?></td>
                                    <td><?php
                                            if (is_string(html_escape($value->comment)) && is_array(json_decode(html_escape($value->comment), true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false) {
                                               $mobiledata = json_decode(html_escape($value->comment), true);
                                               echo '<b>'.display("om_name").':</b> '.html_escape($mobiledata['om_name']).'<br>';
                                               echo '<b>'.display("om_mobile_no").':</b> '.html_escape($mobiledata['om_mobile']).'<br>';
                                               echo '<b>'.display("transaction_no").':</b> '.html_escape($mobiledata['transaction_no']).'<br>';
                                               echo '<b>'.display("idcard_no").':</b> '.html_escape($mobiledata['idcard_no']);
                                            } else {
                                                
                                                echo $value->method=="CCAvenue"?"":html_escape($value->comment);
                                            }

                                     ?></td>
                                    <td><?php $date=date_create($value->deposit_date);
                                            echo date_format($date,"jS F Y");?></td>
                                    <td><span class="glyphicon glyphicon-<?php echo ($value->status?'ok text-success':'remove text-danger');?>">
                                        <a href="<?php echo base_url("shareholder/deposit/deposit_details/$value->id"); ?>"><button type="button" class="btn btn-info"><i class="fa fa-info"></i></button></a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <?php echo htmlspecialchars_decode($links); ?>
                    </div>
                <?php }else{ ?>
                    <center><h3 class="text-danger">No Data Available</h3></center>
                <?php } ?>
            </div>
        </div>
    </div>
</div>