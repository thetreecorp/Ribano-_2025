<?php $__env->startSection('title',trans('Dashboard')); ?>
<?php $__env->startSection('content'); ?>
    <!-- main -->
    <div class="container-fluid">
        <div class="main row">
            <div class="col-12">
                <div class="row g-4 mb-4">
                    
                </div>
                <div class="row g-4 mb-4">
                    <div class="col-xl-3 col-md-6">
                        <div class="dashboard-box">
                            <h5><?php echo app('translator')->get('Total Invest'); ?></h5>
                            <h3>
                                <small><sup><?php echo e(trans(config('basic.currency_symbol'))); ?></sup></small><?php echo e($totalSum ?? 0); ?>

                            </h3>
                            <i class="far fa-search-dollar"></i>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="dashboard-box box-4">
                            <h5><?php echo app('translator')->get('Total Earn'); ?></h5>
                            <h3>
                                <small><sup><?php echo e(trans(config('basic.currency_symbol'))); ?></sup></small><?php echo e(getAmount($totalInterestProfit,
                                config('basic.fraction_number'))); ?>

                            </h3>
                            <i class="far fa-badge-dollar"></i>
                        </div>
                    </div>
                    
                    
                    <div class="col-xl-3 col-md-6">
                        <div class="dashboard-box box-4">
                            <h5><?php echo app('translator')->get('Total Referral Bonus'); ?></h5>
                            <h3>
                                <small><sup><?php echo e(trans(config('basic.currency_symbol'))); ?></sup></small><?php echo e(getAmount($depositBonus + $investBonus)); ?>

                            </h3>
                            <i class="fal fa-lightbulb-dollar"></i>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="dashboard-box box-3">
                            <h5><?php echo app('translator')->get('Total Ticket'); ?></h5>
                            <h3><?php echo e($ticket); ?></h3>
                            <i class="fal fa-ticket"></i>
                        </div>
                    </div>
                </div>

                <!-- charts -->
                <section class="chart-information">
                    <div class="row">
                        <div class="col-lg-6 mb-4 mb-lg-0">
                            <div class="progress-wrapper">
                                <div
                                    id="container"
                                    class="apexcharts-canvas"
                                ></div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="progress-wrapper progress-wrapper-circle">
                                <div class="progress-container d-flex flex-column flex-sm-row justify-content-around">
                                    <div class="circular-progress cp_1">
                                        <svg
                                            class="radial-progress"
                                            data-percentage="<?php echo e(getPercent($roi['totalInvest'], $roi['completed'])); ?>"
                                            viewBox="0 0 80 80"
                                        >
                                            <circle
                                                class="incomplete"
                                                cx="40"
                                                cy="40"
                                                r="35"
                                            ></circle>
                                            <circle
                                                class="complete"
                                                cx="40"
                                                cy="40"
                                                r="35"
                                                style="
                                    stroke-dashoffset: 39.58406743523136;
                                    "
                                            ></circle>
                                            <text
                                                class="percentage"
                                                x="50%"
                                                y="53%"
                                                transform="matrix(0, 1, -1, 0, 80, 0)"
                                            >
                                                <?php echo e(getPercent($roi['totalInvest'], $roi['completed'])); ?> %
                                            </text>
                                        </svg>
                                        <h4 class="golden-text mt-4 text-center">
                                            <?php echo app('translator')->get('Invest Completed'); ?>
                                        </h4>
                                    </div>

                                    <div class="circular-progress cp_3">
                                        <svg
                                            class="radial-progress"
                                            data-percentage="<?php echo e(100 - getPercent($roi['expectedProfit'], $roi['returnProfit'])); ?>"
                                            viewBox="0 0 80 80"
                                        >
                                            <circle
                                                class="incomplete"
                                                cx="40"
                                                cy="40"
                                                r="35"
                                            ></circle>
                                            <circle
                                                class="complete"
                                                cx="40"
                                                cy="40"
                                                r="35"
                                                style="
                                    stroke-dashoffset: 39.58406743523136;
                                    "
                                            ></circle>
                                            <text
                                                class="percentage"
                                                x="50%"
                                                y="53%"
                                                transform="matrix(0, 1, -1, 0, 80, 0)"
                                            >
                                                <?php echo e(100 - getPercent($roi['expectedProfit'], $roi['returnProfit'])); ?> %
                                            </text>
                                        </svg>

                                        <h4 class="golden-text mt-4 text-center">
                                            <?php echo app('translator')->get('ROI Speed'); ?>
                                        </h4>
                                    </div>

                                    <div class="circular-progress cp_2">
                                        <svg
                                            class="radial-progress"
                                            data-percentage="<?php echo e(getPercent($roi['expectedProfit'], $roi['returnProfit'])); ?>"
                                            viewBox="0 0 80 80"
                                        >
                                            <circle
                                                class="incomplete"
                                                cx="40"
                                                cy="40"
                                                r="35"
                                            ></circle>
                                            <circle
                                                class="complete"
                                                cx="40"
                                                cy="40"
                                                r="35"
                                                style="
                                    stroke-dashoffset: 147.3406954533613;
                                    "
                                            ></circle>
                                            <text
                                                class="percentage"
                                                x="50%"
                                                y="53%"
                                                transform="matrix(0, 1, -1, 0, 80, 0)"
                                            >
                                                <?php echo e(getPercent($roi['expectedProfit'], $roi['returnProfit'])); ?> %
                                            </text>
                                        </svg>

                                        <h4 class="golden-text mt-4 text-center">
                                            <?php echo app('translator')->get('ROI Redeemed'); ?>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="row g-4 mb-4">
                    

                    <div class="col-xl-6 col-md-6">
                        <div class="dashboard-box box-2">
                            <h5><?php echo app('translator')->get('The Last Referral Bonus'); ?></h5>
                            <h3>
                                <small><sup><?php echo e(trans(config('basic.currency_symbol'))); ?></sup></small><?php echo e(getAmount($interestBalance, config('basic.fraction_number'))); ?>

                            </h3>
                            <i class="fal fa-box-open"></i>
                        </div>
                    </div>
                    <div class="<?php echo e(auth()->user()->rank ? 'col-xl-6':'col-xl-9'); ?>  col-md-12">
                        <div class="dashboard-box">
                            <h5><?php echo app('translator')->get('Referral Link'); ?></h5>
                            <div class="input-group mb-3 cutom__referal_input__group">
                                <input type="text" class="form-control"
                                       value="<?php echo e(route('register.sponsor',[Auth::user()->username])); ?>" id="sponsorURL"
                                       readonly>
                                <button class="input-group-text btn-custom copy__referal_btn copytext" id="copyBoard"
                                        onclick="copyFunction()"><?php echo app('translator')->get('copy link'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>

    <script src="<?php echo e(asset($themeTrue.'js/apexcharts.js')); ?>"></script>

    <script>
        "use strict";

        var options = {
            theme: {
                mode: "light",
            },

            series: [
                {
                    name: "<?php echo e(trans('Investment')); ?>",
                    color: 'rgba(247, 147, 26, 1)',
                    data: <?php echo $monthly['investment']->flatten(); ?>

                },
                {
                    name: "<?php echo e(trans('Payout')); ?>",
                    color: 'rgba(240, 16, 16, 1)',
                    data: <?php echo $monthly['payout']->flatten(); ?>

                },
                {
                    name: "<?php echo e(trans('Deposit')); ?>",
                    color: 'rgba(255, 72, 0, 1)',
                    data: <?php echo $monthly['funding']->flatten(); ?>

                },
                {
                    name: "<?php echo e(trans('Deposit Bonus')); ?>",
                    color: 'rgba(39, 144, 195, 1)',
                    data: <?php echo $monthly['referralFundBonus']->flatten(); ?>

                },
                {
                    name: "<?php echo e(trans('Investment Bonus')); ?>",
                    color: 'rgba(136, 203, 245, 1)',
                    data: <?php echo $monthly['referralInvestBonus']->flatten(); ?>

                }
            ],
            chart: {
                type: 'bar',
                // height: ini,
                background: '#000',
                toolbar: {
                    show: false
                }

            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: <?php echo $monthly['investment']->keys(); ?>,

            },
            yaxis: {
                title: {
                    text: ""
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                colors: ['#000'],
                y: {
                    formatter: function (val) {
                        return "<?php echo e(trans($basic->currency_symbol)); ?>" + val + ""
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#container"), options);
        chart.render();

        function copyFunction() {
            var copyText = document.getElementById("sponsorURL");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            /*For mobile devices*/
            document.execCommand("copy");
            Notiflix.Notify.Success(`Copied: ${copyText.value}`);
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\project\ribano\resources\views/themes/lightpink/user/dashboard.blade.php ENDPATH**/ ?>