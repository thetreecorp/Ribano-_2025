
    <!-- /.Social share -->
    <div class="row">

        <div class="col-sm-6 col-md-3">
            <div class="count_panel panel-navy-blue">
                <div class="stats-title">
                    <h4><?php echo display('total_user')?></h4>
                    <i class="fa fa-users"></i>
                </div>
                <p class="currency_text "><?php echo (@$total_user?html_escape($total_user):'0'); ?></p>
                <i class="fa fa-info-circle" data-toggle="tooltip" data-original-title="<?php echo display('your_total_user'); ?>"></i>
            </div>
        </div>

        <div class="col-sm-6 col-md-3">
            <div class="count_panel panel-four">
                <div class="stats-title">
                    <h4><?php echo display('deposit')?></h4>
                    <i class="fa fa-university"></i>
                </div>
                <p class="currency_text "><?php echo html_escape(@$coin_info->pair_with);?> <?php echo (@$total_deposit->deposit?number_format(html_escape($total_deposit->deposit),2):'0.0'); ?></p>
                <i class="fa fa-info-circle" data-toggle="tooltip" data-original-title="<?php echo display('total_deposit_amount'); ?>"></i>
            </div>
        </div>

        <div class="col-sm-6 col-md-3">
            <div class="count_panel panel-five">
                <div class="stats-title">
                    <h4><?php echo display('withdraw')?></h4>
                    <i class="fa fa-reply-all"></i>
                </div>
                <p class="currency_text "><?php echo html_escape(@$coin_info->pair_with);?> <?php echo (@$total_withdraw->withdraw?number_format(html_escape($total_withdraw->withdraw),2):'0.0'); ?></p>
                <i class="fa fa-info-circle" data-toggle="tooltip" data-original-title="<?php echo display('total_withdraw_amount'); ?>"></i>
            </div>
        </div>

        <div class="col-sm-6 col-md-3">
            <div class="count_panel panel-six">
                <div class="stats-title">
                    <h4><?php echo display('token_sold')?></h4>
                    <i class="fa fa-database"></i>
                </div>
                <p class="currency_text "><?php echo html_escape(@$coin_info->symbol);?> <?php echo (@$sold_token->soldtoken?html_escape((int)$sold_token->soldtoken):'0'); ?></p>
                <i class="fa fa-info-circle" data-toggle="tooltip" data-original-title="<?php echo display('total_release_sold_token'); ?>"></i>
            </div>
        </div>

        <div class="col-sm-6 col-md-3">
            <div class="count_panel panel-blue">
                <div class="stats-title ">
                    <h4><?php echo display('token')?></h4>
                    <i class="fa fa-universal-access"></i>
                </div>
                <p class="currency_text"><?php echo html_escape(@$coin_info->symbol);?> <?php echo (@$token?html_escape($token):'0');?></p>
                <i class="fa fa-info-circle" data-toggle="tooltip" data-original-title="<?php echo display('total_token'); ?>"></i>
            </div>
        </div>

        <div class="col-sm-6 col-md-3">
            <div class="count_panel panel-seven">
                <div class="stats-title ">
                    <h4><?php echo display('total_fees'); ?></h4>
                    <i class="fa fa-balance-scale"></i>
                </div>
                <p class="currency_text"><?php echo html_escape(@$coin_info->pair_with); ?> <?php echo (@$total_earning_fees?number_format(html_escape($total_earning_fees), 2):'0.00');?></p>
                <i class="fa fa-info-circle" data-toggle="tooltip" data-original-title="<?php echo display('total_earning_fees'); ?>"></i>
            </div>
        </div>

        <div class="col-sm-6 col-md-3">
            <div class="count_panel panel-sky">
                <div class="stats-title ">
                    <h4><?php echo display('total_investment');?></h4>
                    <i class="fa fa-briefcase"></i>
                </div>
                <p class="currency_text"><?php echo html_escape(@$coin_info->pair_with); ?> <?php echo (@$total_investment->amount?number_format(html_escape($total_investment->amount), 2):'0.00');?></p>
                <i class="fa fa-info-circle" data-toggle="tooltip" data-original-title="<?php echo display('summation_all_user_invest'); ?>"></i>
            </div>
        </div>

        <div class="col-sm-6 col-md-3">
            <div class="count_panel panel-orenge">
                <div class="stats-title ">
                    <h4><?php echo display('total_roi')?></h4>
                    <i class="fa fa-pie-chart"></i>
                </div>
                <p class="currency_text"><?php echo html_escape(@$coin_info->pair_with); ?> <?php echo (@$total_roi->amount?number_format(html_escape($total_roi->amount), 2):'0.00');?></p>
                <i class="fa fa-info-circle" data-toggle="tooltip" data-original-title="<?php echo display('total_return_on_investment'); ?>"></i>
            </div>
        </div>

        <div class="col-sm-6 col-md-3">
            <div class="count_panel panel-slategrey">
                <div class="stats-title ">
                    <h4><?php echo display('secured_invt'); ?></h4>
                    <i class="fa fa-briefcase"></i>
                </div>
                <p class="currency_text"><?php echo html_escape(@$coin_info->pair_with);?> <?php echo (@$secured_investment->amount?number_format(html_escape($secured_investment->amount), 2):'0.00');?></p>
                <i class="fa fa-info-circle" data-toggle="tooltip" data-original-title="<?php echo display('summation_all_user_secured_package_investment'); ?>"></i>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="count_panel panel-violet">
                <div class="stats-title ">
                    <h4><?php echo display('gurenteed_invt'); ?></h4>
                    <i class="fa fa-briefcase"></i>
                </div>
                <p class="currency_text"><?php echo html_escape(@$coin_info->pair_with);?> <?php echo (@$gurenteed_investment->amount?number_format(html_escape($gurenteed_investment->amount), 2):'0.00');?></p>
                <i class="fa fa-info-circle" data-toggle="tooltip" data-original-title="<?php echo display('summation_all_user_gurenteed_package_investment'); ?>"></i>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="count_panel panel-sienna">
                <div class="stats-title ">
                    <h4><?php echo display('secured_roi'); ?></h4>
                    <i class="fa fa-pie-chart"></i>
                </div>
                <p class="currency_text"><?php echo html_escape(@$coin_info->pair_with);?> <?php echo (@$secured_roi->amount?number_format(html_escape($secured_roi->amount), 2):'0.00');?></p>
                <i class="fa fa-info-circle" data-toggle="tooltip" data-original-title="<?php echo display('secured_return_on_investment_roi'); ?>"></i>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="count_panel panel-tomato">
                <div class="stats-title ">
                    <h4><?php echo display('gurenteed_roi'); ?></h4>
                    <i class="fa fa-pie-chart"></i>
                </div>
                <p class="currency_text"><?php echo html_escape(@$coin_info->pair_with);?> <?php echo (@$gurenteed_roi->amount?number_format(html_escape($gurenteed_roi->amount), 2):'0.00');?></p>
                <i class="fa fa-info-circle" data-toggle="tooltip" data-original-title="<?php echo display('gurenteed_return_on_investment_roi'); ?>"></i>
            </div>
        </div>

        <!-- Flot Filled Area Chart -->
        <div class="col-sm-12 col-md-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="panel-title">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <h2><?php echo display('market_investment'); ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <canvas id="lineChart" height="140"></canvas>   
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-6">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="panel-title">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <h2><?php echo display('withdraw');?></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th><?php echo display('user_id') ?></th>
                                    <th><?php echo display('payment_method') ?></th>
                                    <th><?php echo display('amount') ?></th>
                                    <th><?php echo display('status') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty(@$withdraw)) ?>
                                <?php $sl = 1; ?>
                                <?php foreach ($withdraw as $value) { ?>
                                <tr>
                                    <td><?php echo html_escape($value->user_id); ?></td>
                                    <td><?php echo html_escape($value->method); ?></td>
                                    <td><?php echo html_escape($value->amount)+html_escape($value->fees_amount); ?></td>
                                    <td>
                                        <?php if($value->status==2){?>
                                         <a class="btn btn-warning btn-sm"><?php echo display('pending_withdraw')?></a>
                                         <?php } else if($value->status==1){?>
                                         <a class="btn btn-success btn-sm"><?php echo display('success')?></a>
                                         <?php } else if($value->status==0){ ?>
                                         <a class="btn btn-danger btn-sm"><?php echo display('cancel')?></a>
                                         <?php } ?>
                                     </td>
                                    
                                </tr>
                                <?php } ?> 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="panel-title">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <h2><?php echo display('deposit');?></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th><?php echo display('user_id') ?></th>
                                    <th><?php echo display('payment_method') ?></th>
                                    <th><?php echo display('amount') ?></th>
                                    <th><?php echo display('status') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty(@$deposit)) ?>
                                <?php $sl = 1; ?>
                                <?php foreach ($deposit as $value) { ?>
                                <tr>
                                    <td><?php echo html_escape($value->user_id); ?></td>
                                    <td><?php echo html_escape($value->method); ?></td>
                                    <td><?php echo html_escape($value->amount)+html_escape($value->fees_amount); ?></td>
                                    <td>
                                        <?php if($value->status==2){?>
                                         <a class="btn btn-warning btn-sm"><?php echo display('pending_withdraw')?></a>
                                         <?php } else if($value->status==1){?>
                                         <a class="btn btn-success btn-sm"><?php echo display('success')?></a>
                                         <?php } else if($value->status==0){ ?>
                                         <a class="btn btn-danger btn-sm"><?php echo display('cancel')?></a>
                                         <?php } ?>
                                     </td>
                                    
                                </tr>
                                <?php } ?> 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="panel-title">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <h2><?php echo display('exchange');?></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th><?php echo display('exchange_type'); ?></th>
                                    <th><?php echo display('crypto_qty'); ?></th>
                                    <th><?php echo display('crypto_rate'); ?></th>
                                    <th><?php echo display('complete_qty'); ?></th>
                                    <th><?php echo display('available_qty'); ?></th>
                                    <th><?php echo display('date'); ?></th>
                                    <th><?php echo display('status'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty(@$exchange)) ?>
                                <?php $sl = 1; ?>
                                <?php foreach ($exchange as $value) { ?>
                                <tr>
                                    <td><?php echo html_escape($value->exchange_type); ?></td>
                                    <td><?php echo html_escape($value->crypto_qty); ?></td>
                                    <td><?php echo html_escape($value->crypto_rate); ?></td>
                                    <td><?php echo html_escape($value->complete_qty); ?></td>
                                    <td><?php echo html_escape($value->available_qty); ?></td>
                                    <td><?php echo html_escape($value->datetime); ?></td>
                                    <td>
                                        <?php if($value->status==2){?>
                                         <a class="btn btn-warning btn-sm"><?php echo display('running')?></a>
                                         <?php } else if($value->status==1){?>
                                         <a class="btn btn-success btn-sm"><?php echo display('complete')?></a>
                                         <?php } else if($value->status==0){ ?>
                                         <a class="btn btn-danger btn-sm"><?php echo display('cancel')?></a>
                                         <?php } ?>
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




<!-- Modal body load from ajax start-->
<div class="modal fade modal-success" id="newModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
   <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h1 class="modal-title"><?php echo display('profile');?></h1>
        </div>
        <div class="modal-body">
            <table>
                <tr><td><strong><?php echo display('name');?> : </strong></td> <td id="name"></td></tr>
                <tr><td><strong><?php echo display('email');?> : </strong></td> <td id="email"></td></tr>
                <tr><td><strong><?php echo display('mobile');?> : </strong></td> <td id="phone"></td></tr>
                <tr><td><strong><?php echo display('user_id');?> : </strong></td> <td id="user_id"></td></tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo display('close'); ?></button>
        </div>
    </div><!-- /.modal-content -->
  </div>
</div>
<!-- Modal body load from ajax end-->