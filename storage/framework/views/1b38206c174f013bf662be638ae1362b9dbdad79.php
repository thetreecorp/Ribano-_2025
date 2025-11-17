<section class="how_it_work_area shape3">
    <div class="container">
        <div class="row_it_work">
            <div class="section_header mb-50 text-center">
                <h1><?php echo app('translator')->get('How It Works?'); ?></h1>
                <h5><?php echo app('translator')->get('Investment options'); ?></h5>

            </div>
            <div class="row">
                <div class="why-item col-lg-4 col-md-4 text-center">
                    <img src="<?php echo e(asset('assets/images')); ?>/register.svg"
                        style="width:100px; margin-bottom: 10px">
                    <p><?php echo app('translator')->get('There are two ways in which an investor can invest'); ?></p>
                </div>
                <div class="why-item col-lg-4 col-md-4 text-center">
                    <img src="<?php echo e(asset('/assets/images')); ?>/connect.svg"
                        style="width:100px; margin-bottom: 10px">
                    <p><?php echo app('translator')->get('Buy shares in a specific project on the platform'); ?></p>
                </div>
                <div class="why-item col-lg-4 col-md-4 text-center">
                    <img src="<?php echo e(asset('/assets/images')); ?>/earn.svg"
                        style="width:100px; margin-bottom: 10px">
                    <p><?php echo app('translator')->get('Invest in Ribano is portfolio that distributes investments according to its plan'); ?></p>
                </div>
            </div>
            
        </div>
    </div>
    <div class="wrapper work-tab">
        <div class="tab-wrapper">
            <ul class="tabs">
                <li class="tab-link active" data-tab="1"><h4><?php echo app('translator')->get('Option One'); ?></h4></li>
                <li class="tab-link" data-tab="2"><h4><?php echo app('translator')->get('Option Two'); ?></h4></li>
            </ul>
        </div>

        <div class="content-wrapper">
            <div id="tab-1" class="tab-content active">
                <div class="container">
                    <?php // var_dump($templates['how-it-work'][0]) ?>
                    <div class="row align-items-center">
                        <div class="col-lg-7 order-2 order-lg-1">
                            <div class="seciton_right cmn_scroll">
                                <?php if(isset($contentDetails['how-it-work'])): ?> <?php $__currentLoopData = $contentDetails['how-it-work']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="cmn_box2 box1 d-flex shadow3 flex-column flex-sm-row">
                                    <span class="number"><?php echo e(++$k); ?></span>
                                    <div class="text_area">
                                        <h5><?php echo app('translator')->get(@$item->description->title); ?></h5>
                                        <p><?php echo app('translator')->get(@$item->description->short_description); ?></p>

                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-5 order-1 order-lg-2 flex-column flex-sm-row">
                            <div class="section_left">
                                <div class="image_area">
                                    <?php if($how_it_work->description->image): ?>
                                        <img src="<?php echo e(url("/assets/uploads/content/") . "/" .$how_it_work->description->image); ?>" alt="how it work"/>
                                    <?php else: ?>
                                        <img alt="how it work" src="<?php echo e(asset($themeTrue.'img/how_it_work/team work brainstorming vector presentation_5204715.png')); ?>" />
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php //dd(url("/assets/uploads/content/") .$how_it_work->description->image); ?>

            <div id="tab-2" class="tab-content">
                <div class="container">

                    <div class="row align-items-center">
                        <div class="col-lg-7 order-2 order-lg-1">
                            <div class="seciton_right cmn_scroll">
                                <div class="cmn_box2 box1 d-flex shadow3 flex-column flex-sm-row">
                                    <span class="number">1</span>
                                    <div class="text_area">
                                        <p><?php echo app('translator')->get('The investor invests in a portfolio managed by Ribano'); ?></p>
                                    </div>
                                </div>
                                    <div class="cmn_box2 box1 d-flex shadow3 flex-column flex-sm-row">
                                    <span class="number">2</span>
                                    <div class="text_area">
                                        <p><?php echo app('translator')->get('After reading all the details, the investor determines the amount of investment he wants to invest'); ?></p>
                                    </div>
                                </div>
                                    <div class="cmn_box2 box1 d-flex shadow3 flex-column flex-sm-row">
                                    <span class="number">3</span>
                                    <div class="text_area">
                                        <p><?php echo app('translator')->get('The investor pays the value of the contribution and the investment amount through the payment platform and through various payment methods'); ?></p>
                                    </div>
                                </div>
                                    <div class="cmn_box2 box1 d-flex shadow3 flex-column flex-sm-row">
                                    <span class="number">4</span>
                                    <div class="text_area">
                                        <h5><?php echo app('translator')->get('Enjoy Super Results'); ?></h5>
                                        <p><?php echo app('translator')->get('The wallet has two NFT glands that represent the total projects under it and secures the investor’s share through blockchain technology and takes its own NFT or token'); ?></p>
                                    </div>
                                </div>
                                <div class="cmn_box2 box1 d-flex shadow3 flex-column flex-sm-row">
                                    <span class="number">5</span>
                                    <div class="text_area">
                                        <h5><?php echo app('translator')->get('Register &amp; Log in'); ?></h5>
                                        <p><?php echo app('translator')->get('Ribano manages the investment process and directs investment to various projects to achieve maximum investment safety and reduce risk'); ?>.</p>
                                    </div>
                                </div>
                                <div class="cmn_box2 box1 d-flex shadow3 flex-column flex-sm-row">
                                    <span class="number">6</span>
                                    <div class="text_area">
                                        <h5>6</h5>
                                        <p><?php echo app('translator')->get('Ribano gives powers to the investor to monitor the administrative systems of the projects that have been invested in'); ?></p>
                                    </div>
                                </div>
                                <div class="cmn_box2 box1 d-flex shadow3 flex-column flex-sm-row">
                                    <span class="number">7</span>
                                    <div class="text_area">
                                        <h5>7</h5>
                                        <p><?php echo app('translator')->get("Ribano will act as the company's financial manager to ensure rational investment and spending operations"); ?></p>
                                    </div>
                                </div>
                                <div class="cmn_box2 box1 d-flex shadow3 flex-column flex-sm-row">
                                    <span class="number">8</span>
                                    <div class="text_area">
                                        <h5>8</h5>
                                        <p><?php echo app('translator')->get("Investment funds are gradually disbursed from Ribano's account to the company's account, according to the needs of the company's operations and based on spending requests in the administrative system"); ?>.</p>
                                    </div>
                                </div>
                                <div class="cmn_box2 box1 d-flex shadow3 flex-column flex-sm-row">
                                    <span class="number">9</span>
                                    <div class="text_area">
                                        <h5>9</h5>
                                        <p><?php echo app('translator')->get("At the end of the fiscal year, profits are calculated and placed in the investor's portfolio in Ribano"); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 order-1 order-lg-2 flex-column flex-sm-row">
                            <div class="section_left">
                                <div class="image_area">
                                    <?php if($how_it_work->image_2_option): ?>
                                        <img src="<?php echo e(url("/assets/uploads/content/") . "/" .$how_it_work->image_2_option); ?>" alt="how it work"/>
                                    <?php else: ?>
                                    <img alt="how it work"
                                        src="<?php echo e(asset($themeTrue.'img/how_it_work/team work brainstorming vector presentation_5204715.png')); ?>" />
                                    <?php endif; ?>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php /**PATH D:\project\ribano-new-look\resources\views/themes/lightpink/sections/how-it-work-tab.blade.php ENDPATH**/ ?>