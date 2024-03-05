@extends('layouts.loginpage')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
                    <a href="{{ url('/') }}">
					<div class="brand mb-5 margin-auto">
                        <i class="bi bi-p-square-fill sonijaicon"></i>
					</div>
                    </a>
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-header bg-dark text-light"><i class="bi bi-google"></i> {{ __('2FA code verification stage during login') }}</div>
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                    </div>
                    @endif
                    <form method="POST" action="{{ route('2fa.verify') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="verify_code" class="col-form-label">{{ __('Enter 2FA code from your authentication app') }}</label>
                            <!-- <input type="text" class="form-control" name="2fa_code" placeholder="" required autofocus> -->
                            <div class="d-flex justify-content-center gap-2 mt-3">
                            @for ($i = 0; $i < 6; $i++)
                            <input type="text" class="form-control text-center code-input" placeholder="-" style="height:60px; font-size: 1.5rem;" id="part{{ $i + 1 }}" maxlength="1" {{ $i == 0 ? 'autofocus' : '' }}>
                            @endfor
                            <input type="hidden" name="2fa_code" id="full_code" />
                        </div>
                        </div>
                        <div class="modal-footer text-center">
                            <!-- <button type="submit" class="btn btn-primary">{{ __('Verify 2FA') }}</button> -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
