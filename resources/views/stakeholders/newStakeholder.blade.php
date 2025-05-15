@extends('layouts.app')

@section('title')
    नयाँ सरोकारवाला
@endsection

@section('card-header')
    नयाँ सरोकारवाला
@endsection

@section('sub-links')
    <a href="{{ route('stakeholders') }}" class="btn btn-dark text-warning">
        <i class="fa-solid fa-list"></i>
    </a>
    <span onclick="window.history.back()" class="btn btn-dark text-warning">
        <i class="fa-solid fa-left-long"></i>
    </span>
@endsection

@section('content')

    <form method="POST" action="#">
        @csrf

        <div class="row mb-3">
            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('नाम') }}</label>

            <div class="col-md-6">
                <input id="name" type="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="off">

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="address" class="col-md-4 col-form-label text-md-end">{{ __('ठेगाना') }}</label>

            <div class="col-md-6">
                <input id="address" type="address" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" autocomplete="off">

                @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="contact" class="col-md-4 col-form-label text-md-end">{{ __('सम्पर्क') }}</label>

            <div class="col-md-6">
                <input id="contact" type="contact" class="form-control @error('contact') is-invalid @enderror" name="contact" value="{{ old('contact') }}" autocomplete="off">

                @error('contact')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-0">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-warning">
                    {{ __('थप्नुहोस') }}
                </button>
            </div>
        </div>
    </form>

@endsection
