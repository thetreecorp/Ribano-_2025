@php
    $get_currency = (Session::get('currency')) ? (Session::get('currency')) : 'USD';
    $get_country = (Session::get('country')) ? (Session::get('country')) : 'AE';
    $lang = Session::get('trans') ?? 'US';
@endphp

@if ($languages)
    <div class="select-menu">
        <div class="language-select footer-select">
            <select class="form-control select2">
                @foreach ($languages as $key => $l)
                <option value="{{$l->short_name}}" @if ($lang==$l->short_name) selected @endif> {{$l->name}}</option>
        
                @endforeach
            </select>
        </div>
        @if(config('country'))
            <div class="country-select footer-select">
                <select class="form-control select2">
                    @foreach(config('country') as $value)
                    <option value="{{$value['code']}}" @if ($value['code']==$get_country) selected @endif> {{$value['name']}}
                    </option>
                    @endforeach
                </select>
            </div>
        @endif
    </div>
@endif


