<!DOCTYPE html>
<!--[if lt IE 7 ]>
<html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>
<html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>
<html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->

<html class="no-js" lang="en" <?php if(session()->get('rtl') == 1): ?> dir="rtl" <?php endif; ?> >
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <?php echo $__env->make('partials.seo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <link rel="stylesheet" type="text/css" href="<?php echo e(asset($themeTrue.'css/bootstrap.min.css')); ?>" />

    <?php echo $__env->yieldPushContent('css-lib'); ?>

    <link rel="stylesheet" type="text/css" href="<?php echo e(asset($themeTrue.'css/aos.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset($themeTrue.'css/radialprogress.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset($themeTrue.'css/jquery-ui.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset($themeTrue.'css/select2.min.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset($themeTrue.'css/style_dashboard.css')); ?>">
    <script src="<?php echo e(asset($themeTrue.'js/modernizr.custom.js')); ?>"></script>

    <?php echo $__env->yieldPushContent('style'); ?>
    <script type="application/javascript" src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script type="application/javascript" src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <link href="https://unpkg.com/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
</head>
<body  <?php if(session()->get('rtl') == 1): ?> class="rtl" <?php endif; ?> onload="preloder_function()" class="">

    <!-- preloader_area_start -->
    <div id="preloader">
    </div>
    <!-- preloader_area_end -->

    <div class="dashboard-wrapper">
        <!------ sidebar ------->
        <?php echo $__env->make($theme.'partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- content -->
        <div id="content">
            <div class="overlay">
                <!-- navbar -->
                <nav class="navbar navbar-expand-lg">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="<?php echo e(url('/')); ?>"> <?php echo e(config('basic.site_title')); ?></a>
                        <button class="sidebar-toggler" onclick="toggleSideMenu()">
                            <i class="fal fa-bars"></i>
                        </button>
                        <span class="navbar-text">
                        <!-- notification panel -->
                        <?php echo $__env->make($theme.'partials.pushNotify', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                         <!-- user panel -->
                        <?php echo $__env->make($theme.'partials.userDropdown', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                     </span>
                    </div>
                </nav>
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>
    </div>

    <!-- arrow up -->
    <a href="#" class="scroll-up"><i class="fal fa-long-arrow-up"></i> </a>

<?php echo $__env->yieldPushContent('loadModal'); ?>

<script src="<?php echo e(asset($themeTrue.'js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset($themeTrue.'js/jquery-3.6.1.min.js')); ?>"></script>
<script src="<?php echo e(asset($themeTrue.'js/jquery-ui.js')); ?>"></script>
<script src="<?php echo e(asset($themeTrue.'js/aos.js')); ?>"></script>
<script src="<?php echo e(asset($themeTrue.'js/radialprogress.js')); ?>"></script>
<script src="<?php echo e(asset($themeTrue.'js/select2.min.js')); ?>"></script>
<script src="<?php echo e(asset($themeTrue.'js/fontawesomepro.js')); ?>"></script>

<?php echo $__env->yieldPushContent('extra-js'); ?>

<script src="<?php echo e(asset('assets/global/js/notiflix-aio-2.7.0.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/global/js/pusher.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/global/js/vue.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/global/js/axios.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/js/toastr.min.js')); ?>"></script>
<!-- custom script -->
<script src="<?php echo e(asset($themeTrue.'js/dashboard.js')); ?>"></script>

<script src="https://unpkg.com/@yaireo/tagify"></script>
<script>
    'use strict';
    let pushNotificationArea = new Vue({
        el: "#pushNotificationArea",
        data: {
            items: [],
        },
        mounted() {
            this.getNotifications();
            this.pushNewItem();
        },
        methods: {
            getNotifications() {
                let app = this;
                axios.get("<?php echo e(route('user.push.notification.show')); ?>")
                    .then(function (res) {
                        app.items = res.data;
                    })
            },
            readAt(id, link) {
                let app = this;
                let url = "<?php echo e(route('user.push.notification.readAt', 0)); ?>";
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
                let url = "<?php echo e(route('user.push.notification.readAll')); ?>";
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
                let channel = pusher.subscribe('user-notification.' + "<?php echo e(Auth::id()); ?>");
                channel.bind('App\\Events\\UserNotification', function (data) {
                    app.items.unshift(data.message);
                });
                channel.bind('App\\Events\\UpdateUserNotification', function (data) {
                    app.getNotifications();
                });
            }
        }
    });
    var input = document.querySelector('input[name=keywords]');
    
    // initialize Tagify on the above input node reference
    new Tagify(input)
</script>

<?php echo $__env->yieldPushContent('script'); ?>


<?php if(session()->has('success')): ?>
    <script>
        Notiflix.Notify.Success("<?php echo app('translator')->get(session('success')); ?>");
    </script>
<?php endif; ?>

<?php if(session()->has('error')): ?>
    <script>
        Notiflix.Notify.Failure("<?php echo app('translator')->get(session('error')); ?>");
    </script>
<?php endif; ?>

<?php if(session()->has('warning')): ?>
    <script>
        Notiflix.Notify.Warning("<?php echo app('translator')->get(session('warning')); ?>");
    </script>
<?php endif; ?>


<?php echo $__env->make('plugins', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script>
        var root = document.querySelector(':root');
        root.style.setProperty('--primary', '<?php echo e(config('basic.base_color')??'#ff007a'); ?>');
    </script>

</body>
</html>
<?php /**PATH D:\project\ribano\resources\views/themes/lightpink/layouts/user.blade.php ENDPATH**/ ?>