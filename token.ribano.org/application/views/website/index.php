
        <!-- /.End of sidebar nav -->
        <header class="header-content">
            <div class="social d-none d-sm-none d-md-none d-lg-none d-xl-block"> <a class="text">social links</a>
                <div class="line-shape"></div>

                <?php if($social_link){ foreach ($social_link as $key => $value) { ?>
                    <a target="_blank" href="<?php echo html_escape(@$value->link); ?>"><i class="fab fa-<?php echo html_escape($value->icon) ?>"></i></a>
                <?php } } ?>
            </div>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-sm-12 col-md-12 col-lg-8 offset-lg-2">
                        <div class="header-text text-center">
                            
                            <h1><?php echo !empty($articlehome->data_headline)?htmlspecialchars_decode($articlehome->data_headline):"A new business model that mitigates risks for investors."; ?></h1>
                        </div>
                        <div class="token-wrap">
                            <div class="token-title">
                                <h3><?php echo !empty($articlehome->data_title)?htmlspecialchars_decode($articlehome->data_title):"ISTO PRE - SALE IS LIVE"; ?></h3>
                                <div class="sub-title"><?php echo !empty($articlehome->article_1)?htmlspecialchars_decode($articlehome->article_1):"Round one ends in:"; ?></div>
                            </div>
                            <div class="countdown">
                                <div class="clock"></div>
                                <div class="message"></div>
                            </div>
                            <!--/.countdown-->
                            <?php
                                if(@$flipdata->target !=0){
                                    $percent  = (@$flipdata->fillup_target*100)/@$flipdata->target;
                                }
                                else{
                                    $percent = 0;
                                }
                            ?>
                            <div class="loading-bar position-relative">
                                <div class="progres-area">
                                    <h6><?php echo str_replace("{release_token}","<span>".(@$flipdata->target?@$flipdata->target:0)."</span>",htmlspecialchars_decode($articlehome->article_2));?></h6>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width:<?php echo htmlspecialchars_decode(@$percent);?>%" aria-valuenow="<?php echo html_escape(@$percent);?>%" aria-valuemin="0" aria-valuemax="100"><font <?php echo $percent>=40?"color='#fff'":"color='#000'"; ?>><?php echo !empty(@$flipdata->fillup_target)?(number_format(html_escape(@$flipdata->fillup_target),0)." ".html_escape(@$rcoin_info->symbol)." / ".html_escape(@$flipdata->target)." ".html_escape(@$rcoin_info->symbol)):(""); ?></font></div>
                                    </div><!-- /.End of progress -->
                                    <div class="progress-bar-down">
                                        <div class="progress-info"><?php echo html_escape(@$percent);?>% target raised</div>
                                        <div class="progress-info"><?php echo !empty(@$rcoin_info->symbol)?("1 ".html_escape(@$rcoin_info->symbol)." = ".html_escape(@$rcoin_info->rate)." ".html_escape(@$rcoin_info->pair_with)):""; ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center align-items-center">
                                <div><a href="<?php echo base_url('shareholder/token/token_buy')?>" class="btn">Buy Token</a></div>
                                <div class="play-button"> <a href="<?php echo $articlehome->video; ?>" class="btn-play popup-youtube">
                                        <div class="bubble-btn"> <span class="bubble-ripple"> <span class="bubble-ripple-inner"></span> </span> <span><i class="fas fa-play"></i></span> </div>
                                        <div class="play-text">
                                            <div class="btn-title-inner">
                                                <div class="btn-title"><span>Watch Video</span></div>
                                                <div class="btn-subtitle"><span>How It Work</span></div>
                                            </div>
                                        </div>
                                    </a> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- /.End of header content -->
        <div class="section section-pad run-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                        <div class="section-title text-center">

                            <h2><?php echo !empty($level1[0]->data_headline)?(htmlspecialchars_decode($level1[0]->data_headline)):"Run Your STO from Anywhere"; ?></h2>
                            <p><?php echo !empty($level1[0]->article_1)?htmlspecialchars_decode($level1[0]->article_1):"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed quis accumsan nisi Ut ut felis 
                                congue nisl hendrerit commodo."; ?></p>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <?php foreach ($aboutcoin as $key => $value) { ?>
                                
                                <div class="col-sm-6 col-md-6 col-lg-3">
                                    <div class="run-card">
                                        <h4><?php echo htmlspecialchars_decode($value->data_headline); ?></h4>
                                        <p><?php echo htmlspecialchars_decode($value->article_1); ?></p>
                                    </div>
                                </div>                 
                    <?php } ?>

                </div>
            </div>
        </div>
        <!-- End of STO run content -->
        <div id="about" class="section section-pad about-content">
            <div class="container">
                <div class="row about-text align-items-center">
                    <div class="col-md-6 col-lg-6">
                        <div class="about-graph text-right"><img src="<?php echo !empty($articleabout->article_image)?base_url("$articleabout->article_image"):base_url('assets/website/img/ico-coin2.png'); ?>" class="img-fluid" alt=""> </div>
                    </div>
                    <div class="col-md-6 col-lg-6 order-md-first order-last">
                        <div class="about-info">

                            <h2><?php echo !empty($articleabout->data_headline)?htmlspecialchars_decode($articleabout->data_headline):"What is an STO?"; ?></h2>
                            <div class="definition"><?php echo !empty($articleabout->data_title)?htmlspecialchars_decode($articleabout->data_title):"STO stands for security token offering."; ?></div>
                            <p><?php echo !empty($articleabout->article_1)?htmlspecialchars_decode($articleabout->article_1):""; ?></p>
                            <div class="d-flex">
                                <div><a href="#" class="btn">Buy Tokens</a></div>
                                <div class="play-button"> <a href="<?php echo !empty($articleabout->video)?html_escape($articleabout->video):"";?>" class="btn-play popup-youtube">
                                        <div class="bubble-btn"> <span class="bubble-ripple"> <span class="bubble-ripple-inner"></span> </span> <span><i class="fas fa-play"></i></span> </div>
                                        <div class="play-text">
                                            <div class="btn-title-inner">
                                                <div class="btn-title"><span>Watch Video</span></div>
                                                <div class="btn-subtitle"><span>How It Work</span></div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.End of about section -->
        <div id="RoadMap" class="section section-pad timeline">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                        <div class="section-title2">
                            <h2 data-title="RoadMap" class="section-title-dash">
                                RoadMap 
                                <span class="dashborder">&nbsp;</span>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="timeline_chart">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            
                            <?php foreach ($roadmaparticle as $key => $value) { ?>
                                    
                                        <div class="timeline_event">
                                            <div class="timeline_event_content">
                                                <div class="line line-left"></div>
                                                <div class="timeline_event_date"><?php echo date("F Y", strtotime(html_escape($value->publish_date))); ?></div>
                                                <div class="timeline_event_title"> <span><?php echo !empty($value->data_headline)?htmlspecialchars_decode($value->data_headline):"Bitcoin public trading launched"; ?></span> </div>
                                                <div class="timeline_event_info">
                                                    <div class="timeline_event_text"> <span><?php
                                                        echo htmlspecialchars_decode($value->article_1);
                                                    ?>
                                                    </span> </div>
                                                    <div class="timeline_event_CapValue"><?php echo htmlspecialchars_decode($value->article_data); ?></div>
                                                    <div class="timeline_event_Cap"> <span><?php
                                                        echo htmlspecialchars_decode($value->article_2);
                                                    ?></span> </div>
                                                </div>
                                            </div>
                                        </div>

                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.End of RoadMap content -->
        <div class="section section-pad token-distribution" id="token">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                        <div class="section-title text-center">

                            <h2><?php echo !empty($level2[0]->data_headline)?(htmlspecialchars_decode($level2[0]->data_headline)):"Token Distribution"; ?></h2>
                            <p><?php echo !empty($level2[0]->article_1)?htmlspecialchars_decode($level2[0]->article_1):"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed quis accumsan nisi Ut ut felis 
                                congue nisl hendrerit commodo."; ?></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="token-chart">
                            <h4>Total Token Distribution</h4>
                            <div id="eChart_1"></div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="token-chart">
                            <h4>Token Sales Graph</h4>
                            <div id="eChart_2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.End of token distribution --> 
        <div id="secured" class="section section-pad secured-sto">
            <div class="container pricing-section bg-11">
                <div class="row">
                    <div class="col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                        <div class="section-title text-center">
                            <h2><?php echo !empty($level3[0]->data_headline)?(htmlspecialchars_decode($level3[0]->data_headline)):"Secured STO"; ?></h2>
                            <p><?php echo !empty($level3[0]->article_1)?htmlspecialchars_decode($level3[0]->article_1):"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed quis accumsan nisi Ut ut felis 
                                congue nisl hendrerit commodo."; ?></p>
                        </div>
                    </div>
                </div>
                <div class="pricing pricing--tenzin">

                <?php if($securepack!=NULL){
                    $i=1;
                    foreach ($securepack as $key => $value) {  
                ?>

                    <div class="pricing__item text-center">
                        <h3 class="pricing__title"><?php echo html_escape($value->package_name);?></h3>
                        <div class="pricing__price"><span class="pricing__currency"><?php echo html_escape($stoinfo->pair_with); ?> </span><?php echo html_escape($value->package_price);?></div>
                        <ul class="pricing__feature-list">

                            <?php if($value->facility_type==1){ ?>

                                    <li class="pricing__feature">Share <span><?php echo html_escape($stoinfo->symbol)." ".html_escape($value->num_share);?></span></li>
                                    <li class="pricing__feature"><?php echo display('period');?> <span><?php echo html_escape($value->period);?> days</span></li>
                                    <li class="pricing__feature"><?php echo display('yearly_roi');?> <span><?php echo html_escape($stoinfo->pair_with); ?> <?php echo html_escape($value->yearly_roi);?></span></li>
                                    <li class="pricing__feature"><?php echo display('monthly_roi');?> <span><?php echo html_escape($stoinfo->pair_with); ?> <?php echo html_escape($value->monthly_roi);?></span></li>
                                    <li class="pricing__feature"><?php echo display('weekly_roi');?> <span><?php echo html_escape($stoinfo->pair_with); ?> <?php echo html_escape($value->weekly_roi);?></span></li>
                                    

                            <?php }else{ ?>

                                    <li class="pricing__feature">Share <span><?php echo html_escape($stoinfo->symbol)." ".html_escape($value->num_share);?></span></li>
                                    <li class="pricing__feature"><?php echo display('period');?> <span><?php echo html_escape($value->period);?> days</span></li>
                                    <?php if(!empty($value->product_discount)){ ?>
                                            <li class="pricing__feature">Product Discount <?php echo html_escape($value->product_discount); ?>%</li>
                                    <?php } ?>

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
                        <a href="<?php echo base_url('shareholder/package/confirm_package/'.html_escape($value->package_id));?>"><button class="pricing__action">Choose plan</button></a>
                    </div>
                    <!-- /.End of price item -->
                <?php } } // End of if&Foreach Loop ?>
                </div>
            </div><!-- /.pricing -->
        </div><!-- End of secured sto -->
        <div id="guaranteed" class="section section-pad guaranteed">
            <div class="container pricing-section bg-11">
                <div class="row">
                    <div class="col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                        <div class="section-title text-center">

                            <h2><?php echo !empty($level4[0]->data_headline)?(htmlspecialchars_decode($level4[0]->data_headline)):"Guaranteed STO"; ?></h2>
                            <p><?php echo !empty($level4[0]->article_1)?htmlspecialchars_decode($level4[0]->article_1):"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed quis accumsan nisi Ut ut felis 
                                congue nisl hendrerit commodo."; ?></p>
                        </div>
                    </div>
                </div>
                <div class="pricing pricing--tenzin">
                <?php if($guranteedpack!=NULL){
                    $i=1;
                    foreach ($guranteedpack as $key => $value) {  
                ?>

                    <div class="pricing__item text-center">
                        <h3 class="pricing__title"><?php echo html_escape($value->package_name);?></h3>
                        <div class="pricing__price"><span class="pricing__currency"><?php echo html_escape($stoinfo->pair_with); ?> </span><?php echo html_escape($value->package_price);?></div>
                        <ul class="pricing__feature-list">
                            <?php if($value->facility_type==1){ ?>

                                    <li class="pricing__feature">Share <span><?php echo html_escape($stoinfo->symbol)." ".html_escape($value->num_share);?></span></li>
                                    <li class="pricing__feature"><?php echo display('period');?> <span><?php echo html_escape($value->period);?> days</span></li>
                                    <li class="pricing__feature"><?php echo display('yearly_roi');?> <span><?php echo html_escape($stoinfo->pair_with); ?> <?php echo html_escape($value->yearly_roi);?></span></li>
                                    <li class="pricing__feature"><?php echo display('monthly_roi');?> <span><?php echo html_escape($stoinfo->pair_with); ?> <?php echo html_escape($value->monthly_roi);?></span></li>
                                    <li class="pricing__feature"><?php echo display('weekly_roi');?> <span><?php echo html_escape($stoinfo->pair_with); ?> <?php echo html_escape($value->weekly_roi);?></span></li>
                                    

                            <?php }else{ ?>

                                    <li class="pricing__feature">Share <span><?php echo html_escape($stoinfo->symbol)." ".html_escape($value->num_share);?></span></li>
                                    <li class="pricing__feature"><?php echo display('period');?> <span><?php echo html_escape($value->period);?> days</span></li>
                                    <?php if(!empty($value->product_discount)){ ?>
                                            <li class="pricing__feature">Product Discount <?php echo html_escape($value->product_discount); ?>%</li>
                                    <?php } ?>

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
                        <a href="<?php echo base_url('shareholder/package/confirm_package/'.html_escape($value->package_id));?>"><button class="pricing__action">Choose plan</button></a>
                    </div>
                    <!-- /.End of price item -->
                <?php } } // End of if&Foreach Loop ?>
                </div>
            </div><!-- /.pricing -->
        </div><!-- End of secured sto -->
        <div class="section-pad">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                        <div class="section-title text-center">

                            <h2><?php echo !empty($level5[0]->data_headline)?(htmlspecialchars_decode($level5[0]->data_headline)):"Legal purpose"; ?></h2>
                            <p><?php echo !empty($level5[0]->article_1)?htmlspecialchars_decode($level5[0]->article_1):"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed quis accumsan nisi Ut ut felis 
                                congue nisl hendrerit commodo."; ?></p>

                        </div>
                    </div>
                </div>
                <div class="legal-purpose">

                    <?php foreach ($legeldocuments as $key => $value) { ?>

                            <a href="<?php echo base_url("$value->upload_file"); ?>" target="_blank" class="certificate-box">
                                <img src="<?php echo base_url("$value->thumbali"); ?>" class="img-fluid" alt="<?php echo html_escape($value->title); ?>">
                            </a>
                            
                    <?php } ?>
                    
                </div>
            </div>
        </div>
        <!-- /.End of legal purpose -->
        <div id="team" class="section team-section section-pad">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                        <div class="section-title text-center">
                            <h2><?php echo !empty($level6[0]->data_headline)?(htmlspecialchars_decode($level6[0]->data_headline)):"Meet our (awesome) team"; ?></h2>
                            <p><?php echo !empty($level6[0]->article_1)?htmlspecialchars_decode($level6[0]->article_1):"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed quis accumsan nisi Ut ut felis 
                                congue nisl hendrerit commodo."; ?></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="o-separator">
                            <hr><p class="o-separator-text">Leadership</p><hr>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">

                    <?php foreach($teamleadership as $key => $value){ ?>

                            <div class="col-6 col-sm-6 col-md-3 col-lg-2">
                                <article class="team-member">
                                    <img src="<?php echo base_url("$value->article_image"); ?>" class="img-fluid" alt="">
                                    <div class="member-info">
                                        <h5 class="member-name m-0"><?php echo htmlspecialchars_decode($value->article_data); ?></h5>
                                        <p><?php echo htmlspecialchars_decode($value->custom_data); ?></p>
                                    </div>
                                </article>
                            </div>

                    <?php } ?>

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="o-separator">
                            <hr><p class="o-separator-text">Team Member</p><hr>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">

                    <?php foreach($teammemeber as $key => $value){ ?>

                                <div class="col-6 col-sm-6 col-md-3 col-lg-2">
                                    <article class="team-member">
                                        <img src="<?php echo base_url("$value->article_image"); ?>" class="img-fluid" alt="">
                                        <div class="member-info">
                                            <h5 class="member-name m-0"><?php echo htmlspecialchars_decode($value->article_data); ?></h5>
                                            <p><?php echo htmlspecialchars_decode($value->custom_data); ?></p>
                                        </div>
                                    </article>
                                </div>

                    <?php } ?>
                    
                </div>
            </div>
        </div>
        <!-- /. End of team content-->
        <div id="faq" class="section section-pad faq-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                        <div class="section-title text-center">
                            <h2><?php echo !empty($level7[0]->data_headline)?(htmlspecialchars_decode($level7[0]->data_headline)):"Frequently Asked Questions"; ?></h2>
                            <p><?php echo !empty($level7[0]->article_1)?htmlspecialchars_decode($level7[0]->article_1):"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed quis accumsan nisi Ut ut felis 
                                congue nisl hendrerit commodo."; ?></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="faq-tab">
                            <nav>
                                <div class="nav nav-tabs justify-content-center" id="nav-tab" role="tablist"> 
                                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Regular Questation</a>
                                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Clients Questation</a>
                                    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Trending  Questation</a>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul class="accordion">

                                                <?php foreach($askquestionsregular as $key => $value){ ?>

                                                <?php if($value->article_id%2!=0){ ?>

                                                        <li><a><?php echo htmlspecialchars_decode($value->data_headline); ?></a>
                                                            <p><?php echo htmlspecialchars_decode($value->article_1); ?></p>
                                                        </li>

                                                <?php } } ?>

                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul class="accordion">

                                                <?php foreach($askquestionsregular as $key => $value){ ?>

                                                <?php if($value->article_id%2==0){ ?>

                                                        <li><a><?php echo htmlspecialchars_decode($value->data_headline); ?></a>
                                                            <p><?php echo htmlspecialchars_decode($value->article_1); ?></p>
                                                        </li>

                                                <?php } } ?>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul class="accordion">
                                                <?php foreach($askquestionsclient as $key => $value){ ?>

                                                <?php if($value->article_id%2!=0){ ?>

                                                        <li><a><?php echo htmlspecialchars_decode($value->data_headline); ?></a>
                                                            <p><?php echo htmlspecialchars_decode($value->article_1); ?></p>
                                                        </li>

                                                <?php } } ?>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul class="accordion">
                                                <?php foreach($askquestionsclient as $key => $value){ ?>

                                                <?php if($value->article_id%2==0){ ?>

                                                        <li><a><?php echo htmlspecialchars_decode($value->data_headline); ?></a>
                                                            <p><?php echo htmlspecialchars_decode($value->article_1); ?></p>
                                                        </li>

                                                <?php } } ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul class="accordion">
                                                <?php foreach($askquestionstrend as $key => $value){ ?>

                                                <?php if($value->article_id%2!=0){ ?>

                                                        <li><a><?php echo htmlspecialchars_decode($value->data_headline); ?></a>
                                                            <p><?php echo htmlspecialchars_decode($value->article_1); ?></p>
                                                        </li>

                                                <?php } } ?>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul class="accordion">
                                                <?php foreach($askquestionstrend as $key => $value){ ?>

                                                <?php if($value->article_id%2==0){ ?>

                                                        <li><a><?php echo htmlspecialchars_decode($value->data_headline); ?></a>
                                                            <p><?php echo htmlspecialchars_decode($value->article_1); ?></p>
                                                        </li>

                                                <?php } } ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.End of faq content -->
        <div id="blog" class="section section-pad blog-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                        <div class="section-title text-center">

                            <h2><?php echo !empty($level8[0]->data_headline)?(htmlspecialchars_decode($level8[0]->data_headline)):"Recent Blogs Posts"; ?></h2>
                            <p><?php echo !empty($level8[0]->article_1)?htmlspecialchars_decode($level8[0]->article_1):"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed quis accumsan nisi Ut ut felis 
                                congue nisl hendrerit commodo."; ?></p>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <?php foreach($blog as $key => $value){ 

                            $bloglink = $value->custom_data;
                            $caregory = strtolower($value->slug);
                    ?>

                            <div class="col-md-4">
                                <article class="post-grid">
                                    <figure> <a href="<?php echo base_url("blog/$caregory/$bloglink"); ?>"> <img src="<?php echo !empty($value->article_image)?base_url("$value->article_image"):base_url('assets/website/img/blog/600x394-1.jpg'); ?>" class="img-fluid" alt=""> </a> </figure>
                                    <span><a href="<?php echo base_url("blog/$caregory"); ?>"><?php echo strtoupper(html_escape($value->slug)); ?></a></span>
                                    <h4 class="post-title"><a href="<?php echo base_url("blog/$caregory/$bloglink"); ?>"><?php echo htmlspecialchars_decode($value->data_headline); ?></a></h4>
                                    <p class="post-des"><?php echo substr(strip_tags(htmlspecialchars_decode($value->article_1)), 0, 110); ?></p>
                                    <div class="information"> 
                                        <span>
                                            <?php
                                                $date=date_create($value->publish_date);
                                                echo date_format($date,"jS, F Y");
                                            ?>
                                        </span>
                                    </div>
                                </article>

                                <!-- /.End of post grid --> 
                            </div>    

                    <?php } ?>
                    
                </div>
            </div>
        </div>
        <!-- /.End of blog section -->
        <div id="contact" class="section section-pad contact-info">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                        <div class="section-title text-center">
                            <h2><?php echo !empty($level9[0]->data_headline)?(htmlspecialchars_decode($level9[0]->data_headline)):"For STO Projects"; ?></h2>
                            <p><?php echo !empty($level9[0]->article_1)?htmlspecialchars_decode($level9[0]->article_1):"Coinsurance invests in promising STO projects. We offer you a funding and access to our community."; ?></p>
                        </div>
                    </div>
                </div>
                <div class="row"> 
                    <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-2">
                        <div class="feedback">
                            <!-- alert message -->
                            <?php if ($this->session->flashdata('message') != null) {  ?>
                            <div class="alert alert-info alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <?php echo $this->session->flashdata('message'); ?>
                            </div> 
                            <?php } ?>
                            
                            <?php if ($this->session->flashdata('exception') != null) {  ?>
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <?php echo $this->session->flashdata('exception'); ?>
                            </div>
                            <?php } ?>

                            <?php echo form_open('send'); ?>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" name="name"  placeholder="Your Name" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="email" name="email"  placeholder="Your Email" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="subject"  placeholder="Subject" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <textarea name="comment" class="form-control" placeholder="Your Comment....." rows="5" required></textarea>
                                </div>
                                <div class="form-btn text-center">
                                    <button type="submit" class="btn btn-round">Send message</button>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>