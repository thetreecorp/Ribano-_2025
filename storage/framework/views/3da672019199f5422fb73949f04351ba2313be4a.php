<?php $common = app('App\Http\Controllers\User\HomeController'); ?>

<?php $__env->startSection('title',trans('Invest History')); ?>
<?php $__env->startSection('content'); ?>
    <script>
        "use strict"
        function getCountDown(elementId, seconds) {
            var times = seconds;
            var x = setInterval(function () {
                var distance = times * 1000;
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                document.getElementById(elementId).innerHTML = days + "d: " + hours + "h " + minutes + "m " + seconds + "s ";
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById(elementId).innerHTML = "COMPLETE";
                }
                times--;
            }, 1000);
        }
    </script>

    <div class="container-fluid">
        <div class="main row">
            <div class="col-12">
                <div
                    class="d-flex justify-content-between align-items-center mb-3"
                >
                    <h3 class="mb-0"><?php echo app('translator')->get('Invest History'); ?></h3>
                </div>
                <!-- table -->
                <div class="table-parent table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col"><?php echo app('translator')->get('SL'); ?></th>
                                <th scope="col"><?php echo app('translator')->get('Project'); ?></th>
                                <th scope="col"><?php echo app('translator')->get('Total Invest'); ?></th>
                                <th scope="col"><?php echo app('translator')->get('Token Name'); ?></th>
                                
                            </tr>
                        </thead>
                        <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $investments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $invest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e(loopIndex($investments) + $key); ?></td>
                                <td>
                                    <?php echo e(!empty($invest->getProject->title) ? $invest->getProject->title : ''); ?>

                                </td>
                                <td>
                                   <?php echo e($invest->totalToken); ?>$
                                </td>
                                <td>
                                   <?php echo e($common->getTokenName($invest->project_id)); ?>

                                </td>
                                
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr class="text-center">
                                <td colspan="100%"><?php echo e(trans('No Data Found!')); ?></td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                    <?php echo e($investments->appends($_GET)->links()); ?>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\project\ribano\resources\views/themes/lightpink/user/transaction/investLog.blade.php ENDPATH**/ ?>