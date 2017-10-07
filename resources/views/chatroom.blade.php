@extends('layouts.chat')

@section('chat-list')
    <div class="sidebar" data-background-color="black" data-active-color="danger">
        <div class="sidebar-wrapper">
            <div class="logo">
                <a href="{{ route('home') }}" class="simple-text">
                    Chats
                </a>
            </div>

            <ul class="nav">
                @foreach($chats as $chat)
                    <li class="text-center">
                        <a href="{{$chat->id}}">
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
            @foreach($messages as $message)
                @if($message->user_id == Auth::user()->id)
                    <div class="row">
                        <div class="col-sm-8 right">
                            <div class="card">
                                <div class="content">
                                    <div class="footer">
                                        <div class="stats">
                                            {{ Auth::user()->name }}
                                        </div>
                                        <hr />
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div>
                                                <p>{{ $message->message }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-sm-8 left">
                            <div class="card">
                                <div class="content">
                                    <div class="footer">
                                        <div class="stats">
                                            {{ App\User::find($message->user_id)->name }}
                                        </div>
                                        <hr />
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-5">
                                            <div>
                                                <p>{{ $message->message }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    <footer class="footer">
    <div class="container-fluid">
        <form method="POST" id="message_form">
            {{ csrf_field() }}
            <div class="row" style="padding: 10px">
                <div class="col-sm-11 col-xs-10">
                    <div class="form-group">
                        <input class="form-control border-input" type="text" id="message" name="message">
                    </div>
                </div>
                <div class="col-sm-1 col-xs-2">
                    <input type="hidden" id="chat_id" name="chat_id" value="{{ $chat_details->id }}">
                    <input type="hidden" id="chat_type" name="chat_type" value="{{ $chat_details->type }}">
                    <input type="hidden" id="chat_ind_id" name="chat_ind_id" value="{{ $chat_details->c_id }}">
                    <button type="submit" class="btn btn-sm btn-success btn-icon"><i class="fa fa-envelope"></i></button>
                </div>
            </div>
        </form>   
    </div>
</footer>
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

    <script type="text/javascript">
        $('#message_form').submit(function(event) {
            event.preventDefault();
            $.ajax({
                type : 'POST',
                url : '{{ route('send.message') }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data : {
                    message : $('#message').val(),
                    chat_id :  $('#chat_id').val()
                },
                success : function(res) {
                    $('#message').val('');
                }
            });
        })
        Echo.private('chat.' + {{ $chat_details->id }})
            .listen('MessageSent', (e) => {
                console.log(e);
                console.log('{{ Auth::user()->id }}')
                if(e.user == {{ Auth::user()->id }}) {
                    $('#chat_content').append('<div class="row"><div class="col-sm-8 right"><div class="card"><div class="content"><div class="footer"><div class="stats">{{ Auth::user()->name }}</div><hr /></div><div class="row"><div class="col-xs-12"><div><p>' + e.message +'</p></div></div></div></div></div></div></div>')
                } else {
                    $('#chat_content').append('<div class="row"><div class="col-sm-8 left"><div class="card"><div class="content"><div class="footer"><div class="stats">{{ $receiver->name }}</div><hr /></div><div class="row"><div class="col-xs-12"><div><p>' + e.message +'</p></div></div></div></div></div></div></div>')     
                }
            });
    </script>
@endpush