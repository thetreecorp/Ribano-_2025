<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(getFile(config('location.logoIcon.path').'favicon.png')); ?>">
    <title><?php echo app('translator')->get($basic->site_title); ?> | <?php echo $__env->yieldContent('title'); ?></title>
    <?php echo $__env->yieldPushContent('style-lib'); ?>
    <link href="<?php echo e(asset('assets/admin/css/bootstrap4-toggle.min.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/themes/deepblue/css/all.min.css')); ?>"/>
    <link href="<?php echo e(asset('assets/admin/css/select2.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/admin/css/style.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/admin/css/custom.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('public/assets/css/toastr.min.css')); ?>" rel="stylesheet">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    <meta name="csrf_token" content="<?php echo e(csrf_token()); ?>" />
    <?php echo $__env->yieldPushContent('style'); ?>
</head>
<body>
<div class="preloader">
    <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
    </div>
</div>

<div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
     data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">

    <?php echo $__env->make('admin.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('admin.layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    

    <div class="page-wrapper">
        <div class="near-info">
            <div class="near-logo">
                <div class="sc-gJbFto jmxYuh logo">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 414 162" class="near-logo">
                        <g id="Layer_1" data-name="Layer 1">
                            <path
                                d="M207.21,54.75v52.5a.76.76,0,0,1-.75.75H201a7.49,7.49,0,0,1-6.3-3.43l-24.78-38.3.85,19.13v21.85a.76.76,0,0,1-.75.75h-7.22a.76.76,0,0,1-.75-.75V54.75a.76.76,0,0,1,.75-.75h5.43a7.52,7.52,0,0,1,6.3,3.42l24.78,38.24-.77-19.06V54.75a.75.75,0,0,1,.75-.75h7.22A.76.76,0,0,1,207.21,54.75Z"
                                style="fill: rgb(63 57 57);"></path>
                            <path
                                d="M281,108h-7.64a.75.75,0,0,1-.7-1L292.9,54.72A1.14,1.14,0,0,1,294,54h9.57a1.14,1.14,0,0,1,1.05.72L324.8,107a.75.75,0,0,1-.7,1h-7.64a.76.76,0,0,1-.71-.48l-16.31-43a.75.75,0,0,0-1.41,0l-16.31,43A.76.76,0,0,1,281,108Z"
                                style="fill: rgb(52 47 47);"></path>
                            <path
                                d="M377.84,106.79,362.66,87.4c8.57-1.62,13.58-7.4,13.58-16.27,0-10.19-6.63-17.13-18.36-17.13H336.71a1.12,1.12,0,0,0-1.12,1.12h0a7.2,7.2,0,0,0,7.2,7.2H357c7.09,0,10.49,3.63,10.49,8.87s-3.32,9-10.49,9H336.71a1.13,1.13,0,0,0-1.12,1.13v26a.75.75,0,0,0,.75.75h7.22a.76.76,0,0,0,.75-.75V87.87h8.33l13.17,17.19a7.51,7.51,0,0,0,6,2.94h5.48A.75.75,0,0,0,377.84,106.79Z"
                                style="fill: rgb(57 51 51);"></path>
                            <path
                                d="M258.17,54h-33.5a1,1,0,0,0-1,1h0A7.33,7.33,0,0,0,231,62.33h27.17a.74.74,0,0,0,.75-.75V54.75A.75.75,0,0,0,258.17,54Zm0,45.67h-25a.76.76,0,0,1-.75-.75V85.38a.75.75,0,0,1,.75-.75h23.11a.75.75,0,0,0,.75-.75V77a.75.75,0,0,0-.75-.75H224.79a1.13,1.13,0,0,0-1.12,1.13v29.45a1.12,1.12,0,0,0,1.12,1.13h33.38a.75.75,0,0,0,.75-.75v-6.83A.74.74,0,0,0,258.17,99.67Z"
                                style="fill: rgb(42 39 39);"></path>
                            <path
                                d="M108.24,40.57,89.42,68.5a2,2,0,0,0,3,2.63l18.52-16a.74.74,0,0,1,1.24.56v50.29a.75.75,0,0,1-1.32.48l-56-67A9.59,9.59,0,0,0,47.54,36H45.59A9.59,9.59,0,0,0,36,45.59v70.82A9.59,9.59,0,0,0,45.59,126h0a9.59,9.59,0,0,0,8.17-4.57L72.58,93.5a2,2,0,0,0-3-2.63l-18.52,16a.74.74,0,0,1-1.24-.56V56.07a.75.75,0,0,1,1.32-.48l56,67a9.59,9.59,0,0,0,7.33,3.4h2a9.59,9.59,0,0,0,9.59-9.59V45.59A9.59,9.59,0,0,0,116.41,36h0A9.59,9.59,0,0,0,108.24,40.57Z"
                                style="fill: rgb(36 33 33);"></path>
                        </g>
                    </svg>
                </div>
            </div>
            <div class="near-detail">
                <div id="loginWrap">
                </div>
                <div id="loginInfo">
                    <div id="logoutContainer"></div>
                </div>
            </div>
        
        </div>
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-7 align-self-center">
                    <h4 class="page-title text-truncate text-dark font-weight-medium mb-1"><?php echo $__env->yieldContent('title'); ?></h4>

                    <div class="d-flex align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb m-0 p-0">
                                <li class="breadcrumb-item text-muted active" aria-current="page"><?php echo app('translator')->get('Dashboard'); ?></li>
                                <li class="breadcrumb-item text-muted" aria-current="page"><?php echo $__env->yieldContent('title'); ?></li>
                            </ol>
                        </nav>
                    </div>

                </div>

            </div>
        </div>

        <?php echo $__env->yieldContent('content'); ?>


        <footer class="footer text-center text-muted">
            <?php echo e(trans('Copyrights')); ?> © <?php echo e(date('Y')); ?> <?php echo app('translator')->get('All Rights Reserved By'); ?> <?php echo app('translator')->get($basic->site_title); ?>
        </footer>

    </div>
</div>



<script src="<?php echo e(asset('assets/global/js/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/global/js/popper.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/global/js/bootstrap.min.js')); ?>"></script>
<?php echo $__env->yieldPushContent('js-lib'); ?>
<script src="<?php echo e(asset('public/js/NearIntegration.js')); ?>"></script>
<script src="<?php echo e(asset('public/js/app.js')); ?>"></script>
<script src="<?php echo e(asset('assets/admin/js/bootstrap4-toggle.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/admin/js/app-style-switcher.js')); ?>"></script>
<script src="<?php echo e(asset('assets/admin/js/feather.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/global/js/notiflix-aio-2.7.0.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/admin/js/perfect-scrollbar.jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/admin/js/sidebarmenu.js')); ?>"></script>
<script src="<?php echo e(asset('assets/admin/js/select2.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/admin/js/admin-mart.js')); ?>"></script>

<?php echo $__env->make('admin.layouts.notification', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script src="<?php echo e(asset('assets/global/js/axios.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/global/js/vue.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/global/js/pusher.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/js/toastr.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/admin/js/custom.js')); ?>"></script>
<?php echo $__env->yieldPushContent('js'); ?>
<?php echo $__env->yieldPushContent('extra-script'); ?>


<script>
    'use strict';
    let pushNotificationArea = new Vue({
        el: "#pushNotificationArea",
        data: {
            items: [],
        },
        beforeMount() {
            this.getNotifications();
            this.pushNewItem();
        },
        methods: {
            getNotifications() {
                let app = this;
                axios.get("<?php echo e(route('admin.push.notification.show')); ?>")
                    .then(function (res) {
                        app.items = res.data;
                    })
            },
            readAt(id, link) {
                let app = this;
                let url = "<?php echo e(route('admin.push.notification.readAt', 0)); ?>";
                url = url.replace(/.$/, id);
                axios.get(url)
                    .then(function (res) {
                        if (res.status) {
                            app.getNotifications();
                            if (link != '#') {
                                window.location.href = link
                            }
                        }
                    })
            },
            readAll() {
                let app = this;
                let url = "<?php echo e(route('admin.push.notification.readAll')); ?>";
                axios.get(url)
                    .then(function (res) {
                        if (res.status) {
                            app.items = [];
                        }
                    })
            },
            pushNewItem() {
                let app = this;
                // Pusher.logToConsole = true;
                let pusher = new Pusher("<?php echo e(env('PUSHER_APP_KEY')); ?>", {
                    encrypted: true,
                    cluster: "<?php echo e(env('PUSHER_APP_CLUSTER')); ?>"
                });
                let channel = pusher.subscribe('admin-notification.' + "<?php echo e(Auth::guard('admin')->id()); ?>");
                channel.bind('App\\Events\\AdminNotification', function (data) {
                    app.items.unshift(data.message);
                });
                channel.bind('App\\Events\\UpdateAdminNotification', function (data) {
                    app.getNotifications();
                });
            }
        }
    });
</script>

</body>
</html>
<?php /**PATH D:\project\ribano\resources\views/admin/layouts/app.blade.php ENDPATH**/ ?>