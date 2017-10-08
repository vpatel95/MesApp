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
                    <div class="row">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="card">
                        <form method="POST" action="{{ route('create.group') }}">
                            {{ csrf_field() }}
                            <div class="header">
                                <div class="form-group">
                                    <label>Enter Group Name</label>
                                    <input type="text" class="form-control border-input" placeholder="Group Name" name="name">
                                </div>
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
                                            <div class="checkbox">
                                                <input type="checkbox" name="group_member[]" value="{{ $user->id }}">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="footer">
                                    <hr>
                                    <div class="text-center">
                                    <button type="submit" class="btn btn-info btn-fill btn-wd">Create Group</button>
                                </div>
                            </div>
                        </form>
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

    <script src="{{ asset('js/bootstrap-checkbox-radio.js') }}"></script>
@push('scripts')
    <script src="{{ asset('js/chartist.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-notify.js') }}"></script>
    <script src="{{ asset('js/paper-dashboard.js') }}"></script>
@endpush