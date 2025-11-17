<?php $common = app('App\Http\Controllers\ProjectController'); ?>
<div class="project-card">
    <div class="card-banner">
        <div class="card-bg">
            <img class="bg-cover" src="<?php echo e($project->banner ? $common->getLinkIdrive($project->banner) : 'https://placehold.jp/1920x600.png'); ?>" alt="bg-cover">
        </div>
    </div>
    <div class="card-img">
        <div class="card-logo">
            <img alt="logo" src="<?php echo e($project->logo ? $common->getLinkIdrive($project->logo) : 'https://placehold.jp/86x86.png'); ?>" alt="project-logo">
        </div>
        
    </div>
    
    <?php echo $__env->make('project.raised', ['project' => $project], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="card-content">
        <a href="<?php echo e(route('viewProject', $project->slug)); ?>">
            <div class="card-title">
                <p><strong><?php echo e($project->title ?? translate('N/A')); ?></strong></p>
                <p><label><?php echo e(translate("Address")); ?>: </label> <?php echo e($project->country ?? translate('N/A')); ?> </p>
            </div>
        </a>
        <div class="project-description">
            <div class="summary">
                                
                <?php if($project->short_summary): ?>
                    <div class="content-item">
                        <div class="desc-content ">
                            <?php echo excerptText($project->short_summary, 20); ?>

                        </div>
                    </div>
                    
                <?php endif; ?>
            </div>
            
            
            <div class="card-bottom">
                <div class="row">
                    <div class="col-sm-6 col-md-6">
                        <?php 
                            $count_raising = $project->raising ?? 'N/A';
                        ?>
                        <?php if($project->raising): ?>
                            <div class="bottom-raising">
                                <h6><?php echo e($project->raising ? 'US$ ' . $project->raising : translate('N/A')); ?></h6>
                                <span><span class="editableLabel" labelid="global:needed"><?php echo e(translate("Target")); ?></span></span>
                            </div>
                        <?php endif; ?>
                        
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="bottom-raising">
                            <h6><?php echo e($project->minimum_equity_investment ? 'US$ ' . $project->minimum_equity_investment :  ''); ?></h6>
                            <span><span class="editableLabel" labelid="global:needed"><?php echo e(translate("Min per Investor")); ?></span></span>
                        </div>
                    </div>
                    <?php if(isset($type) && $type == 'my-pitches'): ?>
                        <div class="active-buttons">
                            <a class="no-effect" href="<?php echo e(route('user.editProject', $project->slug)); ?>">
                                <span class="btn btn-primary"><?php echo e(translate("Edit my Pitch")); ?></span>
                            </a>
                            <a href="javasscript:void(0)"
                                class="ms-3 js-call-delete-pitch">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo e(route('viewProject', $project->slug)); ?>" class="btn btn-primary" target="_blank"><?php echo e(translate("Find Out
                            More")); ?></a>
                    <?php endif; ?>
                    
                </div>
            </div>
            
        </div>
    </div>
</div><?php /**PATH D:\project\ribano\resources\views/project/project_box_home.blade.php ENDPATH**/ ?>