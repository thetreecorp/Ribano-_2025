@extends('admin.layouts.app')
@section('title')
    @lang('Create a user')
@endsection
@section('content')

    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <div class="media mb-4 justify-content-end">
                <a href="{{route('admin.xeedwalletList')}}" class="btn btn-sm  btn-primary mr-2">
                    <span><i class="fas fa-arrow-left"></i> @lang('Back')</span>
                </a>
            </div>

            <form id="create-xeedwallet-user" method="post" action="{{route('admin.submitXeedwalletUser')}}" class="form-row justify-content-center">
                @csrf
                <div class="col-md-8">

                <div class="row">
                    <div class=" col-md-6">
                        <div class="form-group">
                            <label>@lang('Email')</label>
                            <input required type="text" name="email" value="{{$randomEmail}}" placeholder="{{translate('Email')}}" class="form-control" >
                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class=" col-md-6">
                        <div class="form-group">
                            <label>@lang('Password')</label>
                            <input required type="text" name="password" value="{{$randomPassword}}" placeholder="@lang('Password')" class="form-control">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class=" col-md-6">
                        <div class="form-group">
                            <label>@lang('First Name')</label>
                            <input required type="text" name="first_name" value="{{$firstName}}" placeholder="{{translate('First name')}}" class="form-control" >
                            @error('first_name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class=" col-md-6">
                        <div class="form-group">
                            <label>@lang('Last Name')</label>
                            <input required type="text" name="last_name" value="{{$lastName}}" placeholder="{{translate('Last name')}}" class="form-control">
                            @error('last_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                </div>
                
                <div class="row">
                    <div class=" col-md-6">
                        <button id="create-xeedwallet-button" type="submit" class="btn waves-effect waves-light btn-rounded btn-primary btn-block mt-3"><span><i
                            class="fas fa-save pr-2"></i> @lang('Submit')</span></button>
                    </div>
                </div>

                

                </div>
            </form>
        </div>
    </div>
@endsection


@push('js')
    <script>
        "use strict";
        

        

       

        

       


        

    </script>

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
@endpush
