<?php $common = app('App\Http\Controllers\ProjectController'); ?>
<?php $__env->startPush('style'); ?>

    <style>
        .tabs-menu{
            flex-wrap:wrap !important;
            gap:16px;
        }

        .tab-link{
            margin:0;
        }
    </style>

<?php $__env->stopPush(); ?>

<?php
    $have_you_raised = $findProject->have_you_raised;
    $getPriceToken = 1;
    if($findProject->token)
        $getPriceToken = $findProject->token->token_price ? $findProject->token->token_price : 1;
    if($common->sumToken($findProject->id))
        $have_you_raised = (float)$common->sumToken($findProject->id)*(float)$getPriceToken;
    $bg_img = $findProject->banner ? $common->getLinkIdrive($findProject->banner) : 'https://placehold.jp/1920x600.png';

    $token_symbol = "$";

    if($findProject->token)
        $token_symbol = $findProject->token->token_symbol;


    $currency_symbol = session('currency') ?? '$';
    if($currency_symbol == 'USD')
        $currency_symbol = '$';
?>
<?php $__env->startPush('css-lib'); ?>
<link rel="stylesheet" href="<?php echo e(asset('public/assets/css/toastr.min.css')); ?>" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
<?php $__env->stopPush(); ?>
<?php $__env->startSection('title', translate($title)); ?>

