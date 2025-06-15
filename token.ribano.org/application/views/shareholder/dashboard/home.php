
                <div class=" d-flex align-items-center form-group">
                    <label class="col-form-label m-0 mr-2"><?php echo display('affiliate_url');?> </label>
                    <div class="col-sm-6 input-group">
                        <input type="text" class="form-control" id="copyed" value="<?php echo base_url()?>register/?ref=<?php echo $this->session->userdata('user_id')?>">
                        <span class="input-group-btn">
                            <button class="btn btn-primary copy" type="button"><?php echo display('copy');?></button>
                        </span>
                    </div>
                   
                </div>
            
<!-- /.Social share -->
<div class="row">

            <?php
                $total_balance  = 0;
                $tokenValue     = 0;
            ?>
            <?php if (!empty($transaction)) { ?>
                <?php $data = json_decode($transaction->data); ?>

                <?php foreach ($data as $key => $value) { ?>

                    <?php

                        $rate = 0;
                        
                        foreach ($value as $keys => $values) { 
                            
                            $total_balance =  @$values->crypto_balance;
                            $rate          =  @$values->crypto_rate;
                        }
                }
                    $tokenValue = $total_balance*$rate;
            }

            ?>

    <div class="col-sm-6 col-md-4">
        <div class="count_panel panel-navy-blue">
            <div class="stats-title">
                <h4><?php echo display('balance');?></h4>
                <i class="fa fa-university"></i>
            </div>
            <h1 class="currency_text"><?php echo html_escape($stoinfo->pair_with)." ";?><?php echo $totalBalance->balance>0 ?number_format(html_escape($totalBalance->balance),2):0;?></h1>
            <i class="fa fa-info-circle" data-toggle="tooltip" data-original-title="<?php echo display('summation_of_all_deposit_sell_received_roi_and_referral_amount'); ?>"></i>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="count_panel panel-blue">
            <div class="stats-title ">
                <h4><?php echo display('token');?></h4>
                <i class="fa fa-universal-access"></i>
            </div>
            <h1 class="currency_text"><?php echo html_escape($stoinfo->symbol)." ";?><?php echo @$total_balance>0 ?html_escape(@$total_balance):0;?></h1>
            <i class="fa fa-info-circle" data-toggle="tooltip" data-original-title="<?php echo display('summation_of_all_your_buy_and_exchange_calculate_token'); ?>"></i>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="count_panel panel-seven">
            <div class="stats-title ">
                <h4><?php echo display('token_value');?></h4>
                <i class="fa fa-balance-scale"></i>
            </div>
            <h1 class="currency_text"><?php echo html_escape($stoinfo->symbol)." ";?><?php echo @$tokenValue>0 ?number_format(html_escape(@$tokenValue),2):0.00;?></h1>
            <i class="fa fa-info-circle" data-toggle="tooltip" data-original-title="<?php echo display('multiplication_of_all_token_and_token_rate'); ?>"></i>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-sm-12">
        <h3 class="block_title"><?php echo display('secured_package'); ?></h3>
        <div class="owl-carousel owl-theme">

            <?php if($securepackage!=NULL){ 
                $i=1;
                foreach ($securepackage as $key => $value) {  
            ?>

            <div class="item">
                <div class="pricing__item shadow navy__blue_<?php echo html_escape($i++);?>">
                    <h3 class="pricing__title"><?php echo html_escape($value->package_name);?></h3>
                    <div class="pricing__price"><span class="pricing__currency"><?php echo html_escape($stoinfo->pair_with); ?></span><?php echo html_escape($value->package_price);?></div>
                    <ul class="pricing__feature-list">
                        <?php if($value->facility_type==1){ ?>

                                <li class="pricing__feature">Share <span><?php echo html_escape($stoinfo->symbol)." ".html_escape($value->num_share);?></span></li>
                                <li class="pricing__feature"><?php echo display('period');?> <span><?php echo html_escape($value->period);?> days</span></li>
                                <li class="pricing__feature"><?php echo display('yearly_roi');?> <span><?php echo html_escape($stoinfo->pair_with); ?> <?php echo html_escape($value->yearly_roi);?></span></li>
                                <li class="pricing__feature"><?php echo display('monthly_roi');?> <span><?php echo html_escape($stoinfo->pair_with); ?> <?php echo html_escape($value->monthly_roi);?></span></li>
                                <li class="pricing__feature"><?php echo display('weekly_roi');?> <span><?php echo html_escape($stoinfo->pair_with); ?> <?php echo html_escape($value->weekly_roi);?></span></li>
                        
                        <?php }else{ ?>

                                <li class="pricing__feature"><?php echo display('num_share');?> <span><?php echo html_escape($stoinfo->symbol)." ".html_escape($value->num_share);?></span></li>
                                <li class="pricing__feature"><?php echo display('period');?> <span><?php echo html_escape($value->period);?> days</span></li>
                                <?php
                                    if(!empty($value->data)){
                                        $jsondata = json_decode($value->data,true); 
                                        foreach ($jsondata as $key => $row) {
                                ?>
                                            <li class="pricing__feature"><?php echo html_escape($row); ?></li>
                                <?php
                                            
                                        }
                                    }
                                ?>
                        <?php } ?>
                    </ul>
                    <a href="<?php echo base_url('shareholder/package/confirm_package/'.html_escape($value->package_id));?>" class="pricing__action center-block"><?php echo display('buy');?></a>
                </div>
                <!-- /.End of price item -->
            </div>
            <?php } }?>

        </div>
        <!-- /.Packages -->
