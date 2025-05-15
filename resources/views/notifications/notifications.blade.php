@extends('layouts.app')

@section('title')
    लेनदेन / नोटिफिकेशनहरु
@endsection

@section('card-header')
    नोटिफिकेशनहरु
@endsection

@section('sub-links')
    <a href="{{ route('stakeholders') }}" class="btn btn-dark text-warning">
        <i class="fa-solid fa-left-long"></i>
    </a>
@endsection

@section('content')
    <ul class="list-group">
        @foreach ($notifications as $notification)
            <li class="list-group-item">
                {{ $notification->notification }}
                
                <small class="text-muted float-end"> 
                    ({{ $notification->created_at->diffForHumans() }})

                    @php
                        $isRead = $notification->readers->contains('readerId', auth()->id());
                    @endphp

                    @if (!$isRead)
                        <a href="{{ route('readNotification', ['notificationId' => $notification->id]) }}">
                            <span class="btn btn-outline-dark text-warning"> 
                                <i class="fa-solid fa-check"></i>
                            </span>
                        </a>
                    @endif
                </small>
            </li>
        @endforeach
    </ul>

    <div class="mt-3 mb-0">
        {{ $notifications->links('pagination::bootstrap-5') }}
    </div>
@endsection
