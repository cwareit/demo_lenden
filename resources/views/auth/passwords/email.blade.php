@extends('layouts.app')
@section('title')
    पासवर्ड परिवर्तन
@endsection

@section('card-header')
    पासवर्ड परिवर्तन
@endsection
@section('content')



                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('ईमेल') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('पासवर्ड परिवर्तन गर्ने लिङ्क पठाउनुहोस') }}
                                </button>
                            </div>
                        </div>
                    </form>

@endsection
