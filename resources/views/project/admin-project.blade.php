@extends('admin.layouts.app')
@section('title')
    @lang('Project')
@endsection

@section('content')
    
    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        <div class="card-body">

            <div class="media mb-4 justify-content-between">

                

                @if(adminAccessRoute(config('role.manage_plan.access.add')))
                    <a href="{{route('admin.createProject')}}" class="btn btn-sm  btn-primary mr-2">
                        <span><i class="fas fa-plus"></i> @lang('Add New')</span>
                    </a>
                @endif

                @if(adminAccessRoute(config('role.manage_plan.access.edit')))
                    <div class="dropdown mb-2 text-right">
                        <button class="btn btn-sm  btn-dark dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span><i class="fas fa-bars pr-2"></i> @lang('Action')</span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <button class="dropdown-item" type="button" data-toggle="modal"
                                    data-target="#all_active">@lang('Active')</button>
                            <button class="dropdown-item" type="button" data-toggle="modal"
                                    data-target="#all_inactive">@lang('Inactive')</button>
                        </div>
                    </div>
                @endif
            </div>

            
            <div class="table-responsive">
                <table class="categories-show-table table table-hover table-striped table-bordered" id="zero_config">
                    <thead class="thead-dark">
                    <tr>
                        @if(adminAccessRoute(config('role.manage_plan.access.edit')))
                        <th scope="col" class="text-center">
                            <input type="checkbox" class="form-check-input check-all tic-check" name="check-all"
                                   id="check-all">
                            <label for="check-all"></label>
                        </th>
                        @endif
                        <th scope="col">@lang('Title')</th>
                        <th scope="col">@lang('Location')</th>
                        <th scope="col">@lang('Xeedwallet')</th>
                        <th scope="col">@lang('Token')</th>
                        <th scope="col">@lang('Featured')</th>
                        <th scope="col">@lang('Status')</th>
                        @if(adminAccessRoute(config('role.manage_plan.access.edit')))
                        <th scope="col">@lang('Action')</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($projects as $item)
                        <tr>
                            @if(adminAccessRoute(config('role.manage_plan.access.edit')))
                            <td class="text-center">
                                <input type="checkbox" id="chk-{{ $item->id }}"
                                       class="form-check-input row-tic tic-check" name="check" value="{{$item->id}}"
                                       data-id="{{ $item->id }}">
                                <label for="chk-{{ $item->id }}"></label>
                            </td>
                            @endif

                            <td data-label="@lang('title')">
                                @lang($item->title)
                            </td>
                            <td data-label="@lang('located')">
                                <p class="font-weight-bold">{{$item->located}}</p>
                            </td>

                            <td data-label="@lang('Xeedwallet')">
                                @if ($item->xeedwallet)
                                        <a data-id={{$item->xeedwallet->id}} class="view-xeedwallet-button badge badge-success" href="javascript:void(0)">View Xeedwallet</a>
                                        <a data-id={{$item->id}} class="set-xeedwallet-btn badge badge-warning" href="javascript:void(0)">Set Xeedwallet</a>
                                    @else
                                        <a data-id={{$item->id}} class="set-xeedwallet-btn badge badge-warning" href="javascript:void(0)">Set Xeedwallet</a>
                                @endif
                               
                            </td>
                            <td data-label="@lang('Token')">
                                <?php echo $item->token->name ?? ''; ?>
                            </td>
                            <td data-label="@lang('Featured')">
                                <input id="ckb-{{$item->id}}" <?php echo $item->is_featured == 1 ? 'checked' : '' ?> value="{{$item->id}}" type="checkbox" class="form-check-input row-tick-featured tic-check"  data-id="{{ $item->id }}">
                                <label for="ckb-{{$item->id}}"></label>
                            </td>
                            <td data-label="@lang('status')">
                                <?php 
                                    switch($item->status) {
                                        case 1:
                                            echo '<span class="badge badge-success">' . trans("Active") . '</span>';
                                            break;
                                        default:
                                            echo '<span class="badge badge-warning">' . trans("In-Active") . '</span>';
                                            break;
                                    }
                                
                                ?>
                            </td>

                            @if(adminAccessRoute(config('role.manage_plan.access.edit')))
                            <td data-label="@lang('Action')">
                                <div class="dropdown show">
                                    <a class="dropdown-toggle p-3" href="#" id="dropdownMenuLink" data-toggle="dropdown"
                                       aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        @if ($item->status == 1)
                                            <a target="_blank" class="dropdown-item" href="{{ route('viewProject', $item->slug) }}">
                                                <i class="fa fa-eye text-warning pr-2"
                                                   aria-hidden="true"></i> @lang('View')
                                            </a>
                                        @endif

                                        <a class="dropdown-item" href="{{ route('admin.cloneProject', $item->id) }}">
                                            <i class="fa fa-edit text-warning pr-2"
                                               aria-hidden="true"></i> @lang('Clone')
                                        </a>
                                        
                                        <a target="_blank" class="dropdown-item" href="{{ route('admin.editProject', $item->slug) }}">
                                            <i class="fa fa-edit text-warning pr-2"
                                               aria-hidden="true"></i> @lang('Edit')
                                        </a>
                                        <a data-id="{{$item->id}}" class="dropdown-item delete-project-btn" href="javascript:void(0)" >
                                            <i class="fa fa-trash text-warning pr-2"
                                               aria-hidden="true"></i> @lang('Delete')
                                        </a>
                                    </div>
                                </div>
                            </td>
                            @endif
                        </tr>

                    @empty
                        <tr>
                            <td colspan="100%">@lang('No Data Found')</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="view_detail_xeedwallet" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-colored-header bg-primary">
                        <h5 class="modal-title">@lang('View Xeedwallet')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class=" col-md-6">
                                <div class="form-group">
                                    <label>@lang('Email')</label>
                                    <input disabled type="text" name="email" value="" placeholder="{{translate('Email')}}" class="form-control" >
                                   
                                </div>
                            </div>
                            <div class=" col-md-6">
                                <div class="form-group">
                                    <label>@lang('Password')</label>
                                    <input disabled type="text" name="password" value="" placeholder="@lang('Password')" class="form-control">
                                    
                                </div>
                            </div>
        
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <div class="form-group">
                                    <label>@lang('Client id')</label>
                                    <input disabled type="text" name="client_id" value="" placeholder="{{translate('Client id')}}" class="form-control" >
                                   
                                </div>
                            </div>
                            <div class=" col-md-12">
                                <div class="form-group">
                                    <label>@lang('Secret')</label>
                                    <input disabled type="text" name="secret" value="" placeholder="@lang('Secret')" class="form-control">
                                   
                                </div>
                            </div>
        
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal"><span>@lang('Close')</span></button>
                        
                    </div>
                </div>
            </div>
    </div>

    
    
    <div class="modal fade" id="set_xeedwallet" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title">@lang('Set Xeedwallet')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class=" col-md-12">
                            
                                <form id="set-xeedwallet-form" action="{{route('admin.setXeedwallet')}}" method="post">
                                    @csrf
                                    @if ($manageWallets)
                                        <div class="col-md-12">
                                            <select class="form-control" id="xeedwallet-select">
                                                @foreach ($manageWallets as $val)
                                                    <option value="{{$val->id}}">{{$val->email}}</option>
                                                @endforeach
                                            
                                            </select>
                                            <input name="project-id" type="hidden" value="">
                                        </div>
                                        <div class="col-md-6 mt-5">
                                            <button type="submit" class="btn btn-light"><span>@lang('Update')</span></button>
                                        </div>
                                        @else
                                            <p>{{translate("Xeedwallet user not found")}}</p>
                                    @endif
                                    
                                    
                                </form>
                            
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal"><span>@lang('Close')</span></button>
                    
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="all_active" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title">@lang('Active Project Confirmation')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                </div>
                <div class="modal-body">
                    <p>@lang("Are you really want to active the Project's")</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal"><span>@lang('No')</span></button>
                    <form action="" method="post">
                        @csrf
                        <a href="" class="btn btn-primary active-yes"><span>@lang('Yes')</span></a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="all_inactive" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title">@lang('DeActive Project Confirmation')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                </div>
                <div class="modal-body">
                    <p>@lang("Are you really want to Inactive the project's")</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal"><span>@lang('No')</span></button>
                    <form action="" method="post">
                        @csrf
                        <a href="" class="btn btn-primary inactive-yes"><span>@lang('Yes')</span></a>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('style-lib')
    <link href="{{asset('assets/admin/css/dataTables.bootstrap4.css')}}" rel="stylesheet">
