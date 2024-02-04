<!-- resources/views/usersettings/settings.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow rounded-4">
                <div class="card-body px-4">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-4 asbr rounded-4 text-dark p-5 position-relative">
                            <h1>{{ __('Account') }}</h1>
                            <h5 class="lh-1">{{ __('Manage your account data and security.') }}</h5>
                            <div class="position-absolute bottom-0 start-50 translate-middle">
                                <h6><span class="fw-bold">{{ Auth::user()->name }}</span> {{ __('`s account') }}</h6>
                                <h6 class="text-center text-secondary"><i class="bi bi-shield-shaded"></i> {{ __('secured by Sonija Dev Cloud') }}</h6>
                            </div>
                        </div>
                    <div class="col-md-8 px-4">
                    <form method="POST" action="{{ route('settings') }}">
                        @csrf
                        <div class="row mb-3">
                            <h2 class="fw-bold">{{ __('Profile details') }}</h3>
                            <hr>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-5">
                                <label for="phone" class="form-label fw-bold">{{ __('Phone') }}</label><br>
                                <small class="text-muted">{{ __('Enter your landline or cell phone number to make it easier to contact you. Enter your phone number without the country prefix and without spcial characters (e.g., 123444838)') }}</small>
                            </div>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}" placeholder="{{ __('e.g., 123444838') }}">
                            </div>
                        </div>
                        <div class="row mb-3 mt-5">
                            <div class="col-sm-5">
                                <label for="signature" class="form-label fw-bold">{{ __('Signature') }}</label><br>
                                <small class="text-muted">{{ __('Enter your signature, which will be placed next to each comment, created submission and task in the system.') }}</small>
                            </div>
                            <div class="col-sm-7">
                                <textarea class="form-control" id="signature" rows="5" name="signature" placeholder="{{ __('Start typing your signature here ...') }}">{{ $user->signature }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3 mt-5">
                            <div class="col-sm-5">
                                <label for="position" class="form-label fw-bold">{{ __('Job title') }}</label><br>
                                <small class="text-muted">{{ __('Enter here your position where you are employed. Your job title will be added under your signature in comments, etc.') }}</small>
                            </div>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="position" name="position" value="{{ $user->position }}" placeholder="{{ __('e.g. Senior Python Developer') }}">
                            </div>
                        </div>
                        <div class="row mb-3 mt-5">
                            <h3 class="fw-bold">{{ __('Security') }}</h3>
                            <hr>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-5">
                                <label class="form-label fw-bold"><i class="bi bi-shield-lock"></i> {{ __('Change Password') }}</label><br>
                                <small class="text-muted">{{ __('If you want to change your password, click the button next to it to open the corresponding form. We recommend changing your password regularly (at least every 45 days) to maintain security standards.') }}</small>
                            </div>
                            <div class="col-sm-7">
                                <!-- Przycisk, który uruchamia okno modalne -->
                                <button type="button" class="btn btn-warning float-end" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                    <i class="bi bi-key"></i> {{ __('Change your password now') }}
                                </button>
                            </div>
                        </div>
                        <!-- <div class="row mb-3 mt-5">
                            <div class="col-sm-4">
                                <label class="form-label fw-bold"><i class="bi bi-shield-lock"></i> {{ __('Follow-up question') }}</label><br>
                                <small class="text-muted">{{ __('The control question serves as an aid to password recovery. To protect your information, when you reset your password, you will be asked to provide the answer to a check question of your choice that you set.') }}</small>
                            </div>
                           <div class="col-sm-8">
                                <button type="button" class="btn btn-dark float-end" data-bs-toggle="modal" data-bs-target="#followupQuestionModal">
                                    <i class="bi bi-question-lg"></i> {{ __('Set up follow-up question') }}
                                </button>
                            </div>
                        </div>-->
                        <div class="row mb-3 mt-5">
                            <div class="col-sm-5">
                                <label class="form-label fw-bold"><i class="bi bi-shield-lock"></i> {{ __('Two Factor Authentication') }}</label><br>
                                <small class="text-muted">{{ __('Click the button next to it to enable or disable two-factor authentication. For example with Google Authenticator application. You can download the app from the') }}  <i class="bi bi-google-play"></i> Play store {{ __('or') }}  <br><i class="bi bi-apple"></i> App Store</small>
                            </div>
                            <div class="col-sm-7">
                                @if($user->google2fa_enabled)
                                    <!-- Przycisk wyłączający 2FA -->
                                    <button type="button" class="btn btn-danger float-end" data-bs-toggle="modal" data-bs-target="#disableTwoFactorModal">
                                    <i class="bi bi-power"></i> {{ __('Disable 2FA') }}
                                    </button>
                                @else
                                    <!-- Przycisk włączający 2FA -->
                                    <button type="button" class="btn btn-secondary float-end" data-bs-toggle="modal" data-bs-target="#enableTwoFactorModal">
                                    <i class="bi bi-google"></i> {{ __('Manage 2FA in your account') }}
                                    </button>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-1 mt-4">
                            <hr>
                        </div>
                        <button type="submit" class="btn btn-success float-end"><i class="bi bi-check2"></i> Save settings</button>
                    </form>
                    </div>
                    </div>
                    <!-- END OF COLUMN -->
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal Zmiany hasła -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">{{ __('Password change form') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('user.change.password') }}">
                @csrf
                <div class="modal-body">
                        <div class="text-muted mb-3">{{ __('Below is the password change form. Remember that you must enter a valid value in the current password field, and the two new passwords must match. We recommend changing your password at least every 45 days to ensure the security of your account.') }}</div>
                    <div class="mb-3">
                        <label for="current_password" class="col-form-label">{{ __('Current password') }}</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="col-form-label">{{ __('New password') }}</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                        <small id="passwordHelpBlock" class="form-text text-muted mt-4">
                            <small id="pwCapitalLetter" class="form-text text-muted" data-text="{{ __('Minimum 1 Capital Letter') }}">• {{ __('Minimum 1 Capital Letter') }}</small><br>
                            <small id="pwOneNumber" class="form-text text-muted" data-text="{{ __('Minimum One number') }}">• {{ __('Minimum One number') }}</small><br>
                            <small id="pwSpecialChar" class="form-text text-muted" data-text="{{ __('Minimum 1 special character') }}">• {{ __('Minimum 1 special character') }}</small><br>
                            <small id="pwEightchar" class="form-text text-muted" data-text="{{ __('Minimum 8 characters length') }}">• {{ __('Minimum 8 characters length') }}</small><br>
                        </small>
                    </div>
                    <div class="mb-3">
                        <label for="new_password_confirmation" class="col-form-label">{{ __('Repeat new password') }}</label>
                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                        <small><small id="pwConfirmok" class="form-text text-muted" data-text="{{ __('The new password and confirmation must be the same') }}">• {{ __('The new password and confirmation must be the same') }}</small></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-danger">{{ __('Change your password!') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal dla weryfikacji dwuetapowej -->
<div class="modal fade" id="enableTwoFactorModal" tabindex="-1" aria-labelledby="enableTwoFactorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="enableTwoFactorModalLabel">{{ __('Two Factor Authentication') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('settings.verify-2fa') }}">
                @csrf
                <div class="modal-body">
                    <p class="text-success fw-bold ">{{ __('To enable 2FA, please go through the following 2 simple steps.') }}</p>
                <small class="fw-bold">{{ __('step 1.') }}</small> {{ __('Scan the code below in the Google Authenticator app ') }}
                        @if(session('QRImage'))
                            <div class="text-center mb-3">
                                <img src="{!! html_entity_decode(session('QRImage')) !!}">
                            </div>
                        @endif
                    <div class="mb-3">
                        <label for="verify_code" class="col-form-label"><small class="fw-bold">{{ __('step 2.') }}</small> {{ __('Enter the code from Google Authenticator app') }}</label>
                        <input type="text" class="form-control" id="verify_code" name="verify_code" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Enable 2FA') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal dla wyłączania weryfikacji dwuetapowej -->
<div class="modal fade" id="disableTwoFactorModal" tabindex="-1" aria-labelledby="disableTwoFactorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="disableTwoFactorModalLabel">{{ __('Disable Two Factor Authentication') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>{{ __('Are you sure you want to disable 2FA?') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <form method="POST" action="{{ route('settings.disable-2fa') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">{{ __('Yes') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal dla pytania kontrolnego -->
<!--<div class="modal fade" id="followupQuestionModal" tabindex="-1" aria-labelledby="followupQuestionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="followupQuestionModalLabel">{{ __('Set up your follow-up question') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>{{ __('Choose a control question and enter your secret answer. Remember it and don`t share it with anyone.') }}</p>
                <form method="POST" action="">
                    @csrf
                    <div class="mb-3">
                    <select class="form-select" name="followupquestion" aria-label="Follow-up Questions">
                        <option value="What is the name of the street you grew up on">{{ __('What is the name of the street you grew up on?') }}</option>
                        <option value="What is the name of your first pet">{{ __('What is the name of your first pet?') }}</option>
                        <option value="What was the make of your first car">{{ __('What was the make of your first car?') }}</option>
                        <option value="What is your favorite childhood dish">{{ __('What is your favorite childhood dish?') }}</option>
                        <option value="What is your favorite book from childhood">{{ __('What is your favorite book from childhood?') }}</option>
                        <option value="In which city were you born">{{ __('In which city were you born?') }}</option>
                    </select>
                    </div>
                    <div class="mb-3">
                        <label for="followupanswer" class="col-form-label"><small class="fw-bold">{{ __('Enter your answer') }}</label>
                        <input type="text" class="form-control" id="followupanswer" name="followupanswer" required>
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-success">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>-->



@endsection
