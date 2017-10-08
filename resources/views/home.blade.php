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
                    <a href="#">
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
                    <div class="col-md-6">
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
                                    <h4><a href="newchat/{{$user->id}}">{{ $user->name }}</a></h4><br>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card ">
                            <div class="header">
                                <h3 class="title">Your Chats</h3>
                                <hr>
                            </div>
                            <div class="content">
                                @foreach($chats as $chat)
                                    <h4>
                                        <a href="chat/{{$chat->id}}">
                                            @if($chat->type == 'personal')
                                                @if(App\PersonalChat::find($chat->c_id)->user_id_1 == Auth::user()->id)
                                                    {{ App\User::find(App\PersonalChat::find($chat->c_id)->user_id_2)->name }}
                                                @else
                                                    {{ App\User::find(App\PersonalChat::find($chat->c_id)->user_id_1)->name }}
                                                @endif
                                            @endif    
                                        </a>
                                    </h4><br>
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