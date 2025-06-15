@extends('layouts.pdf')
@section('after_styles')
    <!-- about-us page -->
    <link href="{{ asset('public/flip-pdf/css/magalone.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel='stylesheet' href="{{ asset('public/flip-pdf/css/fonts.min.css') }}">
    <link rel='stylesheet' href="{{ asset('public/flip-pdf/css/flip-pdf.css') }}">
    
    <style>
        #reader-container {
            margin: 0 auto
        }
        body {
            overflow-y:hidden
        }
    </style>
@endsection

@section('content')
   
    <div id="reader-container" style="width: 100%;" data-path="/public/catalogues/documents/{{$folder}}" data-show-fullscreen="true"></div>
    
    {{-- <div class="flip-bottom">
        <p>{{translate("To download pdf version of catalogues in any language please")}} <a target="_blank" href="{{env('PDF_FOLDER') ?? '#'}}">click here</a></p>
    </div>
     --}}
@endsection

@push('scripts')

    <script src="{{ url(asset('public/flip-pdf/js/pdfjs/pdf.min.js')) }}"></script>
    
    @if (isset($_GET['type']) && $_GET['type'] == 'rtl')
        <script src="{{ url(asset('public/flip-pdf/js/magalone-rtl.js')) }}"></script>
    @else
        <script src="{{ url(asset('public/flip-pdf/js/magalone.js')) }}"></script>
    @endif
    
    

@endpush
