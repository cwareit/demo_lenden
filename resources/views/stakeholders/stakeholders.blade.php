@extends('layouts.app')

@section('title')
    लेनदेन / सरोकारवालाहरु
@endsection

@section('card-header')
    सरोकारवालाहरु [{{$stakeholderCount}}]
@endsection

@section('sub-links')
    <a href="{{ route('notifications') }}" class="btn btn-dark text-warning">
        <i class="far fa-bell"></i>
        <span class="badge bg-danger rounded-circle">
            {{ $unreadCount }} <!-- Unread notifications count -->
        </span>
    </a>

    <a href="{{route('stakeholders')}}" class="btn btn-dark text-warning">
        <i class="fa-solid fa-list"></i>
    </a>

    <a href="{{route('newStakeholder')}}" class="btn btn-dark text-warning">
        <i class="fa-solid fa-user-plus"></i>
    </a>
@endsection

@section('content')
    @php
        $sn = 1;
        $eng = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $nep = ['०', '१', '२', '३', '४', '५', '६', '७', '८', '९'];
    @endphp

    <div class="row fw-bold">
        <!-- Total Given -->
        <div class="col-md-4">
            <div class="alert alert-success border-0">
                जम्मा लिनुपर्ने रकमः
                <hr>

                @if(session('display1') == true)
                    {{ number_format($totalGiven * (-1), 2, '.', '') }}
                @else
                    {{'XXXX.XX'}}
                @endif

                <span class="float-end">
                    @if(session('display1') == true)
                        <a href="{{route('display1')}}"><i class="fa-regular fa-eye-slash text-success"></i></a>
                    @else
                        <a href="{{route('display1')}}"><i class="fa-regular fa-eye text-success"></i></a>
                    @endif
                </span>
            </div>
        </div>

        <!-- Total Taken -->
        <div class="col-md-4">
            <div class="alert alert-danger border-0">
                जम्मा दिनुपर्ने रकमः
                <hr>

                @if(session('display2') == true)
                    {{ number_format($totalTaken, 2, '.', '') }}
                @else
                    {{'XXXX.XX'}}
                @endif

                <span class="float-end">
                    @if(session('display2') == true)
                        <a href="{{route('display2')}}"><i class="fa-regular fa-eye-slash text-danger"></i></a>
                    @else
                        <a href="{{route('display2')}}"><i class="fa-regular fa-eye text-danger"></i></a>
                    @endif
                </span>
            </div>
        </div>

        @php
            $totalGivenNegated = $totalGiven * (-1); // Calculate once to avoid redundancy

            if ($totalGivenNegated > $totalTaken) {
                $report = 'लिनुपर्ने बढि रकमः';
                $amount = $totalGivenNegated - $totalTaken;
            } elseif ($totalGivenNegated < $totalTaken) {
                $report = 'दिनुपर्ने बढि रकमः';
                $amount = $totalTaken - $totalGivenNegated;
            } else {
                $report = 'लेनदेन बराबरः';
                $amount = 0.00;
            }
        @endphp

        <!-- Report Section -->
        <div class="col-md-4">
            <div class="alert alert-dark border-0">
                {{$report}}
                <hr>

                @if(session('display3') == true)
                    {{ number_format($amount, 2, '.', '') }}
                @else
                    {{'XXXX.XX'}}
                @endif

                <span class="float-end">
                    @if(session('display3') == true)
                        <a href="{{route('display3')}}"><i class="fa-regular fa-eye-slash text-dark"></i></a>
                    @else
                        <a href="{{route('display3')}}"><i class="fa-regular fa-eye text-dark"></i></a>
                    @endif
                </span>
            </div>
        </div>
    </div>

    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

    <div class="table-responsive pb-3">
        <table class="display" id="example">
            <thead>
                <tr>
                    <th>नाम</th>
                    <th>ठेगाना</th>
                    <th>अवस्था</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stakeholders as $stakeholder)
                    @php
                        if ($stakeholder->total > 0) {
                            $amount = $stakeholder->total;
                            $status = 'दिनुपर्ने';
                            $class = 'danger';
                        } elseif ($stakeholder->total < 0) {
                            $amount = number_format($stakeholder->total * (-1), 2, '.', '');
                            $status = 'लिनुपर्ने';
                            $class = 'success';
                        } else {
                            $amount = '';
                            $status = 'लेनदेन वाँकि छैन';
                            $class = 'info';
                        }
                    @endphp

                    <tr>
                        <td>
                            <a href="{{ route('details', ['stakeholderId' => $stakeholder->id]) }}" class="text-decoration-none fw-bold">
                                {{ $stakeholder->name }}
                            </a>
                        </td>
                        <td>{{ $stakeholder->address }}</td>
                        <td class="text-{{$class}}">
                            {{ $amount }} {{ $status }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
@endsection
