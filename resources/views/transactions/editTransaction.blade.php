@extends('layouts.app')
@section('title')
{{$currentTransaction->stakeholder->name}} सँगको कारोवार सम्पादन गर्नुहोस
@endsection
@section('card-header')
{{$currentTransaction->stakeholder->name}} सँगको कारोवार सम्पादन गर्नुहोस
@endsection
@section('sub-links')
<a href="{{route('stakeholders')}}"  class="btn btn-dark text-warning"><i class="fa-solid fa-list"></i></a>
<a href="{{route('details', ['stakeholderId' => $currentTransaction->stakeholder->id])}}"  class="btn btn-dark text-warning"><i class="fa-solid fa-money-check-dollar"></i></a>
<span onclick="window.history.back()" class="btn btn-dark text-warning"><i class="fa-solid fa-left-long"></i></span>
@endsection
@section('content')
<link href="/css/ndp.css" rel="stylesheet" type="text/css"/>
<form method="POST" action="#">
   @csrf
   <div class="row mb-3">
      <label for="date" class="col-md-4 col-form-label text-md-end">{{ __('मिति') }}</label>
      <div class="col-md-6">
         <input readonly id="nepali-datepicker" type="text" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date') ?? $currentTransaction->date }}" autocomplete = "off">
         @error('date')
         <span class="invalid-feedback" role="alert">
         <strong>{{ $message }}</strong>
         </span>
         @enderror
      </div>
   </div>
   <div class="row mb-3">
      <label for="inOut" class="col-md-4 col-form-label text-md-end">{{ __('कारोवारको प्रकार') }}</label>
      <div class="col-md-6">
         <select name="inOut" id="inOut" class="form-control @error('inOut') is-invalid @enderror" autocomplete = "off">
            <option value="{{old('inOut')?? $currentTransaction->inOut ??''}}">{{old('inOut')?? $currentTransaction->inOut ?? 'छान्नुहोस'}}</option>
            <option value="लिएको">लिएको</option>
            <option value="दिएको">दिएको</option>
         </select>
         @error('inOut')
         <span class="invalid-feedback" role="alert">
         <strong>{{ $message }}</strong>
         </span>
         @enderror
      </div>
   </div>
   <div class="row mb-3">
      <label for="amount" class="col-md-4 col-form-label text-md-end">{{ __('रकम रु.') }}</label>
      <div class="col-md-6">
         <input id="amount" type="number"step="0.01" min="0" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount') ?? str_replace('-','',$currentTransaction->amount) }}" autocomplete = "off">
         @error('amount')
         <span class="invalid-feedback" role="alert">
         <strong>{{ $message }}</strong>
         </span>
         @enderror
      </div>
   </div>
   <div class="row mb-3">
      <label for="remarks" class="col-md-4 col-form-label text-md-end">{{ __('कैफियत (अतिरिक्त)') }}</label>
      <div class="col-md-6">
         <input id="remarks" type="text" class="form-control @error('remarks') is-invalid @enderror" name="remarks" value="{{ old('remarks') ?? $currentTransaction->remarks }}" autocomplete = "off">
         @error('remarks')
         <span class="invalid-feedback" role="alert">
         <strong>{{ $message }}</strong>
         </span>
         @enderror
      </div>
   </div>
   <div class="row mb-0">
      <div class="col-md-8 offset-md-4">
         <button type="submit" class="btn btn-warning">
         {{ __('सम्पादन गर्नुहोस') }}
         </button>
      </div>
   </div>
</form>
<script src="{{asset('/js/ndp.js')}}" type="text/javascript"></script>
        <script type="text/javascript">
            window.onload = function() {
                var mainInput = document.getElementById("nepali-datepicker");
                mainInput.nepaliDatePicker();
            };
        </script>
@endsection
