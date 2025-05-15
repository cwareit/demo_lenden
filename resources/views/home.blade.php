@extends('layouts.app')

@section('title')
लेनदेन / गृहपृष्ठ
@endsection

@section('card-header')
सरोकारवालाहरु
@endsection

@section('sub-links')
<a href="{{route('stakeholders')}}"  class="btn btn-dark text-warning"><i class="fa-solid fa-list"></i></a>
<a href="{{route('newStakeholder')}}" class="btn btn-dark text-warning"><i class="fa-solid fa-user-plus"></i></a>

@endsection


@section('content')
@php
$sn = 1;
$eng = ['0','1','2','3','4','5','6','7','8','9'];
$nep = ['०','१','२','३','४','५','६','७','८','९'];
@endphp

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>क्र. स.</th>
                <th>नाम</th>
                <th>ठेगाना</th>
                <th>सम्पर्क</th>
                <th>अवस्था</th>

            </tr>
        </thead>
        <tbody>
            @foreach($stakeholders as $stakeholder)

                <tr>
                    <td>{{str_replace($eng, $nep, $sn++)}}.</td>
                    <td>
                        <a href="{{route('details', ['stakeholderId' => $stakeholder->id])}}" class="text-decoration-none fw-bold">
                        {{$stakeholder->name}}
                        </a>
                    </td>
                    <td>{{$stakeholder->address}}</td>
                    <td>{{$stakeholder->contact}}</td>

                    @php
                            if($stakeholder->total > 0){
                                $amount = $stakeholder->total;
                                $status = 'दिनुपर्ने';
                                $class = 'danger';
                            } elseif($stakeholder->total < 0){
                                $amount = $stakeholder->total * (-1);
                                $status = 'लिनुपर्ने';
                                $class = 'success';
                            } else {
                                $amount = '';
                                $status = 'लेनदेन वाँकि छैन';
                                $class = 'info';
                            }
                        @endphp


                        <td class="text-{{$class}}">{{$amount}} {{$status}}</td>

                </tr>

            @endforeach
        </tbody>
    </table>
</div>

@endsection
