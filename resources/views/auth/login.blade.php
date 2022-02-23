@extends('layouts/fullLayoutMaster')

@section('title', 'Login Page')

@section('page-style')
        {{-- Page Css files --}}
        <link rel="stylesheet" href="{{ asset(mix('css/pages/authentication.css')) }}">
@endsection
@section('content')
<section class="row flexbox-container">
  <div class="col-lg-4 col-10 justify-content-center">
      <div class="card bg-authentication rounded-0">
          <div class="row m-0">
              <div class="col-12 text-center p-2">
                  <h1 class="text-bold-600">Webix Aps</h1>
              </div>
              <div class="col-12 p-0">
                  <div class="card rounded-0 mb-0 p-2">
                      <p class="px-2 text-center">Sign in to start your session</p>
                      <div class="card-content">
                        <div class="card-body pt-1">
                          @isset($url)
                          <form method="POST" action='{{ url("/") }}' >
                          @else
                          <form method="POST" action="{{ route('login') }}">
                          @endisset
                            @csrf
                            <fieldset class="form-label-group form-group position-relative has-icon-left">
                              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="email"
                                autofocus>
                              <div class="form-control-position">
                                <i class="feather icon-user"></i>
                              </div>
                              <label for="email">E-Mail Address</label>
                              @error('email')
                              <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </fieldset>

                            <fieldset class="form-label-group position-relative has-icon-left">
                              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                name="password" placeholder="Password" required autocomplete="current-password">
                              <div class="form-control-position">
                                <i class="feather icon-lock"></i>
                              </div>
                              <label for="password">Password</label>
                              @error('password')
                              <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </fieldset>
                            <div class="form-group d-flex justify-content-between align-items-center">
                              <div class="text-left">
                                <fieldset class="checkbox">
                                  <div class="vs-checkbox-con vs-checkbox-primary">
                                    <input type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                                    <span class="vs-checkbox">
                                      <span class="vs-checkbox--check">
                                        <i class="vs-icon feather icon-check"></i>
                                      </span>
                                    </span>
                                    <span class="">Remember me</span>
                                  </div>
                                </fieldset>
                              </div>
                                <div class="text-right">
                                <button type="submit" class="btn btn-primary float-right btn-inline">Login</button>
                                </div>
                            </div>
                              @if (Route::has('password.request'))
                                  <div class="text-left"><a class="card-link" href="{{ route('password.request') }}">
                                     I forgot my password
                                  </a></div>
                              @endif
                          </form>
                        </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>
@endsection
