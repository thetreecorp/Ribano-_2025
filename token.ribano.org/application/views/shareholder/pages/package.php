                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="block_title"><?php echo display('package');?></h3>
                            <?php if($package!=NULL){ ?>
                            <div class="owl-carousel owl-theme">
                                <?php 
                                    $i=1;
                                    foreach ($package as $key => $value) {  
                                ?>

                                <div class="item">
                                    <div class="pricing__item shadow navy__blue_<?php echo html_escape($i++);?>">
                                        <h3 class="pricing__title"><?php echo html_escape($value->package_name);?> (<?php echo html_escape($value->pack_type);?>)</h3>
                                        <div class="pricing__price"><span class="pricing__currency"><?php echo html_escape($stoinfo->pair_with); ?> </span><?php echo html_escape($value->package_price);?></div>
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
                                <?php } ?>
                            </div>
                            <!-- /.Packages -->
                            <?php }else{ ?>
                                <center><h3 class="text-danger">No Data Available</h3></center>
                            <?php } ?>
                    </div>
                </div>