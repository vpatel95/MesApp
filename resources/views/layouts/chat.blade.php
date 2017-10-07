<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<title>MesApp - ChatRoom</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet"/>
    @stack('styles')
</head>
<body>
    <div class="wrapper">

        @yield('chat-list')

        <div class="main-panel">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle">
                            <span class="sr-only">Toggle navigation</span>
                            <span>Chats</span>
                        </button>
                        <a class="navbar-brand" href="#">{{ $receiver->name }}</a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="ti-panel"></i>
                                    <p>{{ Auth::user()->name }}</p>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    <i class="ti-settings"></i>
                                    <p>Logout</p>
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>

                    </div>
                </div>
            </nav>


            @yield('content')

        </div>
    </div>
</body>

<script src="{{ asset('js/app.js') }}"></script>
	
@stack('scripts')

</html>
