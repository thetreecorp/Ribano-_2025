
<?php $common = app('App\Http\Controllers\ProjectController'); ?>
<div id="sidebar" class="">
    <div class="sidebar-top">
        <a class="navbar-brand" href="<?php echo e(route('home')); ?>">
            <img src="<?php echo e(getFile(config('location.logoIcon.path').'logo.png')); ?>"
                 alt="<?php echo e(config('basic.site_title')); ?>">
        </a>
        <button
            class="sidebar-toggler d-md-none"
            onclick="toggleSideMenu()"
        >
            <i class="fal fa-times"></i>
        </button>
    </div>
    <?php
        $user = \Illuminate\Support\Facades\Auth::user();
        $user_rankings = \App\Models\Ranking::where('rank_lavel', $user->last_lavel)->first();
    ?>

    

    <div class="wallet-wrapper">
        <div class="wallet-box d-none d-lg-block">
            <h4><?php echo app('translator')->get('Account Balance'); ?></h4>
            <h5> <?php echo app('translator')->get('Total Invest'); ?> <span><?php echo e($basic->currency_symbol); ?><?php echo e(@$user->total_invest()); ?></span></h5>
            <!-- <h5 class="mb-0"> <?php echo app('translator')->get('Interest Balance'); ?> <span><?php echo e($basic->currency_symbol); ?><?php echo e(@$user->interest_balance); ?></span></h5> -->
            <!-- <span class="tag"><?php echo e($basic->currency); ?></span> -->
        </div>
        
    </div>
    <nav class="sidebar-nav">
        <ul class="main tabScroll" id="sidebarnav">
            <li>
                <a class="<?php echo e(menuActive('user.home')); ?>" href="<?php echo e(route('user.home')); ?>"> <i class="fal fa-border-all"></i> 
                    <?php echo e(trans("Dashboard")); ?></a>
            </li>
            <hr></hr>
            <?php if(isFounder()): ?>
            <li>
                <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="fas fa-cubes text-success"></i>
                    <span class="hide-menu"><?php echo e(trans("Pitches")); ?></span>
                </a>
            </li>
    
            <li class="sidebar-item">
                
                <a href="<?php echo e(route('user.projects')); ?>" class="sidebar-link <?php echo e(menuActive(['user.projects'])); ?>">
                    <i class="fal fa-layer-group"></i> <?php echo e(trans("My Pitches")); ?>

                </a>
            </li>
            <li class="sidebar-item">
                <a href="<?php echo e(route('user.pending.projects')); ?>" class="sidebar-link <?php echo e(menuActive(['user.pending.projects'])); ?>">
                    <span class="hide-menu"><?php echo e(trans("Pending Pitches")); ?> </span>
                </a>
            </li>
            <li class="sidebar-item">
                <a target="_blank" href="<?php echo e(route('user.createProject')); ?>" class="sidebar-link">
                    <span class="hide-menu"><?php echo e(trans("Add New Pitch")); ?> </span>
                </a>
            </li>

            <hr></hr>
            <li>
                <a  class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="fas fa-credit-card text-warning"></i>
                    <span class="hide-menu"><?php echo e(trans("Investors")); ?></span>
                </a>
            </li>
    
            <li>
                <a target="_blank" href="<?php echo e(route('founder.myInvestors')); ?>" class="sidebar-link">
                    <span class="hide-menu"><?php echo e(trans("My Investors")); ?></span>
                </a>
            </li>
            <li>
                <a target="_blank" href="<?php echo e(route('investorSearch')); ?>" class="sidebar-link">
                    <span class="hide-menu"><?php echo e(trans("Search Investors")); ?> </span>
                </a>
            </li>
            <?php endif; ?>
            <!-- <li>
                <a href="#" class="sidebar-link">
                    <span class="hide-menu"><?php echo e(trans("Investments in")); ?> </span>
                </a>
            </li> -->
            <li>
                <a href="<?php echo e(route('searchProject')); ?>" class="sidebar-link <?php echo e(menuActive(['searchProject'])); ?>" 
                href="<?php echo e(route('searchProject')); ?>"><i class="fal fas fa-search"></i><?php echo e(@translate('Explore Projects')); ?></a>
            </li>
            </hr>
            
            <li>
                <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="fas fa-exchange-alt text-warning"></i>
                    <span class="hide-menu"><?php echo e(trans("My Investments & Money")); ?></span>
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('user.invest-history')); ?>" class="sidebar-link <?php echo e(menuActive(['user.invest-history'])); ?>">
                    <i class="fal fa-file-medical-alt"></i> <?php echo e(trans('Invest history')); ?>

                </a>
            </li>
            
            <!-- <li>
                <a href="<?php echo e(route('user.transaction')); ?>" class="sidebar-link <?php echo e(menuActive(['user.transaction', 'user.transaction.search'])); ?>">
                    <i class="far fa-sack-dollar"></i> <?php echo e(trans('Transactions history')); ?>

                </a>
            </li> -->
            <li>
                <a href="<?php echo e(route('user.transactionHistory')); ?>" class="sidebar-link <?php echo e(menuActive(['user.transactionHistory'])); ?>">
                    <i class="far fa-sack-dollar"></i> <?php echo e(trans('Transactions history')); ?>

                </a>
            </li>
            
            <li>
                <a href="<?php echo e(route('user.withdraw')); ?>" class="sidebar-link <?php echo e(menuActive(['user.withdraw'])); ?>">
                    <i class="far fa-sack-dollar"></i> <?php echo e(trans('Withdraw')); ?>

                </a>
            </li>
            <li>
                <a href="<?php echo e(route('user.withdrawHistory')); ?>" class="sidebar-link <?php echo e(menuActive(['user.withdrawHistory'])); ?>">
                    <i class="far fa-sack-dollar"></i> <?php echo e(trans('Withdraw history')); ?>

                </a>
            </li>
            
            
            <hr></hr>
            <li>
                <a href="<?php echo e(route('admin.typeUsers', 'investors')); ?>" class="sidebar-link">
                    <span class="hide-menu"><?php echo e(trans("My Inbox")); ?></span>
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('user.ticket.list')); ?>" class="sidebar-link <?php echo e(menuActive(['user.ticket.list', 'user.ticket.create', 'user.ticket.view'])); ?>">
                    <i class="fal fa-user-headset"></i> <?php echo app('translator')->get('support ticket'); ?>
                </a>
            </li>
            
            <hr></hr>
            
            
            
            
            <li>
                <a href="<?php echo e(route('user.referral')); ?>" class="sidebar-link <?php echo e(menuActive(['user.referral'])); ?>">
                    <i class="fal fa-retweet-alt"></i> <?php echo app('translator')->get('my referral'); ?>
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('user.referral.bonus')); ?>" class="sidebar-link <?php echo e(menuActive(['user.referral.bonus', 'user.referral.bonus.search'])); ?>">
                    <i class="fal fa-box-usd"></i> <?php echo app('translator')->get('referral bonus'); ?>
                </a>
            </li>
            
            <li>
                <a href="<?php echo e(route('user.profile')); ?>" class="sidebar-link <?php echo e(menuActive(['user.profile'])); ?>">
                    <i class="fal fa-user"></i> <?php echo app('translator')->get('profile settings'); ?>
                </a>
            </li>
            
        </ul>
    </nav>
    
</div>
<?php /**PATH D:\project\ribano\resources\views/themes/lightpink/partials/sidebar.blade.php ENDPATH**/ ?>