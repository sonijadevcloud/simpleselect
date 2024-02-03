@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <div class="row">
    <!-- Pierwsza Karta -->
    <div class="col-md-6">
      <div class="card mb-3 shadow cardhoversuccess rounded-2" style="max-width: 540px;">
        <div class="row g-0">
          <div class="col-md-4">
            <div class="bg-success text-light d-flex align-items-center justify-content-center full-heightc rounded-start-2"><i class="bi bi-plus-lg" style="font-size: 4rem;"></i></div>
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <h5 class="card-title"><b>{{ __('Create') }}</b> {{ __('a ticket') }}</h5>
              <p class="card-text">{{ __('Create a new ticket if you need help, pricing or modifications') }}</p>
              <p class="card-text"><button class="btn btn-sm btn-dark"><i class="bi bi-patch-check"></i> {{ __('Submit new request') }}</button></p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Druga Karta -->
    <div class="col-md-6">
      <div class="card mb-3 shadow cardhoverprimary rounded-2" style="max-width: 540px;">
        <div class="row g-0">
          <div class="col-md-4">
            <div class="bg-primary text-light d-flex align-items-center justify-content-center full-heightc rounded-start-2"><i class="bi bi-search" style="font-size: 4rem;"></i></div>
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <h5 class="card-title"><b>{{ __('Check') }}</b> {{ __('a status') }}</h5>
              <p class="card-text">{{ __('Check the status of your created ticket in few single steps') }}</p>
              <p class="card-text"><button class="btn btn-sm btn-dark"><i class="bi bi-search-heart"></i> {{ __('Check a status') }}</button></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
