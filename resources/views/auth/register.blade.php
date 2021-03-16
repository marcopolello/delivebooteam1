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

                            <div class="form-group row mb-0">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-8">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-8">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-8">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-8">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                        </div>

                        <div class="card-body-bottom">

                          <div class="form-group row mb-0">
                              <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                              <div class="col-md-8">
                                <input  class="form-control" type="text" name="address" value="{{ old('address') }}"minlength='5' maxlength="255" required>
                              </div>
                          </div>

                          <div class="form-group row mb-0">
                              <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('P. IVA') }}</label>

                              <div class="col-md-8">
                                <input class="form-control" type="text" name="piva" value="{{ old('piva') }}" minlength="11" maxlength="11" required>
                              </div>
                          </div>

                          <div class="form-group row mb-0">
                              <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Phone') }}</label>

                              <div class="col-md-8">
                                <input class="form-control" type="text" name="phone" value="{{ old('phone') }}" minlength="6" maxlength="30" required>
                              </div>
                          </div>

                          <div class="form-group row mb-0">
                              <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Delivery Cost (euro)') }}</label>

                              <div class="col-md-8">
                                <input class="form-control" type="number" name="delivery_cost_euro" value="{{ old('delivery_cost_euro') }}" min="0" max="9999" required>
                              </div>
                          </div>

                          <div class="form-group row mb-0">
                              <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Delivery Cost (cents)') }}</label>

                              <div class="col-md-8">
                                <input class="form-control" type="number" name="delivery_cost_cent" value="{{ old('delivery_cost_cent') }}" min="0" max="99" required>
                              </div>
                          </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
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
