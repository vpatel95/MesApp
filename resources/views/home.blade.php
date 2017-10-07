@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-5 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">All Users</div>

                <div class="panel-body">
                    @foreach($users as $user)
                        @if($user->id == Auth::user()->id)
                            @continue
                        @endif
                        <a href="newchat/{{$user->id}}">{{ $user->name }}</a><br>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-5 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Chats</div>

                <div class="panel-body">
                    @foreach($chats as $chat)
                        <a href="chat/{{$chat->id}}">
                            @if($chat->type == 'personal')
                                @if(App\PersonalChat::find($chat->c_id)->user_id_1 == Auth::user()->id)
                                    {{ App\User::find(App\PersonalChat::find($chat->c_id)->user_id_2)->name }}
                                @else
                                    {{ App\User::find(App\PersonalChat::find($chat->c_id)->user_id_1)->name }}
                                @endif
                            @endif    
                        </a>
                        <br>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
