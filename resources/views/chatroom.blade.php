@extends('layouts.chat')

@section('chat-list')
    <div class="sidebar" data-background-color="black" data-active-color="danger">
        <div class="sidebar-wrapper">
            <div class="logo">
                <a href="http://www.creative-tim.com" class="simple-text">
                    Chats
                </a>
            </div>

            <ul class="nav">
                @foreach($chats as $chat)
                    <li class="text-center">
                        <a href="chat/{{$chat->id}}">
                            @if($chat->type == 'personal')
                                @if(App\PersonalChat::find($chat->c_id)->user_id_1 == Auth::user()->id)
                                    <p>{{ App\User::find(App\PersonalChat::find($chat->c_id)->user_id_2)->name }}</p>
                                @else
                                    <p>{{ App\User::find(App\PersonalChat::find($chat->c_id)->user_id_1)->name }}</p>
                                @endif
                            @endif    
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid" id="chat_content">
            <div class="row">
                <div class="col-sm-8 right">
                    <div class="card">
                        <div class="content">
                            <div class="footer">
                                <div class="stats">
                                    {{ $user->name }}
                                </div>
                                <hr />
                            </div>
                            <div class="row">
                                <div class="col-xs-5">
                                    <div>
                                        <p>This is a message</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-8 left">
                    <div class="card">
                        <div class="content">
                            <div class="footer">
                                <div class="stats">
                                    {{ $receiver->name }}
                                </div>
                                <hr />
                            </div>
                            <div class="row">
                                <div class="col-xs-5">
                                    <div>
                                        <p>This is a message</p>
                                    </div>
                                </div>
                            </div>
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