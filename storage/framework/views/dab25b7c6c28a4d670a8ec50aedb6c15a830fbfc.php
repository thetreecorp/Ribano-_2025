<li class="nav-item">
    <a class="nav-link" href="<?php echo e(route('home')); ?>"> <?php echo e(@translate('Home')); ?></a>
</li>
<li class="nav-item dropdown">
    
    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"
        data-bs-auto-close="outside"><?php echo e(@translate('Invest')); ?>

        <i class="fas fa-comments-dollar"></i>
    </a>
    <ul class="dropdown-menu shadow">
        <li>
            <a class="dropdown-item<?php echo e(Request::routeIs('investmentStrategies') ? ' active' : ''); ?>"
                href="<?php echo e(route('investmentStrategies')); ?>"><?php echo e(@translate('Investment Strategies')); ?></a>
        </li>
        <li>
            <a class="dropdown-item<?php echo e(Request::routeIs('investMethod') ? ' active' : ''); ?>"
                href="<?php echo e(route('investMethod')); ?>"><?php echo e(@translate('Invest Method')); ?></a>
        </li>
        <li>
            <a class="dropdown-item<?php echo e(Request::routeIs('investorTerms') ? ' active' : ''); ?>"
                href="<?php echo e(route('investorTerms')); ?>"><?php echo e(@translate('Investor Terms')); ?></a>
        </li>
        
        <li>
            <a class="dropdown-item <?php echo e(Request::routeIs('searchProject') ? 'active' : ''); ?>"
                href="<?php echo e(route('searchProject')); ?>"><?php echo e(@translate('Search Projects')); ?></a>
        </li>

    </ul>
</li>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"
        data-bs-auto-close="outside"><?php echo e(@translate('Fundraising')); ?>

        <i class="fas fa-hand-holding-usd"></i>
    </a>
    <ul class="dropdown-menu shadow">
        <?php if (\Illuminate\Support\Facades\Blade::check('role', 'founder')): ?>
            <li>
                <a class="dropdown-item <?php echo e(Request::routeIs('fundDashboard') ? 'active' : ''); ?>"
                    href="<?php echo e(route('founder.fundDashboard')); ?>"><?php echo e(@translate('My Pitches')); ?></a>
            </li>
            <li>
                <a class="dropdown-item <?php echo e(Request::routeIs('createProject') ? 'active' : ''); ?>"
                    href="<?php echo e(route('founder.myInvestors')); ?>"><?php echo e(@translate('My Investors')); ?></a>
            </li>
            <li>
                <a class="dropdown-item <?php echo e(Request::routeIs('contact') ? 'active' : ''); ?>"
                    href="<?php echo e(route('investorSearch')); ?>"><?php echo e(@translate('Investor Search')); ?></a>
            </li>
        

        <?php else: ?>
            <li>
                <a class="dropdown-item <?php echo e(Request::routeIs('contact') ? 'active' : ''); ?>"
                    href="#"><?php echo e(@translate('How to apply')); ?></a>
            </li>
            <li>
                <a class="dropdown-item <?php echo e(Request::routeIs('createProject') ? 'active' : ''); ?>"
                    href="<?php echo e(route('user.createProject')); ?>"><?php echo e(@translate('Add a pitch')); ?></a>
            </li>
        <?php endif; ?>


    </ul>
</li>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"
        data-bs-auto-close="outside"><?php echo e(@translate('Help')); ?>

        <i class="fas fa-info-circle"></i>
    </a>
    <ul class="dropdown-menu shadow ">
        <li>
            <a class="dropdown-item <?php echo e(Request::routeIs('contact') ? 'active' : ''); ?>"
                href="#"><?php echo e(@translate('How it works')); ?></a>
        </li>
        
        <li>
            <a class="dropdown-item <?php echo e(Request::routeIs('faqsPage') ? 'active' : ''); ?>"
                href="<?php echo e(route('faqsPage')); ?>"><?php echo e(@translate('FAQ Page')); ?></a>
        </li>
        <li>
            <a class="dropdown-item <?php echo e(Request::routeIs('privacy') ? 'active' : ''); ?>"
                href="<?php echo e(route('privacy')); ?>"><?php echo e(@translate('Privacy Policy')); ?></a>
        </li>
        <li>
            <a class="dropdown-item <?php echo e(Request::routeIs('termPolicies') ? 'active' : ''); ?>"
                href="<?php echo e(route('termPolicies')); ?>"><?php echo e(@translate('Term Policies')); ?></a>
        </li>
        <li>
            <a class="dropdown-item <?php echo e(Request::routeIs('aboutUs') ? 'active' : ''); ?>"
                href="<?php echo e(route('aboutUs')); ?>"><?php echo e(@translate('About Us')); ?></a>
        </li>
        

    </ul>
</li>
<?php if(auth()->guard()->guest()): ?>
    <li class="nav-item">
        <a class="nav-link" href="<?php echo e(route('login')); ?>"> <?php echo e(@translate('Sign in')); ?></a>
     
    </li>
    <li class="nav-item">
        <a class="login_btn" href="<?php echo e(route('register')); ?>"> <?php echo e(@translate('Sign up')); ?></a>
    </li>
<?php else: ?>
    <li class="nav-item">
        <a class="" href="<?php echo e(route('user.home')); ?>"> <?php echo e(@translate('Dashboard')); ?></a>
    </li>
<?php endif; ?>

<?php /**PATH D:\project\ribano\resources\views/themes/lightpink/partials/menu.blade.php ENDPATH**/ ?>