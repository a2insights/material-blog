<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.png') }}">
    <meta name="description" content="{{ $blog->description }}">
    <meta name="author" content="{{ $blog->user->name }}">
    <title>{{ $blog->name }}</title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link href="{{ asset('vendor/octo/themes/material-blog/assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <!-- Material Kit CSS -->
    <link href="{{ asset('vendor/octo/themes/material-blog/assets/css/material-kit.css') }}" rel="stylesheet">
</head>

<body>
<nav class="navbar navbar-color-on-scroll navbar-transparent fixed-top navbar-expand-lg" color-on-scroll="100">
    <div class="container">
        <div class="navbar-translate">
            <a class="navbar-brand" href="/{{$blog->guard_name}}">{{$blog->name}}</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="sr-only">Toggle navigation</span>
                <span class="navbar-toggler-icon"></span>
                <span class="navbar-toggler-icon"></span>
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/">HasBlog</a>
                </li>
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="/dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();
                               ">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
<div class="page-header header-filter" data-parallax="true" style="background-image: url('{{asset('vendor/octo/themes/material-blog/assets/img/home-bg.jpg')}}')">
    <div class="container">
        <div class="row">
            <div class="col-md-8 ml-auto mr-auto">
                <div class="brand text-center">
                    <h1>{{$blog->name}}</h1>
                    <h3 class="title text-center">{{$blog->description}}</h3>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Main Content -->
<div id="content" class="main main-raised">
    <div class="container {{ isset($_GET['page']) ? 'mt-5 pt-5' : '' }}">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                @foreach($posts as $post)
                    <div class="post-preview">
                        <h1 class="post-title">
                            {{$post->title}}
                        </h1>
                        <p class="post-subtitle ">
                            {!! $post->content !!}
                        </p>
                        <p class="post-meta mb-1">Posted at
                            {{$post->created_at}}
                        </p>
                        @can('update' , $post)
                            <form method="POST" id="destroyPost-{{$post->id}}" action="/dashboard/post/{{$post->id}}">
                                <a class="btn px-0 btn-link text-primary" href="/dashboard/post/{{$post->id}}/edit">edit</a>
                                {{ method_field('DELETE') }}
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button
                                    type="submit"
                                    onclick="
                                        event.preventDefault();
                                        let destroy = confirm('Really want to delete the post');
                                        if(destroy){ document.getElementById('destroyPost-{{$post->id}}').submit() }
                                        "
                                    class="btn btn-link ml-2 px-0 text-danger"
                                >
                                    delete
                                </button>
                            </form>
                        @endauth
                    </div>
                    <hr>
                @endforeach
                @if($posts->currentPage() !== $posts->lastPage() || $posts->lastPage() !== 1)
                    <div class="clearfix">
                        <a tabindex="-1" class="btn btn-primary {{$posts->previousPageUrl() ? '' : 'disabled'}} float-left" href="{{$posts->previousPageUrl()}}#content">News Posts &rarr;</a>
                        <p class="text-center text-muted pt-2">
                            <a class="btn btn-primary {{$posts->nextPageUrl() ? '' : 'disabled'}} float-right" href="{{$posts->nextPageUrl()}}#content">Older Posts &rarr;</a>
                            Page: {{ $posts->currentPage() }} | Pages: {{ $posts->lastPage() }}
                        </p>
                        <div class="row text-center mb-5">
                            <div class="col text-muted">
                                <small>Showing {{ $posts->currentPage() }} of {{ $posts->lastPage() }} pages and a total of {{ $posts->total() }} posts</small>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <hr class="mb-0">
</div>
<footer class="footer footer-default">
    <div class="container">
        <nav class="float-left">
            <ul>
                <li>
                    <a href="/">
                        HasBlog
                    </a>
                </li>
            </ul>
        </nav>
        <div class="copyright float-right">
            &copy; {{ $blog->name }}
        </div>
    </div>
</footer>
<script src="{{ asset('vendor/octo/themes/material-blog/assets/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/octo/themes/material-blog/assets/vendor/popper/popper.min.js') }}"></script>
<script src="{{ asset('vendor/octo/themes/material-blog/assets/vendor/bootstrap/js/bootstrap-material-design.min.js') }}"></script>
<script src="{{ asset('vendor/octo/themes/material-blog/assets/vendor/nouislider/nouislider.min.js') }}"></script>
<!-- Custom scripts for this template -->
<script src="{{ asset('vendor/octo/themes/material-blog/assets/js/material-kit.min.js') }}"></script>
</body>

</html>
