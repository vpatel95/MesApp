@extends('layouts.chat')

@section('nav-heading', 'Welcome to MesApp')
@section('chat-list')
    <div class="sidebar" data-background-color="black" data-active-color="danger">
    
        <div class="sidebar-wrapper">
            <div class="logo">
                <a href="{{ route('home') }}" class="simple-text">
                    {{ Auth::user()->name }}
                </a>
            </div>

            <ul class="nav">
                <li class="active">
                    <a href="{{ route('groups') }}">
                        <i class="ti-user"></i>
                        <p>Create Group</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
<div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="card">
                            <div class="header">
                                <h3 class="title">All Registered users</h3>
                                <hr>
                            </div>
                            <div class="content">
                                @foreach($users as $user)
                                    @if($user->id == Auth::user()->id)
                                        @continue
                                    @endif
                                    <div class="row">
                                        <div class="col-xs-10 col-md-9">
                                            <h4><a href="newchat/{{$user->id}}">{{ $user->name }}</a></h4><br>
                                        </div>
                                        <div class="col-xs-2 col-md-3">
                                        
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@push('styles')
    <link href="{{ asset('css/animate.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/paper-dashboard.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/demo.css') }}" rel="stylesheet" />
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="{{ asset('css/themify-icons.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/bootstrap-checkbox-radio.js') }}"></script>
    <script src="{{ asset('js/chartist.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-notify.js') }}"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
    <script src="{{ asset('js/paper-dashboard.js') }}"></script>
@endpush