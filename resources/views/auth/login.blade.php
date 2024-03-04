@extends('layouts.loginpage')

@section('content')
<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper">
                    <a href="{{ url('/') }}">
					<div class="brand mb-5 margin-auto">
                        <i class="bi bi-p-square-fill sonijaicon"></i>
					</div>
                    </a>
					<div class="card fat">
						<div class="card-body">
							<h4 class="card-title">{{ __('Login') }}</h4>
							<form method="POST" action="{{ route('login') }}">
                                @csrf
								<div class="form-group mb-4">
									<label for="email">{{ __('E-mail address') }}</label>
									<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
								</div>

								<div class="form-group mb-3">
									<label for="password">{{ __('Password') }}</label>
									<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

								<div class="row mb-3">
                                <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>

								<div class="form-group m-0">
									<button type="submit" class="btn btn-primary btn-block w-100">
										Login
									</button>
								</div>
								<div class="mt-4 text-center">
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link text-decoration-none" href="{{ route('password.request') }}">
                                            <span class="text-secondary">{{ __('Forgot Your Password?') }}</span>{{ __(' Click here!') }}
                                        </a>
                                    @endif
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
@endsection
