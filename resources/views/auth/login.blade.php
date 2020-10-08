@extends('layouts.app')

@section('content')
<section class="sect">
    <div class="row">
        <div class="col-md-5 back">
            <img src="{{ asset('image/loginimg.svg') }}"  class="loginimg" alt="logo">
            <img src="{{ asset('image/loginlog.png') }}"  class="loginlogo" alt="logo">
            <a href="/" class="logintitle" style="color:white;">GS.RADEEL</a>
        </div>
        <div class="col-md-4 offset-2">
            <div class="card carditm" style="top: 25%;">
                <div class="card-header carhed"><h3>Admin {{ __('Login') }}</h3></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <div class="col-md-10 offset-1 ">
                                <input id="email" type="email" class="form-control jst @error('email') is-invalid @enderror" 
                                name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-10 offset-1 mt-2">
                                <input id="password" type="password"  placeholder="Mot de passe" class="form-control jst @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-1">
                                <button type="submit" class="btn btn-primary log">
                                    {{ __('Login') }}
                                </button>

                               <!-- @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif-->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
