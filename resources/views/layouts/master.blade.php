<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta property="og:image" content="http://ec2-54-165-116-38.compute-1.amazonaws.com/img/songRefs.png" />
<title>@hasSection('title') @yield('title') - SongRefs @else SongRefs @endif</title>
<link rel="stylesheet prefetch" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<style>
@media screen and (max-width: 800px){
input, select, textarea{font-size: 16px !important;}/*prevent zoom on mobile*/
}
.xs,.m{display:inline}
input.xs,select.xs{width:50px}
input.m{width:100%;max-width:300px}
.auto{width:auto;display:inline}
label{font-weight:normal}
.borderTop{border-top:1px solid #777;padding:5px 0}
.padBottom{padding-bottom:10px}
</style>
</head>
<body>
<div class="container">

<nav class="navbar navbar-default navbar-static-top">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    SongRefs
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li>{{HTML::linkAction('ArtistController@index','Artists')}}</li>
                    @if (!Auth::guest())
                    <li><a href="javascript:void(0);" id="modalFeedback">Feedback</a></li>
                    <li><a href="javascript:void(0);" class="modalHints">Hints</a></li>
                    @endif
                </ul>
                
                <!-- Center of Navbar -->
                

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                <li>
                    <form action="/search/" method="get" class="navbar-form">
                        <div class="input-group">
                            <input type="search" name="search" class="form-control" />
                            <div class="input-group-btn">
                                <button class="form-control btn btn-info">
                                <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </div>
                        </div>
                    </form>
                </li>
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }}
                                @if (Auth::user()->points)
                                    ({{Auth::user()->points}})
                                @endif
                                <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
    </nav>

@include('common.modal')
@include('common.errors')


@if(Session::has('flash_message'))
    <div class="alert alert-success"><em> {!! session('flash_message') !!}</em></div>
@endif

@yield('content')
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script src="/main.js"></script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-83379866-1', 'auto');
  ga('send', 'pageview');
</script>
</body>
</html>
