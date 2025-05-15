@extends('layouts.app')

@section('title')
पासवर्ड निस्चित गर्नुहोस
@endsection

@section('card-header')
पासवर्ड निस्चित गर्नुहोस
@endsection
@section('content')

                    {{ __('कृपया अगाडि वढ्नका लागि पासवर्ड निस्चित गर्नुहोस ।') }}

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('पासवर्ड') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('पासवर्ड निस्चित गर्नुहोस') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('पासवर्ड विर्सिनुभयो?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>

@endsection