@endpush
@push('js')
    <script src="{{ asset('assets/admin/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/datatable-basic.init.js') }}"></script>
    <script src="{{ asset('public/assets/js/sweetalert2@11.js') }}"></script>

    @if ($errors->any())
        @php
            $collection = collect($errors->all());
            $errors = $collection->unique();
        @endphp
        <script>
            "use strict";
            @foreach ($errors as $error)
            Notiflix.Notify.Failure("{{trans($error)}}");
            @endforeach
        </script>
    @endif

    <script>
        "use strict";
        $(document).ready(function () {
            $(document).on('click', '#check-all', function () {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });

            $(document).on('click', '.view-xeedwallet-button', function () {
                //$('#view_detail_xeedwallet').modal('show');
                let id = $(this).attr('data-id');
               
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                    url: "{{ route('admin.viewXeedwallet') }}",
                    data: {id: id},
                    datatType: 'json',
                    type: "post",
                    success: function (data) {
                      
                       if(data.status == 1) {
                        $('#view_detail_xeedwallet input[name="email"]').val(data.data.email);
                        $('#view_detail_xeedwallet input[name="password"]').val(data.data.password);
                        $('#view_detail_xeedwallet input[name="client_id"]').val(data.data.client_id);
                        $('#view_detail_xeedwallet input[name="secret"]').val(data.data.secret);
                        $('#view_detail_xeedwallet').modal('show');
                       }
                       else {
                            showToast(data.data.message, 1000, 'error');
                       }

                    },
                });
            });

            $(document).on('change', ".row-tic", function () {
                let length = $(".row-tic").length;
                let checkedLength = $(".row-tic:checked").length;
                if (length == checkedLength) {
                    $('#check-all').prop('checked', true);
                } else {
                    $('#check-all').prop('checked', false);
                }
            });


            //multiple active
            $(document).on('click', '.active-yes', function (e) {
                e.preventDefault();
                var allVals = [];
                $(".row-tic:checked").each(function () {
                    allVals.push($(this).attr('data-id'));
                });

                var strIds = allVals;

                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                    url: "{{ route('admin.project-active') }}",
                    data: {strIds: strIds},
                    datatType: 'json',
                    type: "post",
                    success: function (data) {
                        location.reload();

                    },
                });
            });

            //multiple deactive
            $(document).on('click', '.inactive-yes', function (e) {
                e.preventDefault();
                var allVals = [];
                $(".row-tic:checked").each(function () {
                    allVals.push($(this).attr('data-id'));
                });

                var strIds = allVals;
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                    url: "{{ route('admin.project-inactive') }}",
                    data: {strIds: strIds},
                    datatType: 'json',
                    type: "post",
                    success: function (data) {
                        location.reload();

                    }
                });
            });
            
            
            $(document).on('change', ".row-tick-featured", function () {
                var active = 'on';
                let id = $(this).val();
                if($(this).is(":checked")) 
                   active = 'on';

                else 
                    active = 'off';
                // run ajax
                $.ajax({
                    type: 'post',
                    url: "{{ route('admin.setFeaturedProject') }}",
                    data: {
                        'id' : id,
                        'active' : active,
                        '_token' : $('meta[name="csrf-token"]').attr('content'),
                    
                    },
                    beforeSend: function(){
                       
                       $(".row-tick-featured").attr('disabled', true)
                    },
                    complete: function(){
                        
                    },
                    success:function(data){
                        $(".row-tick-featured").attr('disabled', false);
                        if(active == 'on')
                            showToast(data.message, 1000, 'success');
                        else
                            showToast(data.message, 1000, 'warning');
                    },
                    error: function(xhr, status, error) {
                        $(".row-tick-featured").attr('disabled', false);
                        showToast(data.message, 1000, 'error');
                    }
                    
                });
                
            });
            function showToast(message, timeout, type) {
                type = (typeof type === 'undefined') ? 'info' : type;
                toastr.options.timeOut = timeout;
                toastr.options.progressBar = true;
                toastr[type](message);
            }

            $('body').on('click', '.delete-project-btn', function () {
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
                        url: "{{ route('admin.deleteProject') }}",
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
                            $(".delete-project-btn").attr("disabled","");
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
                                $(".delete-project-btn").attr("disabled","");
                                
                            }
                        },
                        error: function(xhr, status, error) {
                            var err = eval("(" + xhr.responseText + ")");
                            Swal.fire(
                                'Error',
                                err,
                                'error'
                            );
                            $(".delete-project-btn").attr("disabled","");
                        }
                        
                    });
               
                }
            })
        });


        });

    </script>
@endpush
