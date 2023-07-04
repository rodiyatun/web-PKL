@section('styles')
    <style>
        .alert{
            padding: 0.7rem 1.5rem !important;
        }

        .flaticon-bell{
            font-size:2.2rem !important;
        }
    </style>
@endsection


@if (session()->has('success'))
    <!--begin::Notice-->
    <div class="alert alert-custom alert-success alert-shadow gutter-b" role="alert" style="padding-top: 15px;padding-bottom:12px">
        <div class="alert-icon">
            <i class="flaticon-bell"></i>
        </div>
        <div class="alert-text">
            @foreach(session()->get('success') as $e)
                @if(is_array($e))
                    @foreach($e as $error)
                        {{$error}}<br>
                    @endforeach
                @else
                    {{$e}}<br>
                @endif
            @endforeach
        </div>
        <div class="alert-close">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"><i class="la la-close"></i></span>
            </button>
        </div>
    </div>
    <!--end::Notice-->
    @php
        Session::forget('success');
    @endphp
@endif


@if (session()->has('errors'))
    <!--begin::Notice-->
    <div class="alert alert-custom alert-danger alert-shadow gutter-b" role="alert" style="padding-top: 15px;padding-bottom:12px">
        <div class="alert-icon">
            <i class="flaticon-warning"></i>
        </div>
        <div class="alert-text">
            @foreach($errors->all() as $e)
                @if(is_array($e))
                    @foreach($e as $error)
                        {{$error}}<br>
                    @endforeach
                @else
                    {{$e}}<br>
                @endif
            @endforeach
        </div>
        <div class="alert-close">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"><i class="la la-close"></i></span>
            </button>
        </div>
    </div>
    <!--end::Notice-->
    @php
        Session::forget('errors');
    @endphp
@endif
