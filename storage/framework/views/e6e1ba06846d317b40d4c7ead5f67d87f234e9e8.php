<?php $__env->startSection('title',translate('Projects')); ?>

<?php $__env->startPush('css-lib'); ?>
    <link rel="stylesheet" href="<?php echo e(asset($themeTrue.'css/bootstrap-datepicker.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/css/sweetalert.min.css')); ?>" />
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="main row">
            <div class="col-12">
                <div
                    class="d-flex justify-content-between align-items-center mb-3"
                >
                    <h3 class="mb-0"><?php echo app('translator')->get('Projects'); ?></h3>
                    <a target="_blank" href="<?php echo e(route('user.createProject')); ?>" class="btn btn-success"><?php echo app('translator')->get('Add Project'); ?></a>
                </div>

                <div class="search-bar my-search-bar p-0">
                    <form action="<?php echo e(route('user.searchProject')); ?>" method="get" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <div class="input-box">
                                    <input
                                        type="text"
                                        name="name"
                                        value="<?php echo e(@request()->name); ?>"
                                        class="form-control"
                                        placeholder="<?php echo app('translator')->get('Type Here'); ?>"
                                    />
                                </div>
                            </div>

                            


                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <button class="btn-custom" type="submit"><?php echo app('translator')->get('Search'); ?></button>
                            </div>
                            
                            
                            
                        </div>
                    </form>
                </div>

                <!-- table -->
                <div class="table-parent table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col"><?php echo app('translator')->get('Title'); ?></th>
                                <th scope="col"><?php echo app('translator')->get('Token'); ?></th>
                                <th scope="col"><?php echo app('translator')->get('Country'); ?></th>
                                <th scope="col"><?php echo app('translator')->get('Status'); ?></th>
                                <th scope="col"><?php echo app('translator')->get('Created at'); ?></th>
                                <th scope="col"><?php echo app('translator')->get('Action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($data->title); ?></td>
                                    <td data-label="<?php echo app('translator')->get('Token'); ?>">
                                        <?php echo $data->token->name ?? ''; ?>
                                    </td>
                                    <td><?php echo e($data->country); ?></td>
                                    <td>
                                        <?php 
                                          
                                            switch($data->status) {
                                                case 1:
                                                    echo '<span class="badge badge-success">' . translate("Active") . '</span>';
                                                    break;
                                                default:
                                                    echo '<span class="badge badge-warning">' . translate("In-Active") . '</span>';
                                                    break;
                                            }
                                        
                                        ?>
                                    </td>
                                    <td><?php echo e(dateTime($data->created_at, 'd M Y h:i A')); ?></td>
                                    <td>
                                        <?php if($data->status == 1): ?>
                                            <a target="_blank" href="<?php echo e(route('viewProject', $data->slug)); ?>" class="btn btn-success"><?php echo app('translator')->get('View'); ?></a>
                                        <?php endif; ?>
                                        
                                        <a data-id="<?php echo e($data->id); ?>"  href="javascript:void(0)" class="btn btn-danger delete-project-btn"><?php echo app('translator')->get('Delete'); ?></a>
                                        <a target="_blank" href="<?php echo e(route('user.editProject', $data->slug)); ?>" class="btn btn-warning"><?php echo app('translator')->get('Edit'); ?></a>
                                    </td>
                                </tr>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr class="text-center">
                                    <td colspan="100%"><?php echo e(__('No Data Found!')); ?></td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <?php echo e($projects->appends($_GET)->links()); ?>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset($themeTrue.'js/bootstrap-datepicker.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/js/sweetalert2@11.js')); ?>"></script>
    <script>
        'use strict'
        $(document).ready(function () {
            $( ".datepicker" ).datepicker({
            }); 

            
            
        });
        $('.delete-project-btn').on('click', function () {
            let id = $(this).attr('data-id');
            let url = $(this).attr('data-url');
            Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
              if (result.isConfirmed) {
                // call ajax
                $.ajax({
                    type: 'post',
                    url: "<?php echo e(route('user.deleteProject')); ?>",
                    data: {
                        'id' : id,
                        '_token' : $('meta[name="csrf-token"]').attr('content'),
                    
                    },
                    beforeSend: function(){
                       $(".delete-project-btn").attr("disabled","disabled");
                    },
                    complete: function(){
                        
                    },
                    success:function(data){
                        $(".active-account-btn").attr("disabled","");
                        if(data.code == 200) {
                            Swal.fire({
                                title: data.message,
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Ok'
                            }).then((result) => {
                                if (result.isConfirmed) {
        
                                    location.reload();
                                }
                            })
                        }
                        else {
                            Swal.fire(
                                'Error',
                                data.message,
                                'error'
                            );
                            $(".active-account-btn").attr("disabled","");
                            
                        }
                    },
                    error: function(xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        Swal.fire(
                            'Error',
                            err,
                            'error'
                        );
                        $(".active-account-btn").attr("disabled","");
                    }
                    
                });
               
              }
            })
        });
       
    </script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\project\ribano\resources\views/project/index.blade.php ENDPATH**/ ?>