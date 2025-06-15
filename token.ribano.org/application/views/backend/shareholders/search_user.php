<div class="content">
	<div class="row">
		<div class="col-sm-12">

			 <?php echo form_open("backend/shareholders/shareholder/user_details") ?>
			<div class="form-group row">
                <label for="user_id" class="col-sm-2 col-form-label"><?php echo display('user_id'); ?>: </label>
                <div class="col-xs-2 col-sm-10 col-md-4 m-b-20">
                    <input name="user_id" class="form-control" type="search" id="user_id" value="<?php echo @$user->user_id ?>">
                </div>
                <div class="col-xs-2 col-sm-10 col-md-4 m-b-20">
                    <button type="submit" class="btn btn-success  w-md m-b-5"><?php echo display('search'); ?></button>
                </div>

            </div>
            <?php echo form_close() ?>

		</div>
	</div>
	<?php if(!empty($user)){ ?>
	    <div class="row">
	        <div class="col-xs-12 col-sm-12 col-md-12 m-b-20">
	            <!-- Nav tabs -->
	            <ul class="nav nav-tabs">
	                <li class="active"><a href="#tab1" data-toggle="tab"><?php echo display('user_profile') ?></a></li>
	                <li><a href="#tab2" data-toggle="tab"><?php echo display('balance'); ?></a></li>
	                <li><a href="#tab3" data-toggle="tab"><?php echo display('transaction_log'); ?></a></li>
	                <li><a href="#tab4" data-toggle="tab"><?php echo display('earning_history'); ?></a></li>
	            </ul>
	            <!-- Tab panels -->
	            <div class="tab-content">
	                <div class="tab-pane fade in active" id="tab1">
	                    <div class="panel-body">
			                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			                    <div class="form-group row">
			                        <label for="cid" class="col-sm-4 col-form-label"><?php echo display('user_id') ?></label>
			                        <div class="col-sm-8">
			                            <?php echo html_escape(@$user->user_id) ?></span>
			                        </div>
			                    </div>
			                    <div class="form-group row">
			                        <label for="cid" class="col-sm-4 col-form-label"><?php echo display('referral_id') ?></label>
			                        <div class="col-sm-8">
			                            <?php echo html_escape(@$user->referral_id) ?></span>
			                        </div>
			                    </div>
			                    <div class="form-group row">
			                        <label for="cid" class="col-sm-4 col-form-label"><?php echo display('language') ?></label>
			                        <div class="col-sm-8">
			                            <?php echo html_escape(@$user->language) ?></span>
			                        </div>
			                    </div>
			                    <div class="form-group row">
			                        <label for="cid" class="col-sm-4 col-form-label"><?php echo display('firstname') ?></label>
			                        <div class="col-sm-8">
			                            <?php echo html_escape(@$user->first_name) ?></span>
			                        </div>
			                    </div>
			                    <div class="form-group row">
			                        <label for="cid" class="col-sm-4 col-form-label"><?php echo display('lastname') ?></label>
			                        <div class="col-sm-8">
			                            <?php echo html_escape(@$user->last_name) ?></span>
			                        </div>
			                    </div>
			                    <div class="form-group row">
			                        <label for="cid" class="col-sm-4 col-form-label"><?php echo display('email') ?></label>
			                        <div class="col-sm-8">
			                            <?php echo html_escape(@$user->email) ?></span>
			                        </div>
			                    </div>
			                    <div class="form-group row">
			                        <label for="cid" class="col-sm-4 col-form-label"><?php echo display('mobile') ?></label>
			                        <div class="col-sm-8">
			                            <?php echo html_escape(@$user->phone) ?></span>
			                        </div>
			                    </div>
			                    <div class="form-group row">
			                        <label for="cid" class="col-sm-4 col-form-label"><?php echo display('registered_ip') ?></label>
			                        <div class="col-sm-8">
			                            <?php echo html_escape(@$user->ip) ?></span>
			                        </div>
			                    </div>
			                    <div class="form-group row">
			                        <label for="cid" class="col-sm-4 col-form-label"><?php echo display('status') ?></label>
			                        <div class="col-sm-8">
			                            <?php echo (@$user->status==1)?display('active'):display('inactive'); ?></span>
			                        </div>
			                    </div>
			                    <div class="form-group row">
			                        <label for="cid" class="col-sm-4 col-form-label">Registered Date</label>
			                        <div class="col-sm-8">
			                            <?php 
			                                $date=date_create(html_escape(@$user->created));
			                                echo date_format($date,"jS F Y");  
			                            ?></span>
			                        </div>
			                    </div>
			                </div>
			            </div>
	                </div>
	                <div class="tab-pane fade" id="tab2">
	                    <div class="panel-body">
	                    	<table class="datatable1 table table-bordered table-hover table-striped">
			                    <thead>
			                        <tr> 
			                            <th><?php echo display('type')?></th>
			                            <th><?php echo display('amount')?>(<?php echo html_escape($coin_setup->pair_with); ?>)</th>
			                        </tr>
			                    </thead>
			                    <tbody>
		                       			<tr>
			                                <td><?php echo $deposit_amount->transaction_type?html_escape($deposit_amount->transaction_type):'DEPOSIT' ?></td>
			                                <td><?php echo $deposit_amount->transaction_amount?number_format(html_escape($deposit_amount->transaction_amount),2):0.00; ?></td>
			                            </tr>
			                            <tr>
			                                <td><?php echo $credited_amount->transaction_type?html_escape($credited_amount->transaction_type):'CREDITED' ?></td>
			                                <td><?php echo $credited_amount->transaction_amount?number_format(html_escape($credited_amount->transaction_amount),2):0.00; ?></td>
			                            </tr>
			                            <tr>
			                                <td><?php echo $exchange_cancel_amount->transaction_type?html_escape($exchange_cancel_amount->transaction_type):'EXCHANGE_CANCEL' ?></td>
			                                <td><?php echo html_escape($exchange_cancel_amount->transaction_amount)+html_escape($exchange_cancel_amount_fees->transaction_fees) ?></td>
			                            </tr>
			                            <tr>
			                                <td><?php echo $recevied_amount->transaction_type?html_escape($recevied_amount->transaction_type):'RECEIVED' ?></td>
			                                <td><?php echo $recevied_amount->transaction_amount?number_format(html_escape($recevied_amount->transaction_amount),2):0.00; ?></td>
			                            </tr>
			                            <tr>
			                                <td><?php echo $sell_amount->transaction_type?html_escape($sell_amount->transaction_type):'SELL' ?></td>
			                                <td><?php echo html_escape($sell_amount->transaction_amount)-html_escape($sell_amount_fees->transaction_fees) ?></td>
			                            </tr>
			                            <tr>
			                                <td><?php echo @$return_amount->transaction_type?html_escape(@$return_amount->transaction_type):'ADJUSTMENT' ?></td>
			                                <td><?php echo html_escape(@$return_amount->transaction_amount)+html_escape($return_fees->transaction_fees); ?></td>
			                            </tr>
			                            <tr>
			                                <td><?php echo display('roi')?></td>
			                                <td><?php echo $roi_amount->amount?number_format(html_escape($roi_amount->amount),2):0.00; ?></td>
			                            </tr>
			                            <tr>
			                                <td><?php echo display('referral')?></td>
			                                <td><?php echo $referral_amount->amount?number_format(html_escape($referral_amount->amount)):0.00; ?></td>
			                            </tr>
			                            <tr>
			                                <td class="text-success text-center"><?php echo display('total');?> = </td>
			                                <td><?php echo html_escape($coin_setup->pair_with);?> <?php echo (html_escape($deposit_amount->transaction_amount)+html_escape($exchange_cancel_amount->transaction_amount)+html_escape($exchange_cancel_amount_fees->transaction_fees)+html_escape($recevied_amount->transaction_amount)+html_escape($sell_amount->transaction_amount)+html_escape($roi_amount->amount)+html_escape($credited_amount->transaction_amount)+html_escape($return_amount->transaction_amount)+html_escape($return_fees->transaction_fees)+html_escape($referral_amount->amount))-(html_escape($sell_amount_fees->transaction_fees)+html_escape($credited_amount_fees->transaction_fees)); ?></td>
			                            </tr>

			                            <tr>
			                            	<th>Cost(-)</th>
			                            	<td></td>
			                            </tr>


			                            <tr>
			                                <td><?php echo $transfer_amount->transaction_type?html_escape($transfer_amount->transaction_type):'TRANSFER' ?></td>
			                                <td><?php echo html_escape($transfer_amount->transaction_amount)+html_escape($transfer_amount_fees->transaction_fees); ?></td>
			                            </tr>
			                            <tr>
			                                <td><?php echo $withdraw_amount->transaction_type?html_escape($withdraw_amount->transaction_type):'WITHDRAW' ?></td>
			                                <td><?php echo html_escape($withdraw_amount->transaction_amount)+html_escape($withdraw_amount_fees->transaction_fees) ?></td>
			                            </tr>
			                            <tr>
			                                <td><?php echo $buy_amount->transaction_type?html_escape($buy_amount->transaction_type):'BUY' ?></td>
			                                <td><?php echo html_escape($buy_amount->transaction_amount)+html_escape($buy_amount_fees->transaction_fees) ?></td>
			                            </tr>
			                            <tr>
			                                <td><?php echo $invest_amount->transaction_type?html_escape($invest_amount->transaction_type):'INVESTMENT' ?></td>
			                                <td><?php echo html_escape($invest_amount->transaction_amount) ?></td>
			                            </tr>
			                            <tr>
			                                <td class="text-danger text-center"><?php echo display('total');?> = </td>
			                                <td><?php echo html_escape($coin_setup->pair_with);?> <?php echo html_escape($transfer_amount->transaction_amount)+html_escape($transfer_amount_fees->transaction_fees)+html_escape($withdraw_amount->transaction_amount)+html_escape($withdraw_amount_fees->transaction_fees)+html_escape($buy_amount->transaction_amount)+html_escape($buy_amount_fees->transaction_fees)+html_escape($invest_amount->transaction_amount) ?></td>
			                            </tr>
			                            <tr >
			                                <th colspan="2" class="text-success text-center"><?php echo display('your_total_balance_is');?> = <?php echo html_escape($coin_setup->pair_with); ?> <?php echo (html_escape($deposit_amount->transaction_amount)+html_escape($exchange_cancel_amount->transaction_amount)+html_escape($exchange_cancel_amount_fees->transaction_fees)+html_escape($recevied_amount->transaction_amount)+html_escape($sell_amount->transaction_amount)+html_escape($roi_amount->amount)+html_escape($credited_amount->transaction_amount)+html_escape($return_amount->transaction_amount)+html_escape($return_fees->transaction_fees)+html_escape($referral_amount->amount))-(html_escape($transfer_amount->transaction_amount)+html_escape($transfer_amount_fees->transaction_fees)+html_escape($withdraw_amount->transaction_amount)+html_escape($withdraw_amount_fees->transaction_fees)+html_escape($buy_amount->transaction_amount)+html_escape($buy_amount_fees->transaction_fees)+html_escape($invest_amount->transaction_amount)+html_escape($sell_amount_fees->transaction_fees)+html_escape($credited_amount_fees->transaction_fees)) ?></th>
			                            </tr>
		                        </tbody>
		                	</table>
	                    </div>
	                </div>
	                <div class="tab-pane fade" id="tab3">
	                    <div class="panel-body">
	                    	<table class="datatable1 table table-bordered table-hover table-striped">
			                    <thead>
	                                <tr class="table-bg">
	                                    <th>SL</th>
	                                    <th><?php echo display('transaction'); ?></th>
	                                    <th><?php echo display('amount'); ?>(<?php echo html_escape($coin_setup->pair_with);?>)</th>
	                                    <th><?php echo display('fees'); ?></th>
	                                    <th><?php echo display('date'); ?></th>
	                                </tr>
	                            </thead>
			                    <tbody>

	                       <?php $i=1;  foreach ($transection as $key => $value) { ?>
	                       		<tr>
	                       			<td><?php echo html_escape($i) ?></td>
	                                <td><?php echo html_escape($value->transaction_type) ?></td>
	                                <td><?php echo number_format(html_escape($value->transaction_amount),2); ?></td>
	                                <td><?php echo number_format(html_escape($value->transaction_fees),2); ?></td>
	                                <td><?php echo html_escape($value->date); ?></td>
		                        </tr>

		                    <?php html_escape($i++); } ?>
		                    	</tbody>
		                	</table>
	                    </div>
	                </div>
	                <div class="tab-pane fade" id="tab4">
	                    <div class="panel-body">
	                    	<table class="datatable1 table table-bordered table-hover table-striped">
			                    <thead>
	                                <tr class="table-bg">
	                                    <th>SL</th>
	                                    <th><?php echo display('type'); ?></th>
	                                    <th><?php echo display('amount'); ?>(<?php echo html_escape($coin_setup->pair_with);?>)</th>
	                                    <th><?php echo display('date'); ?></th>
	                                </tr>
	                            </thead>
			                    <tbody>

	                       <?php $i=1;  foreach ($earning as $key => $value) { ?>
	                       		<tr>
	                       			<td><?php echo html_escape($i);?></td>
	                                <td><?php echo html_escape($value->earning_type); ?></td>
	                                <td><?php echo number_format(html_escape($value->amount),2); ?></td>
	                                <td><?php echo html_escape($value->date); ?></td>
		                        </tr>

		                    <?php html_escape($i++); } ?>
		                    	</tbody>
		                	</table>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
    <?php }else{ ?>
    	<center><h3 class="text-danger">No Data Available</h3></center>
    <?php } ?>
</div>