@extends('layouts.app')

@section('content')
<div class="container-register">
    
            <div class="card">

                @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
                @endif

                {{-- <h2 class="card-header">{{ __('Register') }}</h2> --}}

                <div class="title">
                    <h1>Diventa subito partner di Deliveroo</h1>
                    <p>Aumenta le tue vendite fino al 30% grazie alle consegne a domicilio</p>
                </div>


                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="card-body-top">

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
    
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
    
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
    
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
    
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
    
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
    
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
    
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                        </div>

                        <div class="card-body-bottom">
                          <label for="address">Address</label>
                          <input type="text" name="address" value="{{ old('address') }}" maxlength="255" required>
                          {{-- <input type="text" name="address" value="{{ old('address') }}"> --}}

                          <label for="piva">PIVA</label>
                          <input type="text" name="piva" value="{{ old('piva') }}" minlength="11" maxlength="11" required>
                          {{-- <input type="text" name="piva" value="{{ old('piva') }}"> --}}

                          <label for="phone">Phone</label>
                          <input type="text" name="phone" value="{{ old('phone') }}" minlength="6" maxlength="30" required>
                          {{-- <input type="text" name="phone" value="{{ old('phone') }}"> --}}

                          <label for="delivery_cost_euro">Delivery cost (prima della virgola)</label>
                          <input type="number" name="delivery_cost_euro" value="{{ old('delivery_cost_euro') }}" min="0" max="9999" required>
                          {{-- <input type="number" name="delivery_cost_euro" value="{{ old('delivery_cost_euro') }}"> --}}

                          <label for="delivery_cost_cent">Delivery_cost (centesimi)</label>
                          <input type="number" name="delivery_cost_cent" value="{{ old('delivery_cost_cent') }}" min="0" max="99" required>
                          {{-- <input type="number" name="delivery_cost_cent" value="{{ old('delivery_cost_cent') }}"> --}}


                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

</div>
@endsection