</div>
</div>
<div class="row">
    <div class="col-sm-12">
        <h3 class="block_title"><?php echo display('guranteed_package'); ?></h3>
        <div class="owl-carousel owl-theme">

            <?php if($gurentedpackage!=NULL){ 
                $i=1;
                foreach ($gurentedpackage as $key => $value) {  
            ?>

            <div class="item">
                <div class="pricing__item shadow navy__blue_<?php echo html_escape($i++);?>">
                    <h3 class="pricing__title"><?php echo html_escape($value->package_name);?></h3>
                    <div class="pricing__price"><span class="pricing__currency"><?php echo html_escape($stoinfo->pair_with); ?></span><?php echo html_escape($value->package_price);?></div>
                    <ul class="pricing__feature-list">
                        <?php if($value->facility_type==1){ ?>

                                <li class="pricing__feature">Share <span><?php echo html_escape($stoinfo->symbol)." ".html_escape($value->num_share);?></span></li>
                                <li class="pricing__feature"><?php echo display('period');?> <span><?php echo html_escape($value->period);?> days</span></li>
                                <li class="pricing__feature"><?php echo display('yearly_roi');?> <span><?php echo html_escape($stoinfo->pair_with); ?> <?php echo html_escape($value->yearly_roi);?></span></li>
                                <li class="pricing__feature"><?php echo display('monthly_roi');?> <span><?php echo html_escape($stoinfo->pair_with); ?> <?php echo html_escape($value->monthly_roi);?></span></li>
                                <li class="pricing__feature"><?php echo display('weekly_roi');?> <span><?php echo html_escape($stoinfo->pair_with); ?> <?php echo html_escape($value->weekly_roi);?></span></li>
                        
                        <?php }else{ ?>

                                <li class="pricing__feature"><?php echo display('num_share');?> <span><?php echo html_escape($stoinfo->symbol)." ".html_escape($value->num_share);?></span></li>
                                <li class="pricing__feature"><?php echo display('period');?> <span><?php echo html_escape($value->period);?> days</span></li>
                                <?php
                                    if(!empty($value->data)){
                                        $jsondata = json_decode($value->data,true); 
                                        foreach ($jsondata as $key => $row) {
                                ?>
                                            <li class="pricing__feature"><?php echo html_escape($row); ?></li>
                                <?php
                                            
                                        }
                                    }
                                ?>
                        <?php } ?>
                    </ul>
                    <a href="<?php echo base_url('shareholder/package/confirm_package/'.$value->package_id);?>" class="pricing__action center-block"><?php echo display('buy');?></a>
                </div>
                <!-- /.End of price item -->
            </div>
            <?php } }?>

        </div>
        <!-- /.Packages -->
</div>
</div>