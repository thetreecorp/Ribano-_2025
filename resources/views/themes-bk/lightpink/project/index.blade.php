@extends($theme.'layouts.user')
@section('title',trans('Projects'))

@push('css-lib')
    <link rel="stylesheet" href="{{ asset($themeTrue.'css/bootstrap-datepicker.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/assets/css/sweetalert.min.css') }}" />
@endpush

@section('content')
    <div class="container-fluid">
        <div class="main row">
            <div class="col-12">
                <div
                    class="d-flex justify-content-between align-items-center mb-3"
                >
                    <h3 class="mb-0">@lang('Projects')</h3>
                    <a target="_blank" href="{{ route('user.createProject') }}" class="btn btn-success">@lang('Add Project')</a>
                </div>

                <div class="search-bar my-search-bar p-0">
                    <form action="{{ route('user.searchProject') }}" method="get" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <div class="input-box">
                                    <input
                                        type="text"
                                        name="name"
                                        value="{{@request()->name}}"
                                        class="form-control"
                                        placeholder="@lang('Type Here')"
                                    />
                                </div>
                            </div>

                            


                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <button class="btn-custom" type="submit">@lang('Search')</button>
                            </div>
                            
                            
                            
                        </div>
                    </form>
                </div>

                <!-- table -->
                <div class="table-parent table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">@lang('Title')</th>
                                <th scope="col">@lang('Located')</th>
                                <th scope="col">@lang('Country')</th>
                                <th scope="col">@lang('Mobile number')</th>
                                <th scope="col">@lang('Created at')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($projects as $data)
                                <tr>
                                    <td>{{$data->title}}</td>
                                    <td>{{$data->located}}</td>
                                    <td>{{$data->country}}</td>
                                    <td>
                                        {{$data->mobile_number}}
                                    </td>
                                    <td>{{ dateTime($data->created_at, 'd M Y h:i A') }}</td>
                                    <td>
                                        <a target="_blank" href="{{ route('user.editProject', $data->slug) }}" class="btn btn-success">@lang('View')</a>
                                        <a data-id="{{$data->id}}"  href="javascript:void(0)" class="btn btn-danger delete-project-btn">@lang('Delete')</a>
                                        <a target="_blank" href="{{ route('user.editProject', $data->slug) }}" class="btn btn-warning">@lang('Edit')</a>
                                    </td>
                                </tr>

                            @empty
                                <tr class="text-center">
                                    <td colspan="100%">{{__('No Data Found!')}}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $projects->appends($_GET)->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset($themeTrue.'js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('public/assets/js/sweetalert2@11.js') }}"></script>
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
                        url: "{{ route('user.deleteProject') }}",
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
@endpush