<?php $__env->startSection('content'); ?>
<section class="project-banner container pd0">
    <div class="rib-b-img" style="background: url(<?php echo e($bg_img); ?>)">
        
    </div>
    <div class="container">
        <div class="row-cover">
            <div class="cover-bottom">
                <div class="top-detail">

                    <img alt="logo"
                        src="<?php echo e($findProject->logo ? $common->getLinkIdrive($findProject->logo) : 'https://placehold.jp/86x86.png'); ?>"
                        alt="project-logo">
                    <div class="p-short-detail">
                        <p><strong><?php echo e($findProject->title ?? translate('N/A')); ?></strong></p>
                        <p><label><?php echo e(translate("Location")); ?></label>: <?php echo e($findProject->country ?? translate('N/A')); ?> </p>
                    </div>
                </div>
            </div>
            <?php echo $__env->make('project.raised', ['project' => $findProject], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            
        </div>
    </div>


</section>
<section class="fixed-menu pd0" id="fixed-scroll-menu">
</section>
<section class="menu-section pd0 pdbt20">
    <div class="tab-menu-top">
        <div class="container">
            <ul class="tabs-menu">

                <?php $question_answer = json_decode($findProject->question_answer, true); ?>
                <?php

                        $members = [];
                        if($findProject->team_members) {
                            $members = json_decode($findProject->team_members, true);
                        }
                        $overview_style = $pitch_details_style = $the_team_style = $data_room_style = $deal_style = $video_style = $galleries_style = $questions_style = "";
                        if(count($members) == 0) {
                            $the_team_style = "display: none";
                        }
                        if($findProject->business_plan == null && $findProject->financials == null && $findProject->pitch_deck == null
                        && $findProject->executive_summary  == null && $findProject->additional_documents == null) {
                            $data_room_style = "display: none";
                        }
                        if(!$findProject->equity_checked && !$findProject->convertible_notes_checked) {
                            $deal_style = "display: none";
                        }
                        if(!$common->generateVideoEmbedUrl($findProject->video_url) && !$findProject->videosPerPage) {
                            $video_style = "display: none";
                        }
                        if(!$imagesPerPage) {
                            $galleries_style = "display: none";
                        }
                        if(!$question_answer) {
                            $questions_style = "display: none";
                        }

                        $arrayTab = [translate("Overview"), translate("Pitch Details"), translate("The Team"), translate("Data Room"), translate("Deal"), translate("Video"), translate("Galleries"), translate("Questions & Answers")];

                    ?>
                

                <?php $__currentLoopData = $arrayTab; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <?php

                            if($key == 7)
                                $class = $questions_style;
                            else
                                $class = ${convertToSnakeCase($val) . '_style'};


                        ?>

                <li <?php echo 'style="' .$class.'"' ?> class="<?php echo e(slug($val)); ?> tab-link <?php echo e($key == 0 ? 'active' : ''); ?>"
                    data-tab="<?php echo e($key + 1); ?>">
                    <a href="javascript:void(0)" <?php if($key==5) echo 'onclick="loadVideoSpeed(event);"' ; if($key==6)
                        echo 'onclick="loadImagesSpeed(event);"' ?> ><?php echo e($val); ?> </a>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php if(Auth::check()): ?>
                <li class="project-li-shortlist mb-1">
                    <form method="post" action="<?php echo e(route('addProjectToList')); ?>">
                        <a data-type="interested" data-target="<?php echo e($findProject->id); ?>" class="add-project-shortlist" class
                            href="javascript:void(0)"><?php echo e(translate("I'm Interested", null, false)); ?></a>
                    </form>
                </li>
                <li class="project-li-shortlist none-bg">
                    <form method="post" action="<?php echo e(route('addProjectToList')); ?>">
                        <a data-type="shortlist" data-target="<?php echo e($findProject->id); ?>" class="add-project-shortlist " class
                            href="javascript:void(0)"><?php echo e(translate("Shortlist")); ?></a>
                    </form>
                </li>
                <?php endif; ?>

            </ul>
        </div>

    </div>
</section>


<section class="project-content pdt10">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-9 mb-5">
                <div class="content-tab-wrapper">

                    <div id="tab-1" class="tab-content active">

                        <div class="summary">

                            <?php if($findProject->short_summary): ?>
                            <div class="content-item">

                                <h5>
                                    <?php if($findProject->summary_title): ?>
                                    <?php echo e($findProject->summary_title); ?>

                                    <?php else: ?>
                                    <?php echo e(translate("Short Summary")); ?>

                                    <?php endif; ?>


                                </h5>
                                <div class="desc-content ">
                                    <?php echo $findProject->short_summary; ?>

                                </div>
                            </div>

                            <?php endif; ?>
                        </div>
                        <div class="highlights">
                            <?php if($findProject->highlights): ?>
                            <div class="content-item">
                                <h5><?php echo app('translator')->get("Highlights"); ?></h5>
                                <div class="desc-content">
                                    <ul>
                                        <?php $__currentLoopData = explode('#%#', $findProject->highlights); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($val); ?></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </ul>

                                </div>
                            </div>

                            <?php endif; ?>
                        </div>
                    </div>

                    <div id="tab-2" class="tab-content">
                        <div class="pitch-detail">
                            




                            <?php if($findProject->short_summary): ?>
                            <div class="content-item">
                                


                                <h5>
                                    <?php if($findProject->summary_title): ?>
                                    <?php echo $findProject->summary_title; ?>

                                    <?php else: ?>
                                    <?php echo e(translate("The Summary")); ?>

                                    <?php endif; ?>


                                </h5>

                                <div class="desc-content ">
                                    <?php echo $findProject->short_summary; ?>

                                </div>
                            </div>

                            <?php endif; ?>
                            <?php if($findProject->the_business): ?>
                            <div class="content-item">
                                


                                <h5>
                                    <?php if($findProject->business_title): ?>
                                    <?php echo $findProject->business_title; ?>

                                    <?php else: ?>
                                    <?php echo e(translate("The Business")); ?>

                                    <?php endif; ?>


                                </h5>

                                <div class="desc-content ">
                                    <?php echo $findProject->the_business; ?>

                                </div>
                            </div>

                            <?php endif; ?>
                            <?php if($findProject->the_market): ?>
                            <div class="content-item">
                                

                                <h5>
                                    <?php if($findProject->the_market_title): ?>
                                    <?php echo e($findProject->the_market_title); ?>

                                    <?php else: ?>
                                    <?php echo e(translate("The Market")); ?>

                                    <?php endif; ?>


                                </h5>

                                <div class="desc-content ">
                                    <?php echo $findProject->the_market; ?>

                                </div>
                            </div>

                            <?php endif; ?>
                            <?php if($findProject->progress_proof): ?>
                            <div class="content-item">
                                

                                <h5>
                                    <?php if($findProject->progress_proof_title): ?>
                                    <?php echo e($findProject->progress_proof_title); ?>

                                    <?php else: ?>
                                    <?php echo e(translate("Progress/Proof")); ?>

                                    <?php endif; ?>


                                </h5>

                                <div class="desc-content ">
                                    <?php echo $findProject->progress_proof; ?>

                                </div>
                            </div>

                            <?php endif; ?>
                            <?php if($findProject->objectives_future): ?>
                            <div class="content-item">
                                
                                <h5>
                                    <?php if($findProject->objectives_future_title): ?>
                                    <?php echo e($findProject->objectives_future_title); ?>

                                    <?php else: ?>
                                    <?php echo e(translate("Objectives/Future")); ?>

                                    <?php endif; ?>


                                </h5>
                                <div class="desc-content ">
                                    <?php echo $findProject->objectives_future; ?>

                                </div>
                            </div>

                            <?php endif; ?>
                            <?php if($findProject->custom_section): ?>
                            <?php
                                        $custom_section = json_decode($findProject->custom_section, true);
                                    ?>
                            <?php if($custom_section): ?>
                            <?php $__currentLoopData = $custom_section; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="content-item">
                                <h5><?php echo e(key_exists(0, $value) ? $value[0] : NULL); ?></h5>
                                <div class="desc-content ">
                                    <?php if(key_exists(1, $value)): ?>
                                    <?php echo nl2br($value[1]); ?>


                                    <?php endif; ?>

                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <?php endif; ?>


                            <?php endif; ?>
                            <?php if($findProject->highlights): ?>
                            <div class="content-item">
                                <h5><?php echo app('translator')->get("Highlights"); ?></h5>
                                <div class="desc-content">
                                    <ul>
                                        <?php $__currentLoopData = explode('#%#', $findProject->highlights); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($val); ?></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </ul>

                                </div>
                            </div>

                            <?php endif; ?>



                            <?php if($findProject->add_financials): ?>
                            <?php
                                        $add_financials = json_decode($findProject->add_financials, true);
                                    ?>
                            <?php if($add_financials): ?>
                            <div class="financials_tbl">

                                <table>
                                    <thead>
                                        <tr>
                                            <th><?php echo e(translate('Year')); ?></th>
                                            <th><?php echo e(translate('Turner')); ?></th>
                                            <th><?php echo e(translate('Profit')); ?><br></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $add_financials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e(key_exists(0, $value) ? $value[0] : NULL); ?></td>
                                            <td><?php echo e(key_exists(1, $value) ? $value[1] : NULL); ?></td>
                                            <td><?php echo e(key_exists(2, $value) ? $value[2] : NULL); ?></td>
                                        </tr>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </tbody>
                                </table>
                            </div>



                            <?php endif; ?>


                            <?php endif; ?>
                            <?php if($findProject->tags): ?>
                            <?php
                            $tags = explode('%###%', $findProject->tags);

                            ?>
                            <div class="content-item">
                                <h5><?php echo app('translator')->get("Tags"); ?></h5>
                                <div class="desc-content ">
                                    <?php echo e(implode(', ', $tags)); ?>

                                </div>
                            </div>

                            <?php endif; ?>


                        </div>


                    </div>

                    <div id="tab-3" <?php echo 'style="' .$the_team_style.'"' ?> class="tab-content team-content" >
                        <!-- Team item -->
                        <?php if($findProject->team_overview): ?>
                        <div class="container">
                            <div class="team-overview">
                                <?php echo $findProject->team_overview; ?>

                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="container">
                            <div class="row row-box">

                                <?php if(count($members)): ?>
                                <?php for($i = 0; $i < count($members); $i++): ?> <?php if($i % 3==0 && $i> 0): ?>
                            </div>
                            <div class="row row-box">
                                <?php endif; ?>
                                <?php
                                $url = "javascript:void(0)";
                                if(key_exists(2, $members[$i])) {
                                if(filter_var($members[$i][2], FILTER_VALIDATE_URL))
                                $url = $members[$i][2];

                                }

                                ?>
                                <div class="col-lg-4 col-md-4 col-box">
                                    <div class="column">
                                        <div class="card-item">
                                            <a href="<?php echo e($url); ?>">
                                                <div class="img-wrap">

                                                    <?php if(key_exists(0, $members[$i]) && $members[$i][0] &&
                                                    strpos($members[$i][0], 'ribano.org') !== false): ?>

                                                    <img src="<?php echo e($common->getLinkIdrive($members[$i][0])); ?>"
                                                        alt="Team avatar">
                                                    <?php else: ?>
                                                    <img src="https://placehold.jp/266x200.png" alt="Team avatar">
                                                    <?php endif; ?>
                                                </div>
                                            </a>

                                            <div class="team-desc">
                                                <?php if(key_exists(1, $members[$i])): ?>
                                                <h5><?php echo e($members[$i][1]); ?></h5>
                                                <?php endif; ?>
                                                <?php if(key_exists(3, $members[$i])): ?>
                                                <p class="title"><?php echo e($members[$i][3]); ?></p>
                                                <?php endif; ?>
                                                <?php if(key_exists(4, $members[$i])): ?>
                                                <p><?php echo e($members[$i][4]); ?></p>
                                                <?php endif; ?>



                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endfor; ?>

                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                    <div id="tab-4" <?php echo 'style="' .$data_room_style.'"' ?> class="tab-content">


                        <div class="content-tbl financials_tbl">
                            <?php if($findProject->business_plan || $findProject->financials || $findProject->pitch_deck ||
                            $findProject->executive_summary || $findProject->additional_documents ): ?>
                            <table class="table">
                                <tbody>
                                    <?php if($findProject->business_plan): ?>
                                    <tr>
                                        <td><?php echo app('translator')->get("Business Plan"); ?></td>
                                        <td class="desc-content ">
                                            <a download
                                                href="<?php echo e($common->getLinkIdrive($findProject->business_plan) ?? 'javascript:void(0)'); ?>"><?php echo e(translate('View')); ?></a>
                                        </td>
                                    </tr>
                                    <?php endif; ?>

                                    <?php if($findProject->financials): ?>
                                    <tr>
                                        <td><?php echo app('translator')->get("Financials"); ?></td>
                                        <td class="desc-content ">
                                            <a download
                                                href="<?php echo e($common->getLinkIdrive($findProject->financials) ?? 'javascript:void(0)'); ?>"><?php echo e(translate('View')); ?></a>
                                        </td>
                                    </tr>
                                    <?php endif; ?>

                                    <?php if($findProject->pitch_deck): ?>
                                    <tr>
                                        <td><?php echo app('translator')->get("Pitch Deck"); ?></td>
                                        <td class="desc-content ">
                                            <a download
                                                href="<?php echo e($common->getLinkIdrive($findProject->pitch_deck) ?? 'javascript:void(0)'); ?>"><?php echo e(translate('View')); ?></a>
                                        </td>
                                    </tr>
                                    <?php endif; ?>

                                    <?php if($findProject->executive_summary): ?>
                                    <tr>
                                        <td><?php echo app('translator')->get("Executive Summary"); ?></td>
                                        <td class="desc-content ">
                                            <a download
                                                href="<?php echo e($common->getLinkIdrive($findProject->executive_summary) ?? 'javascript:void(0)'); ?>"><?php echo e(translate('View')); ?></a>
                                        </td>
                                    </tr>
                                    <?php endif; ?>

                                    <?php if($findProject->additional_documents): ?>
                                    <tr>
                                        <td><?php echo e($findProject->additional_documents_name ?
                                            $findProject->additional_documents_name : translate('Additional Documents')); ?></td>
                                        <td class="desc-content ">
                                            <a download
                                                href="<?php echo e($common->getLinkIdrive($findProject->additional_documents) ?? 'javascript:void(0)'); ?>"><?php echo e(translate('View')); ?></a>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php
                                    $add_document_section = json_decode($findProject->more_documents, true);
                                    ?>
                                    <?php if($add_document_section): ?>

                                    <?php $__currentLoopData = $add_document_section; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e(key_exists(1, $value) ? $value[1] : translate('Additional Documents')); ?>

                                        </td>

                                        <td class="desc-content ">
                                            <?php if(key_exists(0, $value) && strpos($value[0], 'ribano.org') !== false): ?>
                                            <a target="_blank"
                                                href="<?php echo e($common->getLinkIdrive($value[0]) ?? 'javascript:void(0)'); ?>"><?php echo e(translate('View')); ?></a>
                                            <?php else: ?>

                                            <?php endif; ?>

                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                            <?php endif; ?>

                        </div>


                    </div>

                    <?php
                    $add_more_investment = $add_financials = [];
                    if($findProject->add_more_investment) {
                    $add_more_investment = json_decode($findProject->add_more_investment, true);
                    }
                    if($findProject->add_financials) {
                    $add_financials = json_decode($findProject->add_financials, true);
                    }
                    ?>

                    <div id="tab-5" <?php echo 'style="' .$deal_style.'"' ?> class="tab-content">

                        <?php if($findProject->equity_checked): ?>
                        <h5><?php echo e(translate("Equity:")); ?></h5>

                        <div class="equity-wrap">
                            <table class="table table-border">
                                <tbody>
                                    <?php if($findProject->raising): ?>
                                    <tr>
                                        <td><?php echo app('translator')->get("Target"); ?></td>
                                        <td class="desc-content ">
                                            <p><?php echo e($findProject->raising ? $currency_symbol . ' ' . convertUSDToCurrency($findProject->raising, $currency_symbol) :
                                                translate('N/A')); ?></p>
                                        </td>
                                    </tr>
                                    <?php endif; ?>

                                    <?php if($findProject->amount_of_investment): ?>
                                    <tr>
                                        <td><?php echo e(translate("Equity for this investment")); ?></td>
                                        <td class="desc-content ">
                                            <?php echo e($findProject->amount_of_investment); ?>%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><?php echo e(translate("Planned Expenses")); ?></td>

                                    </tr>
                                    <tr>
                                        <td><?php echo e($findProject->investment_type); ?></td>
                                        <td class="desc-content ">
                                            <?php echo e($findProject->as_investments ?? 0); ?>

                                        </td>
                                    </tr>
                                    <?php endif; ?>

                                    <?php if($add_more_investment): ?>
                                    <?php $__currentLoopData = $add_more_investment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>

                                        <?php if(array_key_exists(0, $val)): ?>
                                        <td><?php echo e($val[0]); ?></td>
                                        <?php else: ?>
                                        <td></td>
                                        <?php endif; ?>
                                        <?php if(array_key_exists(1, $val)): ?>
                                        <td class="desc-content "><?php echo e($val[1]); ?></td>
                                        <?php else: ?>
                                        <td></td>
                                        <?php endif; ?>
                                        
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <?php if($total_investment): ?>
                                    <tr>
                                        <td><?php echo e(translate('Total of investment needed')); ?></td>
                                        <td><strong><?php echo e(n_format($total_investment)); ?></strong>
                                        </td>
                                    </tr>
                                    <?php endif; ?>

                                    <?php if($findProject->total_share): ?>

                                    <tr>
                                        <td><?php echo e(translate("Total shares of the company")); ?></td>
                                        <td class="desc-content ">
                                            <?php echo e($findProject->total_share); ?>

                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php if($findProject->price_of_share): ?>

                                    <tr>
                                        <td><?php echo e(translate("Price of share")); ?></td>
                                        <td class="desc-content ">
                                            <?php echo e($findProject->price_of_share); ?>

                                        </td>
                                    </tr>
                                    <?php endif; ?>

                                    <?php if($findProject->shares_granted): ?>

                                    <tr>
                                        <td><?php echo e(translate("Shares granted for this investment")); ?></td>
                                        <td class="desc-content ">
                                            <?php echo e($findProject->shares_granted); ?>

                                        </td>
                                    </tr>
                                    <?php endif; ?>





                                    <?php if($findProject->accept): ?>
                                    <tr class="content-item">
                                        <td><?php echo e(translate("I can accept")); ?></td>
                                        <td><?php echo e($findProject->accept); ?></td>
                                    </tr>

                                    <?php endif; ?>
                                    <?php if($findProject->investment_equity_previous_rounds): ?>
                                    <tr class="content-item">
                                        <td><?php echo e(translate("Previous rounds raise the amount")); ?></td>
                                        <td><?php echo e($findProject->investment_equity_previous_rounds); ?></td>
                                    </tr>

                                    <?php endif; ?>
                                    <?php if($findProject->investment_equity_grand): ?>
                                    <tr class="content-item">
                                        <td><?php echo e(translate("Investment already granted from the current round")); ?></td>
                                        <td><?php echo e($findProject->investment_equity_grand); ?></td>
                                    </tr>

                                    <?php endif; ?>
                                    <?php if($findProject->investor_equity_numbers): ?>
                                    <tr class="content-item">
                                        <td><?php echo e(translate("Investor numbers of the current round")); ?></td>
                                        <td><?php echo e($findProject->investor_equity_numbers); ?></td>
                                    </tr>

                                    <?php endif; ?>

                                    <?php if($findProject->minimum_equity_investment): ?>
                                    <tr class="content-item">
                                        <td><?php echo e(translate("Minimum investment per investor")); ?></td>
                                        <td><?php echo e($findProject->minimum_equity_investment); ?></td>
                                    </tr>

                                    <?php endif; ?>
                                    <?php if($findProject->maximum_equity_investment): ?>
                                    <tr class="content-item">
                                        <td><?php echo e(translate("Maximum investment per investor")); ?></td>
                                        <td><?php echo e($findProject->maximum_equity_investment); ?></td>
                                    </tr>

                                    <?php endif; ?>




                                </tbody>
                            </table>
                        </div>

                        <?php endif; ?>

                        <?php if($findProject->convertible_notes_checked): ?>
                        <h5><?php echo e(translate("SAFE")); ?></h5>
                        <table class="table table-border">
                            <tbody>
                                <?php if($findProject->safe_target): ?>
                                <tr>
                                    <td><?php echo e(translate("Target")); ?></td>
                                    <td class="desc-content ">
                                        <?php echo e($findProject->safe_target); ?>

                                    </td>
                                </tr>
                                <?php endif; ?>

                                <?php if($findProject->purchase_price): ?>
                                <tr>
                                    <td><?php echo e(translate("Purchase price")); ?></td>
                                    <td class="desc-content ">
                                        <?php echo e($findProject->purchase_price); ?>

                                    </td>
                                </tr>
                                <?php endif; ?>

                                <?php if($findProject->date_of_issuance): ?>
                                <tr>
                                    <td><?php echo e(translate("Date of issuance")); ?></td>
                                    <td class="desc-content ">
                                        <?php echo e($findProject->date_of_issuance); ?>

                                    </td>
                                </tr>
                                <?php endif; ?>

                                <?php if($findProject->exercise_price): ?>
                                <tr>
                                    <td><?php echo e(translate("Exercise price")); ?></td>
                                    <td class="desc-content ">
                                        <?php echo e($findProject->exercise_price); ?>

                                    </td>
                                </tr>
                                <?php endif; ?>

                                <?php if($findProject->exercise_date): ?>
                                <tr>
                                    <td><?php echo e(translate("Exercise date")); ?></td>
                                    <td class="desc-content ">
                                        <?php echo e($findProject->exercise_date); ?>

                                    </td>
                                </tr>
                                <?php endif; ?>

                                <?php if($findProject->discount): ?>
                                <tr>
                                    <td><?php echo e(translate("Discount")); ?></td>
                                    <td class="desc-content ">
                                        <?php echo e($findProject->discount); ?>

                                    </td>
                                </tr>
                                <?php endif; ?>

                                <?php if($findProject->maturity_date): ?>
                                <tr>
                                    <td><?php echo e(translate("Maturity Date")); ?></td>
                                    <td class="desc-content ">
                                        <?php echo e($findProject->maturity_date); ?>

                                    </td>
                                </tr>
                                <?php endif; ?>

                                <?php if($findProject->valuation_cap): ?>
                                <tr>
                                    <td><?php echo e(translate("Valuation cap")); ?></td>
                                    <td class="desc-content ">
                                        <?php echo e($findProject->valuation_cap); ?>

                                    </td>
                                </tr>
                                <?php endif; ?>

                                <?php if($findProject->previous_round_raise): ?>
                                <tr class="content-item">
                                    <td><?php echo e(translate("Previous rounds raise the amount")); ?></td>
                                    <td><?php echo e($findProject->previous_round_raise); ?></td>
                                </tr>

                                <?php endif; ?>
                                <?php if($findProject->investment_grand): ?>
                                <tr class="content-item">
                                    <td><?php echo e(translate("Investment already granted from the current round")); ?></td>
                                    <td><?php echo e($findProject->investment_grand); ?></td>
                                </tr>

                                <?php endif; ?>
                                <?php if($findProject->investor_numbers): ?>
                                <tr class="content-item">
                                    <td><?php echo e(translate("Investor numbers of the current round")); ?></td>
                                    <td><?php echo e($findProject->investor_numbers); ?></td>
                                </tr>

                                <?php endif; ?>

                                <?php if($findProject->minimum_investment): ?>
                                <tr class="content-item">
                                    <td><?php echo e(translate("Minimum investment per investor")); ?></td>
                                    <td><?php echo e($findProject->minimum_investment); ?></td>
                                </tr>

                                <?php endif; ?>
                                <?php if($findProject->maximum_investment): ?>
                                <tr class="content-item">
                                    <td><?php echo e(translate("Maximum investment per investor")); ?></td>
                                    <td><?php echo e($findProject->maximum_investment); ?></td>
                                </tr>

                                <?php endif; ?>


                            </tbody>
                        </table>
                        <?php endif; ?>



                    </div>
                    <div id="tab-6" <?php echo 'style="' .$video_style.'"' ?> class="tab-content">
                        <?php
                        $images = [];
                        if($findProject->images) {
                        $images = explode('%###%', $findProject->images);
                        }
                        $videos = [];
                        if($findProject->add_video) {
                        $videos = json_decode($findProject->add_video, true);
                        }
                        ?>



                        <div class="video-wrap container">
                            <h5><?php echo e(translate('Videos')); ?></h5>
                            <div class="row">
                                <div class="loading-spin"></div>
                                <?php if($common->generateVideoEmbedUrl($findProject->video_url)): ?>
                                <div class="video-container col-sm-12">
                                    <div class="video-ct">
                                        <?php if($findProject->video_title): ?>
                                        <h6><?php echo e($findProject->video_title); ?></h6>
                                        <?php endif; ?>
                                        <?php if($findProject->video_description): ?>
                                        <div class="video-description"><?php echo e($findProject->video_description); ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <iframe allowfullscreen width="100%" height="350"
                                        src="<?php echo e($common->generateVideoEmbedUrl($findProject->video_url)); ?>">
                                    </iframe>
                                </div>
                                <?php endif; ?>

                                <?php if($videosPerPage): ?>
                                <div id="load-video-wrap"></div>

                                



                                <?php if($totalVideoItem > 12): ?>
                                <div id="pagination-video" style="display: none">

                                    <nav class="theme-video-nav"></nav>

                                </div>
                                <?php endif; ?>


                                <?php endif; ?>

                            </div>


                        </div>



                    </div>


                    <div id="tab-7" <?php echo 'style="' .$galleries_style.'"' ?> class="tab-content">

                        <?php
                        $images = [];
                        if($findProject->images) {
                        $images = explode('%###%', $findProject->images);
                        }

                        ?>

                        <?php if($imagesPerPage): ?>
                        <div id="load-gallery-wrap"></div>
                        
                        <?php if($totalItem > 12): ?>
                        <div id="pagination-wrap" style="display: none">
                            <nav class="theme-pagination"></nav>
                        </div>
                        <?php endif; ?>

                        <?php endif; ?>

                    </div>


                    <div id="tab-8" <?php echo 'style="' .$questions_style.'"' ?> class="tab-content">
                        <?php if($question_answer): ?>
                        <div class="row">
                            <?php $__currentLoopData = $question_answer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($data[0]): ?>
                            <div class="col-md-12" data-aos="fade-left">
                                <div class="accordion_area mt-45">
                                    <div class="accordion_item shadow3">
                                        <button class="accordion_title"><?php echo e($data[0]); ?><i
                                                class="<?php echo e(($k == 0) ? 'fa fa-minus': 'fa fa-plus'); ?>"></i></button>
                                        <div class="accordion_body <?php echo e(($k == 0) ? 'show' : ''); ?>">
                                            <?php echo e($data[1] ?? NULL); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
            <div class="col-lg-3 col-md-3 mb-5">
                <div class="proposal-blocks">
                    <p><span class="editableLabel"><?php echo e(translate('Overview')); ?></span></p>
                    <div class="investment-summary">
                        <?php

                                $add_more_investment = json_decode($findProject->add_more_investment, true) ?? [];
                                $more_investment = 'N/A';
                                $key = 'Shares granted for this investment';
                                if(key_exists($key, $add_more_investment)){
                                   $more_investment = $add_more_investment[$key];
                                }



                            ?>
                        <p><strong class="editableLabel"><?php echo e(translate('Pitch Detail')); ?></strong></p>
                        <table class="table">
                            <tbody>
                                <?php if($findProject->raising): ?>
                                <tr>
                                    <td><?php echo e(translate('Target')); ?></td>
                                    <td>
                                        <div> <strong><?php echo e($findProject->raising ? $currency_symbol . ' ' . convertUSDToCurrency($findProject->raising, $currency_symbol) :
                                                translate('N/A')); ?></strong></div>
                                    </td>
                                </tr>
                                <?php endif; ?>




                                

                                <?php if($findProject->investment_equity_grand): ?>
                                <tr>
                                    <td><?php echo e(translate('Raised')); ?></td>
                                    <td><strong><?php echo e($findProject->investment_equity_grand ? '$ ' .
                                            $findProject->investment_equity_grand : 0); ?></strong>
                                    </td>
                                </tr>
                                <?php endif; ?>



                                <?php if($findProject->investor_equity_numbers): ?>
                                <tr>
                                    <td><?php echo e(translate('Investor numbers')); ?></td>
                                    <td><strong><?php echo e($findProject->investor_equity_numbers ?
                                            $findProject->investor_equity_numbers : 0); ?></strong>
                                    </td>
                                </tr>
                                <?php endif; ?>

                                <?php if($findProject->minimum_equity_investment): ?>
                                <tr>
                                    <td><?php echo e(translate('Minimum Investment')); ?> </td>
                                    <td>

                                        <div> <strong><?php echo e($findProject->minimum_equity_investment ? $currency_symbol . ' ' .
                                                convertUSDToCurrency($findProject->minimum_equity_investment, $currency_symbol) : 0); ?></strong></div>
                                    </td>
                                </tr>
                                <?php endif; ?>

                                <?php if($findProject->maximum_investment): ?>

                                <tr>
                                    <td><?php echo e(translate('Maximum Investment')); ?> </td>
                                    <td>

                                        <div> <strong><?php echo e($findProject->maximum_equity_investment ? '$ ' .
                                                $findProject->maximum_equity_investment : 0); ?></strong></div>
                                    </td>
                                </tr>
                                <?php endif; ?>

                                



                                
                                <?php if($findProject->website): ?>
                                <tr>
                                    <td>
                                        <p><?php echo e(translate("Website")); ?></p>
                                    </td>
                                    <td><a target="_blank"
                                            href="<?php echo e($findProject->website); ?>"><?php echo e($findProject->website); ?></a></td>
                                </tr>

                                <?php endif; ?>

                                <?php if($findProject->country): ?>
                                <tr>
                                    <td>
                                        <p><?php echo e(translate("Location")); ?></p>
                                    </td>
                                    <td>
                                        <p><?php echo e($findProject->country); ?></p>
                                    </td>
                                </tr>

                                <?php endif; ?>
                                <?php if($findProject->stage): ?>
                                <tr>
                                    <td><?php echo e(translate('Stage')); ?> </td>
                                    <td><strong><?php echo e($findProject->get_stage->name ?? translate('N/A')); ?></strong></td>
                                </tr>
                                <?php endif; ?>



                                <?php if($findProject->ideal_investor_role): ?>
                                <tr>
                                    <td><?php echo e(translate('Investor Role')); ?></td>
                                    <td><strong><?php echo e($findProject->ideal_investor_role ?? translate('N/A')); ?></strong></td>
                                </tr>
                                <?php endif; ?>

                                <?php if($findProject->industry_1 && is_numeric($findProject->industry_1)): ?>
                                <tr>
                                    <td>
                                        <p><?php echo e(translate("Industry")); ?></p>
                                    </td>
                                    <td>
                                        <p><?php echo e($findProject->get_industry1->name); ?></p>
                                    </td>
                                </tr>

                                <?php endif; ?>
                                <?php if($findProject->industry_2 && is_numeric($findProject->industry_2)): ?>
                                <tr>
                                    <td>
                                        <p><?php echo e(translate("Industry")); ?></p>
                                    </td>
                                    <td>
                                        <p><?php echo e($findProject->get_industry2->name); ?></p>
                                    </td>
                                </tr>

                                <?php endif; ?>


                                


                                


                                    <tr>
                                        <?php if(auth()->guard()->check()): ?>
                                            <?php if($findProject->user_id != Auth::user()->id): ?>
                                            <td colspan="2" style="border-bottom: none">
                                                <a data-bs-toggle="modal"
                                                    data-bs-target="#buyToken" class="btn btn-danger buy-now-button"
                                                    href="javascript:void(0)"><?php echo e(translate('Invest Now')); ?></a>
                                            </td>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if(auth()->guard()->guest()): ?>
                                            <td colspan="2" style="border-bottom: none">
                                                <a href="<?php echo e(route('login')); ?>" class="btn btn-danger buy-now-button"><?php echo e(translate('Login to Invest')); ?></a>
                                            </td>
                                        <?php endif; ?>



                                    </tr>

                                    
                                        <?php if(auth()->guard()->guest()): ?>
                                            <td colspan="2" style="border-bottom: none">
                                                <a href="<?php echo e(route('login')); ?>" class="btn btn-danger buy-now-button"><?php echo e(translate('Login to Invest')); ?></a>
                                            </td>
                                        <?php endif; ?>


                                

                                

                            </tbody>
                        </table>



                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="alert alert-info">
            <div class=" custom-info">
                <label><strong><?php echo e(@translate('Please note')); ?></strong></label>
                <span class="editableLabel" labelid="proposal_view:note_content">
                    <?php echo e(translate("Investing in early stage businesses involves risks, including illiquidity, lack of
                    dividends, loss of investment and dilution, and it should be done only as part of a diversified
                    portfolio. This platform is targeted solely at investors who are sufficiently sophisticated to
                    understand these risks and make their own investment decisions. Investors are encouraged to review
                    and evaluate the investments and determine at their own discretion, the appropriateness of making
                    the particular investment. The information on this website is provided for informational purposes
                    only, but we cannot guarantee that the information is accurate or complete. We strongly encourage
                    investors to complete their own due diligence with licensed professionals, prior to making any
                    investment and will not offer any legal or tax advice")); ?>.
                </span>
            </div>
        </div>
    </div>
</section>

<section class="contact-admin">
    <div class="container">
        <h6><?php echo e(translate("To view the full pitch you must be a registered investor. To upgrade to an investor account,
            please email")); ?> </h6>
        <a href="mailto:info-desk@ribano.com" class="admin-email">info-desk@ribano.com</a>
    </div>
    <?php if(auth()->guard()->check()): ?>

    <?php if (\Illuminate\Support\Facades\Blade::check('role', 'investor')): ?>
    <a href="<?php echo e(route('all.messages')); ?>/?user_name=<?php echo e($findProject->user->username); ?>">
        <div class="chat-invs">
            <div class="background"></div>
            <svg class="chat-bubble" width="100" height="100" viewBox="0 0 100 100">
                <g class="bubble">
                    <path class="line line1" d="M 30.7873,85.113394 30.7873,46.556405 C 30.7873,41.101961
                        36.826342,35.342 40.898074,35.342 H 59.113981 C 63.73287,35.342
                        69.29995,40.103201 69.29995,46.784744" />
                    <path class="line line2" d="M 13.461999,65.039335 H 58.028684 C
                        63.483128,65.039335
                        69.243089,59.000293 69.243089,54.928561 V 45.605853 C
                        69.243089,40.986964 65.02087,35.419884 58.339327,35.419884" />
                </g>
                <circle class="circle circle1" r="1.9" cy="50.7" cx="42.5" />
                <circle class="circle circle2" cx="49.9" cy="50.7" r="1.9" />
                <circle class="circle circle3" r="1.9" cy="50.7" cx="57.3" />
            </svg>
        </div>
    </a>

    <?php endif; ?>
    <?php endif; ?>
</section>


<?php if(count($similarProject)): ?>
<section class="similar-project">
    <div class="container">
        <h4><?php echo e(translate('Similar Projects')); ?></h4>
        <div class="row">
            <?php $__currentLoopData = $similarProject; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-4 wow fadeInUp col-box">
                <?php echo $__env->make('project.project_box', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <div class="text-center mrt20">
        <a class="btn btn-default  btn-primary" href="<?php echo e(route('searchProject')); ?>"><span><?php echo e(translate('View More
                Pitches')); ?></span></a>
    </div>
</section>


<?php endif; ?>


<?php if($findProject->token): ?>
<!-- Modal -->
<div class="modal fade" id="buyToken" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo e(translate('Invest Now')); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <svg viewPort="0 0 12 12" version="1.1" xmlns="http://www.w3.org/2000/svg">
                        <line x1="1" y1="11" x2="11" y2="1" stroke="black" stroke-width="2" />
                        <line x1="1" y1="1" x2="11" y2="11" stroke="black" stroke-width="2" />
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="token-info">
                    <h5><?php echo e($findProject->token->name); ?></h5>
                    <p style="font-size: 20px"> <span class="number-token">1</span> <?php echo e($findProject->token->token_symbol); ?> = <span
                            class="sum-token"><?php echo e($findProject->token->token_price ? $findProject->token->token_price :
                            1); ?></span> <span><?php echo e(config('basic.currency_symbol')); ?></span></p>
                    <div class="token-desc">
                        <label><?php echo e(translate('Invest')); ?>: <span class="from"><?php echo e($findProject->token->min_buy_amount ??
                                1); ?></span> <span><?php echo e($findProject->token->token_symbol); ?></span> - <span
                                class="to"><?php echo e($findProject->token->fixed_amount - $tokenBuy); ?></span>
                            <span><?php echo e($findProject->token->token_symbol); ?></span></label>

                        <div class="form-group col-md-12">
                            <div class="input-group mb-3">
                                <input min="<?php echo e($findProject->token->min_buy_amount ?? 1); ?>" id="max_token_input"
                                    onkeydown="javascript: return ['Backspace','Delete','ArrowLeft','ArrowRight'].includes(event.code) ? true : !isNaN(Number(event.key)) && event.code!=='Space'"
                                    type="number" name="amount" max="<?php echo e($findProject->token->fixed_amount - $tokenBuy); ?>"
                                    value="" class="form-control" placeholder="0.00">


                            </div>
                            <div id="error-message" style="color: red;"></div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo e(translate('Close')); ?></button>
                <a id="invest_button" href="javascript:void(0)" class="btn btn-primary"><?php echo e(translate('Invest Now')); ?></a>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>



<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
<script src="<?php echo e(asset('public/assets/js/toastr.min.js')); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script src="<?php echo e(asset('public/assets/js/simplePagination.js')); ?>"></script>
<script>
    var maxInput = 0 ;
        var minInput = 1 ;
        var buyToken = 0 ;

        <?php if($findProject->token): ?>
            maxInput = '<?php echo e($findProject->token->fixed_amount - $tokenBuy); ?>';
            minInput = '<?php echo e($findProject->token->min_buy_amount ?? 1); ?>';
        <?php endif; ?>



        var home = '<?php echo e(url("/")); ?>';
        // Display a success toast, with a title
        toastr.options = {
          "closeButton": false,
          "debug": false,
          "newestOnTop": false,
          "progressBar": true,
          "positionClass": "toast-top-right",
          "preventDuplicates": false,
          "onclick": null,
          "showDuration": "300",
          "hideDuration": "1000",
          "timeOut": "2000",
          "extendedTimeOut": "1000",
          "showEasing": "swing",
          "hideEasing": "linear",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut"
        }

        Fancybox.bind('[data-fancybox="gallery"]', {});

        function maxInputFunc(maxInput) {
            $('input#max_token_input').on('input', function () {

                var value = $(this).val();
                let price = '<?php echo e($findProject->token->token_price ?? 1); ?>';
                buyToken = value = value.replace(/e|\+|\-/gi, '');
                if ((value !== '') && (value.indexOf('.') === -1)) {
                    $(this).val(Math.max(Math.min(value, maxInput), - maxInput));

                    let fn = Math.max(Math.min(value, maxInput), - maxInput);

                    $('.sum-token').text(price*(parseInt(fn)));
                    $('.number-token').text(fn);
                }
                else {
                    setTimeout(() => {
                        $('.number-token').text(value);
                        $('.sum-token').text(price*(parseInt(value)));
                    }, 1000);
                }


            });
        }
        maxInputFunc(maxInput);

        $("#invest_button").click(function () {
            var errorMessage = document.getElementById("error-message");

            if (parseFloat(buyToken) < parseFloat(minInput) || parseFloat(buyToken) > parseFloat(maxInput)) {
                errorMessage.textContent = "Value must be in the range from "+minInput+" to "+maxInput+".";
                return;
            } else {
                errorMessage.textContent = "";
            }
            if($.trim($('#max_token_input').val()) == '') {
                toastr.warning('Token number can not be left blank');
                return;
            }
            $.ajax({
                type: 'post',
                url: "<?php echo e(route('checkNumberToken')); ?>",
                data: {
                    'project_id' : "<?php echo e($findProject->id); ?>",
                    '_token' : $('meta[name="csrf-token"]').attr('content'),

                },
                beforeSend: function(){
                    toastr.success('Sending data...');
                },
                complete: function(){

                },
                success:function(data){
                    if(data.code == 200) {
                      // console.log(data);
                        maxInputFunc(data.tokenExist);
                        if($('#max_token_input').val() > data.tokenExist) {
                            //alert('The number of tokens purchased is greater than the remaining tokens');
                            toastr.warning('The number of tokens purchased is greater than the remaining tokens', 'Warning');
                            $('.token-desc span.to').val(data.tokenExist);
                            $('#max_token_input').val('');
                        }
                        else {
                            // /paymoney/{slug}/{price}
                            location.replace(home + '/paymoney/' + data.slug + '/' + $('#max_token_input').val() + '/<?php echo e($client); ?>' + '/<?php echo e($secret); ?>') ;
                        }

                    }
                    else {
                        toastr.error('Error get token', 'Error')

                    }
                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    toastr.error('Error get token ', 'Error')
                }

            });
        });

        //galleries
        function ajaxCall($page = 1, $updatePagination = true) {
			$.ajax({
		        type: "POST",
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		        url: '<?php echo e(route("imagePagination")); ?>',
		        data: {
		            'page' : $page,
		            'id' : <?php echo e($findProject->id ?? 0); ?>,
                    "_token": "<?php echo e(csrf_token()); ?>",
		        },
				beforeSend: function(){
					$('.loading-spin').html('<div class="loader">Loading...</div>');
			    },
			    complete: function(){
					$('.loading-spin').html('');
			    },
		        success: function(data) {

		           $('.gallery-row').html(data.view);

		            if($updatePagination) {
		                if(data.total > 12) {
			                // append pagenation
			                $('.theme-pagination').remove();
			                $('#pagination-wrap').append('<nav class="theme-pagination"></nav>');
							pagination(data.total);
			            }
			            else {
			                $('#pagination-wrap').html('');
			            }
		            }


		        }
		    });
		}
	    function pagination($total, $updatePagination = true){
	        $('.theme-pagination').pagination({
	            items: $total,
	            itemsOnPage: 12,
	            listStyle: 'pagination',
	            cssStyle: 'light-theme',

	            onPageClick: function(pageNumber) {
					$('html, body').animate({scrollTop: $('#tab-7').offset().top - 200}, 500);
					console.log(pageNumber);
	                ajaxCall(pageNumber, false);



	            }
	        });
	    }
        pagination(<?php echo e($totalItem); ?>, true);

        // video
        function ajaxVideoCall($page = 1, $updatePagination = true) {
			$.ajax({
		        type: "POST",
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		        url: '<?php echo e(route("videoPagination")); ?>',
		        data: {
		            'page' : $page,
		            'id' : <?php echo e($findProject->id ?? 0); ?>,
		            "_token": "<?php echo e(csrf_token()); ?>",
		        },
				beforeSend: function(){
					$('.loading-spin').html('<div class="loader">Loading...</div>');
			    },
			    complete: function(){
					$('.loading-spin').html('');
			    },
		        success: function(data) {

		           $('#video-wrap').html(data.view);

		            if($updatePagination) {
		                if(data.total > 12) {
			                // append pagenation
			                $('.theme-video-nav').remove();
			                $('#pagination-video').append('<nav class="theme-video-nav"></nav>');
							pagination(data.total);
			            }
			            else {
			                $('#pagination-video').html('');
			            }
		            }


		        }
		    });
		}
	    function videoPagination($total, $updatePagination = true){
	        $('.theme-video-nav').pagination({
	            items: $total,
	            itemsOnPage: 12,
	            listStyle: 'pagination',
	            cssStyle: 'light-theme',

	            onPageClick: function(pageNumber) {
					$('html, body').animate({scrollTop: $('#tab-6').offset().top - 200}, 500);
					console.log(pageNumber);
	                ajaxVideoCall(pageNumber, false);



	            }
	        });
	    }
        videoPagination(<?php echo e($totalVideoItem); ?>, true);

        let videoClick = false;
        let galleryClick = false;

        function loadVideoSpeed(event) {
            if (!videoClick)  {
                $.ajax({
    		        type: "POST",
    				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    		        url: '<?php echo e(route("ajaxLoadSpeed")); ?>',
    		        data: {
    		            'page' : 1,
    		            'project_id' : <?php echo e($findProject->id ?? 0); ?>,
    		            "_token": "<?php echo e(csrf_token()); ?>",
    		            'type' : 'video'
    		        },
    				beforeSend: function(){
    					//$('.loading-spin').html('<div class="loader">Loading...</div>');
    			    },
    			    complete: function(){
    					//$('.loading-spin').html('');
    			    },
    		        success: function(data) {

                        videoClick = true;
        		        $('#load-video-wrap').html(data.html);
        		        if( $('#pagination-video').length )  {
                            $('#pagination-video').show();
                        }



    		        }
    		    });
            }

        }
        function loadImagesSpeed(event) {
            if (!galleryClick)  {
                $.ajax({
		        type: "POST",
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		        url: '<?php echo e(route("ajaxLoadSpeed")); ?>',
		        data: {
		            'page' : 1,
		            'project_id' : <?php echo e($findProject->id ?? 0); ?>,
		            "_token": "<?php echo e(csrf_token()); ?>",
		        },
				beforeSend: function(){

			    },
			    complete: function(){

			    },
		        success: function(data) {

                    galleryClick = true;
    		        $('#load-gallery-wrap').html(data.html);
    		        if( $('#pagination-wrap').length )  {
                        $('#pagination-wrap').show();
                    }



		        }
		    });

            }

        }

</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.app', ['body_class' => 'single-view-project'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\project\ribano\resources\views/project/view.blade.php ENDPATH**/ ?>