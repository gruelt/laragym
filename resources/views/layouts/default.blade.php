<!DOCTYPE html>

<html lang="fr">
<head>
@include('includes.head')
<!-- Style -->
@yield('style')

</head>

<body>
<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-sm fixed-top navbar-light bg-light" role="navigation">
        @include('includes.header')
        @include('sidebars.sidebar')
    </nav>

    <!-- Page content -->
    <div id="page-wrapper">
        @if(isset($errors) && !empty($errors->first()))
            <div class="row col-lg-12">
                <div class="alert alert-danger">
                    <span>{!! $errors->first() !!}</span>
                </div>
            </div>
        @endif

        @if(isset($message))
            <div class="row col-lg-12">
                <div class="alert alert-info">
                    <span>{!! $message !!}</span>
                </div>
            </div>
        @endif

            @yield('title')


        @yield('content')

    </div>
</div>

@include('includes.foot')
<!-- Scripts -->
@yield('script')
</body>
</html>
