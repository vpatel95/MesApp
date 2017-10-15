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
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="navbar-header">
                                <a class="navbar-brand" href="#">@yield('nav-heading')</a>
                            </div>
                        </div>
                        <div class="col-sm-5" id="search_bar">
                            <div class="navbar-header">
                                <form class="navbar-form" id="search_form" method="POST" action="{{ route('search') }}">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <input type="text" style="border: 2px solid #333;padding: 18px 10px;border-radius: 8px;color:#333;" class="form-control border-input" placeholder="Search" name="query" id="search" value="{{ request('query') }}">
                                        <button type="submit" class="btn" style="margin: 0px"><i class="ti-search"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <button type="button" class="navbar-toggle">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span>Chats</span>
                                </button>
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
                    </div>
                </div>
            </nav>


            @yield('content')

        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript">
        $('#search_form').submit(function(event) {
            e.preventDefault(event);
            $.ajax({
                type : 'POST',
                url : '{{ route('search') }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data : {
                    query : $('#search').val(),
                }
            });
        });
    </script>
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
