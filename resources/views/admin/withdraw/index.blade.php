@extends('admin.layouts.app')
@section('title')
@lang('Approved')
@endsection

@section('content')




<div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">


    <div class="card-body">

        <div class="media mb-4 justify-content-between">

           

            @if(adminAccessRoute(config('role.manage_plan.access.edit')))
            <div class="dropdown mb-2 text-right">
                <button class="btn btn-sm  btn-dark dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span><i class="fas fa-bars pr-2"></i> @lang('Action')</span>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <button class="dropdown-item" type="button" data-toggle="modal"
                        data-target="#all_active">@lang('Approved')</button>
                    
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
                        <th scope="col">@lang('Total Token')</th>
                        <th scope="col">@lang('Token Name')</th>
                        <th scope="col">@lang('User')</th>
                        <th scope="col">@lang('Status')</th>
                        <th scope="col">@lang('Transaction')</th>
                        <th scope="col">@lang('Created at')</th>
                        @if(adminAccessRoute(config('role.manage_plan.access.edit')))
                            <th scope="col">@lang('Action')</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($userTokens as $key => $invest)
                    <tr>
                        @if(adminAccessRoute(config('role.manage_plan.access.edit')))
                        <td class="text-center">
                            <?php if($invest->status != 'approved'): ?>
                                <input type="checkbox" id="chk-{{ $invest->id }}" class="form-check-input row-tic tic-check"
                                    name="check" value="{{$invest->id}}" data-id="{{ $invest->id }}">
                                <label for="chk-{{ $invest->id }}"></label>
                            <?php endif; ?>
                        </td>
                        @endif

                        <td data-label="@lang('Total Token')">
                            {{$invest->number_token}} {{!empty($invest->token) ? $invest->token->token_symbol : ''}}
                        </td>
                        <td data-label="@lang('Token Name')">
                            {{!empty($invest->token) ? $invest->token->name : ''}}
                        </td>
                        <td data-label="@lang('User')">
                            {{!empty($invest->user) ? $invest->user->firstname . ' ' .  $invest->user->lastname : ''}}
                        </td>

                        <td data-label="@lang('Status')">
                            <span class="badge {{$invest->status == 'approved' ? 'badge-success' : 'badge-danger'}}">{{$invest->status}}</span>
                        </td>
                        <td>
                            <?php if($invest->hash):  ?>
                            <a href="{{createHashLink($invest->hash, 1)}}" target="_blank">{{trans('View
                                transaction')}}</a>
                            <?php endif; ?>
                        </td>
                        
                        <td>
                            {{$invest->created_at}}
                        </td>
                     

                        @if(adminAccessRoute(config('role.manage_plan.access.edit')))
                        <td data-label="@lang('Action')">
                            <?php if(!$invest->hash):  ?>
                                <div class="dropdown show">
                                    <a class="dropdown-toggle p-3" href="#" id="dropdownMenuLink" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a data-id="{{$invest->id}}" class="dropdown-item approved-withdraw" href="javascript:void(0)" data-url="{{ route('admin.approveWithdraw') }}">
                                            <i class="fa fa-wrench text-warning pr-2" aria-hidden="true"></i> @lang('Approved')
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
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




<div class="modal fade" id="all_active" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-primary">
                <h5 class="modal-title">@lang('Withdraw Confirmation')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <p>@lang("Are you really want to do that")</p>
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
                if (strIds.length > 0) { 
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                        url: "{{ route('admin.approveWithdraw') }}",
                        data: {strIds: strIds, 'type' : 'multi'},
                        datatType: 'json',
                        type: "post",
                        success: function (data) {
                            //location.reload();
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
                                
                            }
    
                        },
                    });
                }
                else {
                    Swal.fire(
                        'Error',
                        'Please select at least one item',
                        'error'
                    );
                }

                
            });

            

            $('.approved-withdraw').on('click', function () {
                let id = $(this).attr('data-id');
                let url = $(this).attr('data-url');
                Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, approve it!'
                }).then((result) => {
                  if (result.isConfirmed) {
                    // call ajax
                    $.ajax({
                        type: 'post',
                        url: "{{ route('admin.approveWithdraw') }}",
                        data: {
                            'id' : id,
                            'type' : 'single',
                            '_token' : $('meta[name="csrf-token"]').attr('content'),
                        
                        },
                        beforeSend: function(){
                           $(".approved-withdraw").attr("disabled","disabled");
                        },
                        complete: function(){
                            
                        },
                        success:function(data){
                            if(data.success == 1) {
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
                                
                            }
                        },
                        error: function(xhr, status, error) {
                            //var err = eval("(" + xhr.responseText + ")");
                            Swal.fire(
                                'Error',
                                xhr.responseText,
                                'error'
                            );
                        }
                        
                    });
                   
                  }
                })
            });


        });

</script>
@endpush