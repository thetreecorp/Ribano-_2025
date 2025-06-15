@extends('admin.layouts.app')
@section('title')
    @lang('Category')
@endsection

@section('content')

    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">

        <div class="card-body">

            <div class="media mb-4 justify-content-between">

                @if(adminAccessRoute(config('role.manage_plan.access.add')))
                    <a href="javascript:void(0)" class="btn btn-sm s-a-category-form  btn-primary mr-2">
                        <span><i class="fas fa-plus"></i> @lang('Add New')</span>
                    </a>
                @endif

               
            </div>

            
            <div class="table-responsive">
                <table class="categories-show-table table table-hover table-striped table-bordered" id="zero_config">
                    <thead class="thead-dark">
                    <tr>
                       
                        <th scope="col">@lang('Title')</th>
                        @if(adminAccessRoute(config('role.manage_plan.access.edit')))
                            <th scope="col">@lang('Action')</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($categories as $item)
                        <tr>
                           

                            <td data-label="@lang('name')">
                                @lang($item->name)
                            </td>
                           

                            @if(adminAccessRoute(config('role.manage_plan.access.edit')))
                            <td data-label="@lang('Action')">
                                <div class="dropdown show">
                                    <a class="dropdown-toggle p-3" href="#"  data-toggle="dropdown"
                                       aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a data-id="{{$item->id}}" class="dropdown-item edit-category-btn" href="javascript:void(0)">
                                            <i class="fa fa-edit text-warning pr-2"
                                               aria-hidden="true"></i> @lang('Edit')
                                        </a>
                                        <a data-id="{{$item->id}}" class="dropdown-item delete-category-btn" href="javascript:void(0)" >
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




    <div class="modal fade" id="add_new_category" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title">@lang('Add new category')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                </div>
                <form action="" id="fsm-category" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class=" col-md-12">
                            <div class="form-group">
                                <label>{{trans("Category Name")}}</label>
                                <input required type="text" name="category_name" value="" placeholder="Category Name" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:void(0)" class="btn btn-light" data-dismiss="modal"><span>@lang('No')</span></a>
                        <button id="submit-category-btn" type="submit" href="" class="btn btn-primary active-yes"><span>@lang('Yes')</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="edit_category_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title">@lang('Edit Category')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                </div>
                <form action="" id="fsm-edit-category" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class=" col-md-12">
                            <div class="form-group">
                                <label>{{trans("Category Name")}}</label>
                                <input required type="text" name="category_edit_name" value="" placeholder="Category Name" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:void(0)" class="btn btn-light" data-dismiss="modal"><span>@lang('No')</span></a>
                        <button id="submit-edit-category-btn" type="submit" href="" class="btn btn-primary active-yes"><span>@lang('Yes')</span></button>
                    </div>
                </form>
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
        var id;
        $(document).ready(function () {
            $('.s-a-category-form').on('click', function () { 
                $("#add_new_category").modal('show');
                $('input[name="category_name"]').val('');
            })
            $( "#fsm-category" ).submit(function(e) {
                e.preventDefault(); 
                $.ajax({
                    type: 'post',
                    url: "{{ route('admin.createCategory') }}",
                    data: {
                        'name' : $('input[name="category_name"]').val(),
                        '_token' : $('meta[name="csrf-token"]').attr('content'),
                    
                    },
                    beforeSend: function(){
                        showToast('Data sent', 500, 'success');
                        $("#submit-category-btn").attr('disabled', true)
                    },
                    complete: function(){
                        
                    },
                    success:function(data){
                        $("#submit-category-btn").attr('disabled', false);
                        if(data.success == 1)
                            showToast(data.message, 1000, 'success');
                        else
                            showToast(data.message, 1000, 'warning');
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        $("#submit-category-btn").attr('disabled', false);
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
            
            // edit function
            $('body').on('click', '.edit-category-btn',function () {
                id = $(this).attr('data-id');
                $.ajax({
                    type: 'post',
                    url: "{{ route('admin.editCategory') }}",
                    data: {
                        'id' : id,
                        'type': 'get-cat',
                        '_token' : $('meta[name="csrf-token"]').attr('content'),
                    
                    },
                    beforeSend: function(){
                      
                    },
                    complete: function(){
                        
                    },
                    success:function(data){
                        if(data.success == 1) {
                            $("#edit_category_modal").modal('show');
                            $('input[name="category_edit_name"]').val(data.data.name);
                        }
                        else {
                            
                            showToast(data.message, 1000, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        Swal.fire(
                            'Error',
                            err,
                            'error'
                        );
                    }
                    
                });
                
            });
            
            $( "#fsm-edit-category" ).submit(function(e) {
                e.preventDefault(); 
               
                $.ajax({
                    type: 'post',
                    url: "{{ route('admin.editCategory') }}",
                    data: {
                        'name' : $('input[name="category_edit_name"]').val(),
                        '_token' : $('meta[name="csrf-token"]').attr('content'),
                        'type': 'edit',
                        'id' : id,
                    
                    },
                    beforeSend: function(){
                        showToast('Data sent', 500, 'success');
                       $("#submit-edit-category-btn").attr('disabled', true)
                    },
                    complete: function(){
                        
                    },
                    success:function(data){
                        $("#submit-edit-category-btn").attr('disabled', false);
                        if(data.success == 1)
                            showToast(data.message, 1000, 'success');
                        else
                            showToast(data.message, 1000, 'warning');
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        $("#submit-edit-category-btn").attr('disabled', false);
                        showToast(data.message, 1000, 'error');
                    }
                    
                });
            })
            
            $('.delete-category-btn').on('click', function () {
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
                    url: "{{ route('admin.deleteCategory') }}",
                    data: {
                        'id' : id,
                        '_token' : $('meta[name="csrf-token"]').attr('content'),
                    
                    },
                    beforeSend: function(){
                       $(".delete-category-btn").attr("disabled","disabled");
                    },
                    complete: function(){
                        
                    },
                    success:function(data){
                        if(data.success == 1)
                            showToast(data.message, 1000, 'success');
                        else
                            showToast(data.message, 1000, 'warning');
                        location.reload();
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


        });

    </script>
@endpush
