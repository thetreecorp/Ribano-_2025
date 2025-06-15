@extends($theme.'layouts.app')
@push('style')
    @livewireStyles
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
    
@endpush
@section('title', translate($title))

@section('content')
    <div class="card-body">
        <livewire:edit-project :slug="$slug" />
        
     </div>
@endsection


