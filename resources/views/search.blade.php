@extends('layouts.chat')

@section('nav-heading', $receiver->name)

@section('chat-list')
    <div class="sidebar" data-background-color="black" data-active-color="danger">
        <div class="sidebar-wrapper">
            <div class="logo">
                <a href="{{ route('chat',['id' => $id]) }}" class="simple-text">
                    <i class="ti-arrow-left"></i>&nbsp;&nbsp;&nbsp;Back
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
                            @elseif($chat->type == 'group')
                                {{ App\GroupChat::find($chat->c_id)->name }}
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
                                            <hr/>
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
                                            <hr/>
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
                    @endif
            @endforeach
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

    <script type="text/javascript">
        $('#search_form').submit(function(event) {
            event.preventDefault();
            $.ajax({
                type : 'POST',
                url : '{{ route('search.message') }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data : {
                    query : $('#search').val(),
                    chat_id_search : $('#chat_id_search').val(),
                },
                success : function(res) {
                    console.log(res);
                }
            });
        });
    </script>
@endpush