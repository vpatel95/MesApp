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
                        <a class="navbar-brand" href="#">@yield('nav-heading')</a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a href="{{ route('home') }}" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="ti-home"></i>
                                    <p>Home</p>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    <i class="ti-close"></i>
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

    <script src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            if($(window).width()<768){
                window.location.href="/warning";
            }
            $('.main-panel').scrollTop($('.main-panel')[0].scrollHeight);
        });
    </script>
    
@stack('scripts')
</body>

</html>
