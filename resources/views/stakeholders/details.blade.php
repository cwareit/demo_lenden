@extends('layouts.app')

@section('title')
    {{$currentStakeholder->name}} सँगका कारोवारहरु
@endsection

@section('card-header')
    {{$currentStakeholder->name}} सँगका कारोवारहरु
@endsection

@section('sub-links')
    <a href="{{ route('stakeholders') }}" class="btn btn-dark text-warning">
        <i class="fa-solid fa-list"></i>
    </a>
    <a href="{{ route('newTransaction', ['stakeholderId' => $currentStakeholder->id]) }}" class="btn btn-dark text-warning">
        <i class="fa-solid fa-circle-plus"></i>
    </a>
    <span onclick="window.history.back()" class="btn btn-dark text-warning">
        <i class="fa-solid fa-left-long"></i>
    </span>
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>मिति</th>
                    <th>प्रयोगकर्ता</th>
                    <th>प्रकार</th>
                    <th>रकम रु.</th>
                    <th>अवस्था</th>
                    <th>कैफियत</th>
                    <th>कार्य</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->date }}</td>
                        <td>{{ $transaction->user }}</td>
                        <td>{{ $transaction->inOut }}</td>
                        <td>{{ $transaction->amount }}</td>

                        @php
                            if ($transaction->cumulative_sum > 0) {
                                $amount = number_format($transaction->cumulative_sum, 2, '.', '');
                                $status = 'दिनुपर्ने';
                                $class = 'danger';
                            } elseif ($transaction->cumulative_sum < 0) {
                                $amount = number_format($transaction->cumulative_sum * (-1), 2, '.', '');
                                $status = 'लिनुपर्ने';
                                $class = 'success';
                            } else {
                                $amount = '';
                                $status = 'चुक्ता भयो';
                                $class = 'info';
                            }
                        @endphp
                        <td class="text-{{ $class }}">{{ $amount }} {{ $status }}</td>
                        <td>{{ $transaction->remarks }}</td>
                        <td>
                            <a href="{{ route('editTransaction', ['transactionId' => $transaction->id]) }}" class="my-1 btn btn-dark text-warning">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a onclick="return confirm('के तपाईँ यो कारोबार साँच्चै डिलिट गर्न चाहनुहुन्छ ?')" href="{{ route('deleteTransaction', ['transactionId' => $transaction->id]) }}" class="my-1 btn btn-dark text-warning">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <hr>

    <div class="alert alert-warning text-center mb-0 border-0">
        <div class="fw-bold">
            {{ $currentStakeholder->name }}
        </div>
        <div>
            {{ $currentStakeholder->address }}
        </div>
        <div>
            {{ $currentStakeholder->contact }}
        </div>
        <hr>
        <a href="{{ route('editStakeholder', ['stakeholderId' => $currentStakeholder->id]) }}" class="my-1 btn btn-dark text-warning">
            <i class="fa-solid fa-pen-to-square"></i> {{ $currentStakeholder->name }} का व्यक्तिगत विवरणहरु सम्पादन गर्नुहोस ।
        </a>
        <br>

        <button class="my-1 btn btn-outline-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            अरु विकल्पहरु
        </button>
        <br>

        <div class="collapse" id="collapseExample">
            <a data-bs-toggle="modal" data-bs-target="#deleteTransactions" href="" class="my-1 btn btn-dark text-warning">
                <i class="fas fa-trash"></i> {{ $currentStakeholder->name }} का सम्पूर्ण कारोबारहरु डिलिट गर्नुहोस ।
            </a>
            <br>
            <a data-bs-toggle="modal" data-bs-target="#deleteStakeholder" href="" class="my-1 btn btn-dark text-warning">
                <i class="fas fa-trash"></i> {{ $currentStakeholder->name }} का सम्पूर्ण कारोबारहरु साथै व्यक्तिगत विवरणहरु समेत डिलिट गर्नुहोस ।
            </a>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="deleteStakeholder" tabindex="-1" aria-labelledby="deleteStakeholderLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-warning">
                    <h5 class="modal-title fw-bold" id="deleteModalLabel">सावधान !!!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <p class="mb-0">
                        <ul>
                            <li class="text-danger">
                                {{ $currentStakeholder->name }} का सम्पूर्ण कारोबारहरु डिलिट हुनेछन ।
                            </li>
                            <li class="text-danger">
                                {{ $currentStakeholder->name }} का व्यक्तिगत विवरणहरु समेत डिलिट हुनेछन ।
                            </li>
                            <li class="text-danger">
                                डिलिट भईसकेका विवरणहरु फिर्ता गर्न सकिने छैन ।
                            </li>
                        </ul>
                    </p>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <a href="{{ route('deleteStakeholder', ['stakeholderId' => $currentStakeholder->id]) }}" class="btn btn-dark text-warning">हुन्छ</a>
                    <button type="button" class="btn btn-dark text-warning" data-bs-dismiss="modal">हुँदैन</button>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="deleteTransactions" tabindex="-1" aria-labelledby="deleteTransactionsLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-warning">
                    <h5 class="modal-title fw-bold" id="deleteModalLabel">सावधान !!!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <p class="mb-0">
                        <ul>
                            <li class="text-danger">
                                {{ $currentStakeholder->name }} का सम्पूर्ण कारोबारहरु डिलिट हुनेछन ।
                            </li>
                            <li class="text-success">
                                {{ $currentStakeholder->name }} का व्यक्तिगत विवरणहरु भने डिलिट हुनेछैनन् ।
                            </li>
                            <li class="text-danger">
                                डिलिट भईसकेका विवरणहरु फिर्ता गर्न सकिने छैन ।
                            </li>
                        </ul>
                    </p>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <a href="{{ route('deleteTransactions', ['stakeholderId' => $currentStakeholder->id]) }}" class="btn btn-dark text-warning">हुन्छ</a>
                    <button type="button" class="btn btn-dark text-warning" data-bs-dismiss="modal">हुँदैन</button>
                </div>

            </div>
        </div>
    </div>

@endsection
