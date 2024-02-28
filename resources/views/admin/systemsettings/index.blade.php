@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow rounded-4">
                <div class="card-body px-4">
                    @if (session('success'))
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle"></i> {{ session('success') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <i class="bi bi-bug"></i> {{ $error }}
                                @endforeach
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-4 asbr rounded-4 text-dark p-5 position-relative">
                            <h1>{{ __('System Settings') }}</h1>
                            <h5 class="lh-1">{{ __('Manage settings to customize the application') }}</h5>
                            <div class="position-absolute bottom-0 start-50 translate-middle">
                                <h6><span class="fw-bold">Sonija Simple Select</h6>
                                <h6 class="text-center text-secondary"><i class="bi bi-shield-shaded"></i> {{ __('secured by Sonija Dev Cloud') }}</h6>
                            </div>
                        </div>
                    <div class="col-md-8 px-4">
                    <form method="POST" action="{{ route('systemsettings.update') }}">
                        @csrf
                        <div class="row mb-3">
                            <h2 class="fw-bold">{{ __('Basic system settings') }}</h3>
                            <hr>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-5">
                                <label for="app_title" class="form-label fw-bold">{{ __('App title') }}</label><br>
                                <small class="text-muted">{{ __('Application title displayed in browser window after application name') }}</small>
                            </div>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="app_title" name="app_title_value" value="{{ $ss_app_title->value }}">
                                <input type="hidden" class="form-control" id="app_title_previous_value" name="app_title_previous_value" value="{{ $ss_app_title->value }}">
                                @if($ss_app_title->previous_value && $ss_app_title->previous_value !== $ss_app_title->value)
                                    <span style="font-size: 10px; color: gray;">{{ __('Previous value:') }} {{ $ss_app_title->previous_value }}</span><br>
                                @endif
                                @if($ss_app_title->updated_at != $ss_app_title->created_at)
                                    <span style="font-size: 10px; color: gray;">{{ __('Previous update:') }} {{ $ss_app_title->updated_at }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3 mt-5">
                            <div class="col-sm-5">
                                <label for="app_timezone" class="form-label fw-bold">{{ __('App timezone') }}</label><br>
                                <small class="text-muted">{{ __('Default time zone of the application, which will be taken into account when filling in the date/date and time fields in the application and database') }}</small>
                            </div>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="app_timezone" name="app_timezone_value" value="{{ $ss_app_timezone->value }}">
                                <input type="hidden" class="form-control" id="app_timezone_previous_value" name="app_timezone_previous_value" value="{{ $ss_app_timezone->value }}">
                                @if($ss_app_timezone->previous_value && $ss_app_timezone->previous_value !== $ss_app_timezone->value)
                                    <span style="font-size: 10px; color: gray;">{{ __('Previous value:') }} {{ $ss_app_timezone->previous_value }}</span><br>
                                @endif
                                @if($ss_app_timezone->updated_at != $ss_app_timezone->created_at)
                                    <span style="font-size: 10px; color: gray;">{{ __('Previous update:') }} {{ $ss_app_timezone->updated_at }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3 mt-5">
                            <div class="col-sm-5">
                                <label for="company_name" class="form-label fw-bold">{{ __('Company name') }}</label><br>
                                <small class="text-muted">{{ __('Full name of the company or partnership') }}</small>
                            </div>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="company_name" name="company_name_value" value="{{ $ss_company_name->value }}">
                                <input type="hidden" class="form-control" id="company_name_previous_value" name="company_name_previous_value" value="{{ $ss_company_name->value }}">
                                @if($ss_company_name->previous_value && $ss_company_name->previous_value !== $ss_company_name->value)
                                    <span style="font-size: 10px; color: gray;">{{ __('Previous value:') }} {{ $ss_company_name->previous_value }}</span><br>
                                @endif
                                @if($ss_company_name->updated_at != $ss_company_name->created_at)
                                    <span style="font-size: 10px; color: gray;">{{ __('Previous update:') }} {{ $ss_company_name->updated_at }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3 mt-5">
                            <div class="col-sm-5">
                                <label for="company_address" class="form-label fw-bold">{{ __('Company address') }}</label><br>
                                <small class="text-muted">{{ __('Address of the company`s headquarters') }}</small>
                            </div>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="company_address" name="company_address_value" value="{{ $ss_company_address->value }}">
                                <input type="hidden" class="form-control" id="company_address_previous_value" name="company_address_previous_value" value="{{ $ss_company_address->value }}">
                                @if($ss_company_address->previous_value && $ss_company_address->previous_value !== $ss_company_address->value)
                                    <span style="font-size: 10px; color: gray;">{{ __('Previous value:') }} {{ $ss_company_address->previous_value }}</span><br>
                                @endif
                                @if($ss_company_address->updated_at != $ss_company_address->created_at)
                                    <span style="font-size: 10px; color: gray;">{{ __('Previous update:') }} {{ $ss_company_address->updated_at }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3 mt-5">
                            <div class="col-sm-5">
                                <label for="company_phone" class="form-label fw-bold">{{ __('Company phone') }}</label><br>
                                <small class="text-muted">{{ __('The main phone number for contacting the company') }}</small>
                            </div>
                            <div class="col-sm-7">
                                <input type="tel" pattern="[0-9]{9}" class="form-control" id="company_phone" name="company_phone_value" value="{{ $ss_company_phone->value }}">
                                <input type="hidden" class="form-control" id="company_phone_previous_value" name="company_phone_previous_value" value="{{ $ss_company_phone->value }}">
                                @if($ss_company_phone->previous_value && $ss_company_phone->previous_value !== $ss_company_phone->value)
                                    <span style="font-size: 10px; color: gray;">{{ __('Previous value:') }} {{ $ss_company_phone->previous_value }}</span><br>
                                @endif
                                @if($ss_company_phone->updated_at != $ss_company_phone->created_at)
                                    <span style="font-size: 10px; color: gray;">{{ __('Previous update:') }} {{ $ss_company_phone->updated_at }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3 mt-5">
                            <div class="col-sm-5">
                                <label for="company_email" class="form-label fw-bold">{{ __('Company email') }}</label><br>
                                <small class="text-muted">{{ __('The main email address for contacting the company') }}</small>
                            </div>
                            <div class="col-sm-7">
                                <input type="email" class="form-control" id="company_email" name="company_email_value" value="{{ $ss_company_email->value }}">
                                <input type="hidden" class="form-control" id="company_email_previous_value" name="company_email_previous_value" value="{{ $ss_company_email->value }}">
                                @if($ss_company_email->previous_value && $ss_company_email->previous_value !== $ss_company_email->value)
                                    <span style="font-size: 10px; color: gray;">{{ __('Previous value:') }} {{ $ss_company_email->previous_value }}</span><br>
                                @endif
                                @if($ss_company_email->updated_at != $ss_company_email->created_at)
                                    <span style="font-size: 10px; color: gray;">{{ __('Previous update:') }} {{ $ss_company_email->updated_at }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3 mt-5">
                            <div class="col-sm-5">
                                <label for="company_website" class="form-label fw-bold">{{ __('Company website') }}</label><br>
                                <small class="text-muted">{{ __('Link to the organization` website') }}</small>
                            </div>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="company_website" name="company_website_value" value="{{ $ss_company_website->value }}">
                                <input type="hidden" class="form-control" id="company_website_previous_value" name="company_website_previous_value" value="{{ $ss_company_website->value }}">
                                @if($ss_company_website->previous_value && $ss_company_website->previous_value !== $ss_company_website->value)
                                    <span style="font-size: 10px; color: gray;">{{ __('Previous value:') }} {{ $ss_company_website->previous_value }}</span><br>
                                @endif
                                @if($ss_company_website->updated_at != $ss_company_website->created_at)
                                    <span style="font-size: 10px; color: gray;">{{ __('Previous update:') }} {{ $ss_company_website->updated_at }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3 mt-5">
                            <div class="col-sm-5">
                                <label for="company_logo_link" class="form-label fw-bold">{{ __('Company logo link') }}</label><br>
                                <small class="text-muted">{{ __('Link to the organization`s logo') }}</small>
                            </div>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="company_logo_link" name="company_logo_link_value" value="{{ $ss_company_logo_link->value }}">
                                <input type="hidden" class="form-control" id="company_logo_link_previous_value" name="company_logo_link_previous_value" value="{{ $ss_company_logo_link->value }}">
                                @if($ss_company_logo_link->previous_value && $ss_company_logo_link->previous_value !== $ss_company_logo_link->value)
                                    <span style="font-size: 10px; color: gray;">{{ __('Previous value:') }} {{ $ss_company_logo_link->previous_value }}</span><br>
                                @endif
                                @if($ss_company_logo_link->updated_at != $ss_company_logo_link->created_at)
                                    <span style="font-size: 10px; color: gray;">{{ __('Previous update:') }} {{ $ss_company_logo_link->updated_at }}</span>
                                @endif
                            </div>
                        </div><br>
                        <div class="row mb-1 mt-5">
                            <h3 class="fw-bold">{{ __('Additional informations') }}</h3>
                            <hr>
                        </div>
                        
                        <div class="row mb-3 mt-4">
                            <div class="col-sm-5">
                                <label for="signature" class="form-label fw-bold">{{ __('Company logo') }}</label><br>
                                <small class="text-muted">{{ __('Preview of company logo from "Company logo link"') }}</small>
                            </div>
                            <div class="col-sm-7">
                                <img src="{{ $ss_company_logo_link->value }}" style="width: 200px; height: 35px;" alt="Showing image is scaled to 200px x 35px" title="Showing image is scaled to 200px x 35px">
                            </div>
                        </div>
                        <div class="row mb-3 mt-5">
                            <div class="col-sm-5">
                                <label for="signature" class="form-label fw-bold">{{ __('License key') }}</label><br>
                                <small class="text-muted">{{ __('License key to use the application') }}</small>
                            </div>
                            <div class="col-sm-7">
                                {{ $ss_license_key->value }}
                            </div>
                        </div>
                        <div class="row mb-3 mt-5">
                            <div class="col-sm-5">
                                <label for="signature" class="form-label fw-bold">{{ __('License validity') }}</label><br>
                                <small class="text-muted">{{ __('Expiration date of the application license') }}</small>
                            </div>
                            <div class="col-sm-7">
                                {{ $ss_license_validity->value }}
                            </div>
                        </div>

                        <div class="row mb-1 mt-4">
                            <hr>
                        </div>
                        @can('AdminSystemSettings-W')
                            <button type="submit" class="btn btn-success float-end"><i class="bi bi-check2"></i> Save settings</button>
                        @endcan
                    </form>
                    </div>
                    </div>
                    <!-- END OF COLUMN -->
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
