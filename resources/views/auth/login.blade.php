@extends('layouts.app')

@section('content')
<div class="container-lg">

    <div class="row d-flex justify-content-between align-items-center">

        <div class="col-md mt-5">
            <div class="title">
                <h1>Ti diamo il benvenuto!</h1>
                <p>Sfrutta i dati a disposizione per far crescere il tuo business. Monitora le vendite, controlla i tuoi progressi e attira nuovi clienti con offerte speciali.</p>
            </div>

            <div class="">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="">
                        <label for="email" class="">{{ __('E-Mail Address') }}</label>

                        <div class="">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="">
                        <label for="password" class="">{{ __('Password') }}</label>

                        <div class="">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="">
                        <div class="">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="register-button">
                        <div class="">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Login') }}
                            </button>

                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    <div class="forgot-password">
                                        {{ __('Forgot Your Password?') }}
                                    </div>
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
            
        <div class="col-md mt-5">
            <div class="">
                <div class="img-login">
                    <span></span>
                    <img src="/storage/pizza_chart.svg" alt="">
                </div>
            </div>
        </div>
              
    </div>

        

</div>
@endsection
