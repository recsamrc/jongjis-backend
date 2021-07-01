@extends(backpack_view('layouts.plain'))

@push('after_styles')
<style>
    @media (max-width: 767px) {
        .btn-register {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-lg-10 col-xl-8">
        <h3 class="text-center mb-4">{{ __('register.title') }}</h3>
        <div class="card">
            <div class="card-body">
                <form class="px-md-3 p-t-10 row" role="form" method="POST" action="{{ route('backpack.auth.register') }}">
                    {!! csrf_field() !!}
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="username">{{ __('register.user.username') }}</label>
                            
                            <div>
                                <input type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" id="username" value="{{ old('username') }}">
                                
                                @if ($errors->has('username'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="{{ backpack_authentication_column() }}">{{ config('backpack.base.authentication_column_name') }}</label>

                            <div>
                                <input type="{{ backpack_authentication_column()=='email'?'email':'text'}}" class="form-control{{ $errors->has(backpack_authentication_column()) ? ' is-invalid' : '' }}" name="{{ backpack_authentication_column() }}" id="{{ backpack_authentication_column() }}" value="{{ old(backpack_authentication_column()) }}">

                                @if ($errors->has(backpack_authentication_column()))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first(backpack_authentication_column()) }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="password">{{ trans('backpack::base.password') }}</label>

                            <div>
                                <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" id="password">

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="password_confirmation">{{ trans('backpack::base.confirm_password') }}</label>

                            <div>
                                <input type="password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" id="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="fullname">{{ __('register.user.fullname') }}</label>
    
                            <div>
                                <input type="text" class="form-control{{ $errors->has('fullname') ? ' is-invalid' : '' }}" name="fullname" id="fullname" value="{{ old('fullname') }}">
    
                                @if ($errors->has('fullname'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('fullname') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
    
                        <div class="form-group">
                            <label class="control-label" for="contact">{{ __('register.user.contact') }}</label>
    
                            <div>
                                <input type="text" class="form-control{{ $errors->has('contact') ? ' is-invalid' : '' }}" name="contact" id="contact" value="{{ old('contact') }}">
    
                                @if ($errors->has('contact'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('contact') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>



                    <div class="form-group col-12">
                        <div>
                            <button type="submit" class="btn btn-primary btn-register px-md-5">
                                {{ __('register.btn_title') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="text-center mb-5"><a href="{{ route('backpack.auth.login') }}">{{ trans('backpack::base.login') }}</a></div>
    </div>
</div>
@endsection