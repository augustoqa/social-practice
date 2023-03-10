@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="card border-0 bg-light shadow-sm">
                    <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="card-img-top">
                    <div class="card-body">
                        <div class="card-title">
                            {{ $user->name }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <status-list url="{{ route('users.statuses.index', $user) }}"></status-list>
            </div>
        </div>
    </div>
@endsection
