@extends('admin.layouts.app')
@section('title')
@lang("Translation")
@endsection
@section('content')

<div class="page-header card card-primary m-0 m-md-4 my-4 m-md-0 p-5 shadow">
    <div class="row justify-content-between">
        <div class="col-md-12">
            @if(Session::has('message'))
               
                <div class="alert alert-success" id="success-alert">
                    <button type="button" class="close" data-dismiss="alert">x</button>
                    {{ Session::get('message') }}
                </div>
            @endif
            @if(Session::has('error'))
                <div class="alert alert-danger" id="error-alert">
                    <button type="button" class="close" data-dismiss="alert">x</button>
                    {{ Session::get('message') }}
                </div>
            @endif
            <form class="form-horizontal" action="{{route("admin.importCSVFile")}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label class="col-from-label">{{trans("Excel Trasnlation File")}}</label>
                            <label class="col-from-label">{{trans("Choose .xlsx-Excel file")}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="file" id="lang_file" name="lang_file" class="form-control" required="" data-bs-original-title="" title="">
                        </div>
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-outline-info shadow" data-bs-original-title="" title="">{{trans("Import Excel")}}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>






@endsection

@push('js')
@endpush