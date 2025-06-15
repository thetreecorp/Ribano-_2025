<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        <div class="panel panel-bd ">
            <div class="panel-heading ui-sortable-handle">
                <div class="panel-title max-width-calc">
                    <h4><?php echo display('transection');?></h4>
                </div>
            </div>
            <div class="panel-body">
                        
                    <div class="table-responsive">
                        <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th><?php echo display('type');?></th>
                            <th><?php echo display('amount');?> (<?php echo html_escape($coin_setup->pair_with);?>)</th>
                            <th><?php echo display('fees');?> (<?php echo html_escape($coin_setup->pair_with);?>)</th>
                            <th><?php echo display('total');?></th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr>
                                <th><?php echo $deposit_amount->transaction_type?html_escape($deposit_amount->transaction_type):'DEPOSIT' ?></th>
                                <td><?php echo html_escape($deposit_amount->transaction_amount) ?></td>
                                <td><?php echo html_escape($deposit_amount_fees->transaction_fees) ?></td>
                                <td><?php echo html_escape($deposit_amount->transaction_amount) ?></td>
                            </tr>

                            <tr>
                                <th><?php echo $credited_amount->transaction_type?html_escape($credited_amount->transaction_type):'CREDITED' ?></th>
                                <td><?php echo html_escape($credited_amount->transaction_amount) ?></td>
                                <td><?php echo html_escape($credited_amount_fees->transaction_fees) ?></td>
                                <td><?php echo html_escape($credited_amount->transaction_amount)+html_escape($credited_amount_fees->transaction_fees) ?></td>
                            </tr>

                            <tr>
                                <th><?php echo $exchange_cancel_amount->transaction_type?html_escape($exchange_cancel_amount->transaction_type):'EXCHANGE_CANCEL' ?></th>
                                <td><?php echo html_escape($exchange_cancel_amount->transaction_amount) ?></td>
                                <td><?php echo html_escape($exchange_cancel_amount_fees->transaction_fees) ?></td>
                                <td><?php echo html_escape($exchange_cancel_amount->transaction_amount)+html_escape($exchange_cancel_amount_fees->transaction_fees) ?></td>
                            </tr>

                            <tr>
                                <th><?php echo $recevied_amount->transaction_type?html_escape($recevied_amount->transaction_type):'RECEIVED' ?></th>
                                <td><?php echo html_escape($recevied_amount->transaction_amount) ?></td>
                                <td>0.00000000</td>
                                <td><?php echo html_escape($recevied_amount->transaction_amount); ?></td>
                            </tr>

                            <tr>
                                <th><?php echo $sell_amount->transaction_type?html_escape($sell_amount->transaction_type):'SELL' ?></th>
                                <td><?php echo html_escape($sell_amount->transaction_amount) ?></td>
                                <td><?php echo html_escape($sell_amount_fees->transaction_fees) ?></td>
                                <td><?php echo html_escape($sell_amount->transaction_amount)-html_escape($sell_amount_fees->transaction_fees) ?></td>
                            </tr>

                            <tr>
                                <th><?php echo @$return_amount->transaction_type?html_escape(@$return_amount->transaction_type):'ADJUSTMENT' ?></th>
                                <td><?php echo html_escape(@$return_amount->transaction_amount)+html_escape($return_fees->transaction_fees); ?></td>
                                <td>0.00000000</td>
                                <td><?php echo html_escape(@$return_amount->transaction_amount)+html_escape($return_fees->transaction_fees); ?></td>
                            </tr>

                            <tr>
                                <th><?php echo display('roi')?></th>
                                <td><?php echo html_escape($roi_amount->amount) ?></td>
                                <td>0.00000000</td>
                                <td><?php echo html_escape($roi_amount->amount) ?></td>
                            </tr>

                            <tr>
                                <th><?php echo display('referral')?></th>
                                <td><?php echo html_escape($referral_amount->amount) ?></td>
                                <td>0.00000000</td>
                                <td><?php echo html_escape($referral_amount->amount) ?></td>
                            </tr>


                            <tr>
                                <td colspan="3" class="text-success text-center"><?php echo display('total');?> = </td>
                                <td><?php echo html_escape($coin_setup->pair_with);?> <?php echo (html_escape($deposit_amount->transaction_amount)+html_escape($exchange_cancel_amount->transaction_amount)+html_escape($exchange_cancel_amount_fees->transaction_fees)+html_escape($recevied_amount->transaction_amount)+html_escape($sell_amount->transaction_amount)+html_escape($roi_amount->amount)+html_escape($credited_amount->transaction_amount)+html_escape($return_amount->transaction_amount)+html_escape($return_fees->transaction_fees)+html_escape($referral_amount->amount))-(html_escape($sell_amount_fees->transaction_fees)+html_escape($credited_amount_fees->transaction_fees)); ?></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th><?php echo display('type');?></th>
                                <th><?php echo display('amount');?></th>
                                <th><?php echo display('fees');?></th>
                                <th><?php echo display('total');?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th><?php echo $transfer_amount->transaction_type?html_escape($transfer_amount->transaction_type):'TRANSFER' ?></th>
                                <td><?php echo html_escape($transfer_amount->transaction_amount) ?></td>
                                <td><?php echo html_escape($transfer_amount_fees->transaction_fees) ?></td>
                                <td><?php echo html_escape($transfer_amount->transaction_amount)+html_escape($transfer_amount_fees->transaction_fees) ?></td>
                            </tr>

                            <tr>
                                <th><?php echo $withdraw_amount->transaction_type?html_escape($withdraw_amount->transaction_type):'WITHDRAW' ?></th>
                                <td><?php echo html_escape($withdraw_amount->transaction_amount) ?></td>
                                <td><?php echo html_escape($withdraw_amount_fees->transaction_fees) ?></td>
                                <td><?php echo html_escape($withdraw_amount->transaction_amount)+html_escape($withdraw_amount_fees->transaction_fees) ?></td>
                            </tr>

                            <tr>
                                <th><?php echo $buy_amount->transaction_type?html_escape($buy_amount->transaction_type):'BUY' ?></th>
                                <td><?php echo html_escape($buy_amount->transaction_amount) ?></td>
                                <td><?php echo html_escape($buy_amount_fees->transaction_fees); ?></td>
                                <td><?php echo html_escape($buy_amount->transaction_amount)+html_escape($buy_amount_fees->transaction_fees) ?></td>
                            </tr>
                            <tr>
                                <th><?php echo $invest_amount->transaction_type?html_escape($invest_amount->transaction_type):'INVESTMENT' ?></th>
                                <td><?php echo html_escape($invest_amount->transaction_amount) ?></td>
                                <td>0.00000000</td>
                                <td><?php echo html_escape($invest_amount->transaction_amount) ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-danger text-center"><?php echo display('total');?> = </td>
                                <td><?php echo html_escape($coin_setup->pair_with);?> <?php echo html_escape($transfer_amount->transaction_amount)+html_escape($transfer_amount_fees->transaction_fees)+html_escape($withdraw_amount->transaction_amount)+html_escape($withdraw_amount_fees->transaction_fees)+html_escape($buy_amount->transaction_amount)+html_escape($buy_amount_fees->transaction_fees)+html_escape($invest_amount->transaction_amount) ?></td>
                            </tr>
                            <tr >
                                <th colspan="4" class="text-success text-center"><?php echo display('your_total_balance_is');?> = <?php echo html_escape($coin_setup->pair_with);?> <?php echo (html_escape($deposit_amount->transaction_amount)+html_escape($exchange_cancel_amount->transaction_amount)+html_escape($exchange_cancel_amount_fees->transaction_fees)+html_escape($recevied_amount->transaction_amount)+html_escape($sell_amount->transaction_amount)+html_escape($roi_amount->amount)+html_escape($credited_amount->transaction_amount)+html_escape($return_amount->transaction_amount)+html_escape($return_fees->transaction_fees)+html_escape($referral_amount->amount))-(html_escape($transfer_amount->transaction_amount)+html_escape($transfer_amount_fees->transaction_fees)+html_escape($withdraw_amount->transaction_amount)+html_escape($withdraw_amount_fees->transaction_fees)+html_escape($buy_amount->transaction_amount)+html_escape($buy_amount_fees->transaction_fees)+html_escape($invest_amount->transaction_amount)+html_escape($sell_amount_fees->transaction_fees)+html_escape($credited_amount_fees->transaction_fees)) ?></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        <div class="panel panel-bd ">
            <div class="panel-heading ui-sortable-handle">
                <div class="panel-title max-width-calc">
                    <h4><?php echo display('transection');?></h4>
                </div>
            </div>
            <div class="panel-body">
                <div class="border_preview">

                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered datatable2">
                            <thead>
                                <tr>
                                    <th><?php echo display('date');?></th>
                                    <th><?php echo display('transection_category');?></th>
                                    <th><?php echo display('balance');?>(<?php echo html_escape($coin_setup->pair_with);?>)</th>
                                    <th><?php echo display('fees');?>(<?php echo html_escape($coin_setup->pair_with);?>)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($transection!=NULL){ 
                                    foreach ($transection as $key => $value) {  
                                ?>
                                <tr>
                                    <td><?php echo html_escape($value->date);?></td>
                                    <td><?php echo html_escape($value->transaction_type);?></td>
                                    <td><?php echo html_escape($value->transaction_amount);?></td>
                                    <td><?php echo html_escape($value->transaction_fees);?></td>
                                </tr>
                                <?php } } ?>

                            </tbody>
                        </table>
                        <?php echo htmlspecialchars_decode($links); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>