<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.head')
</head>
<body>

<div id="app">
    <b-container fluid>

        @include('includes.navbarbv')

        @yield('title')

        @yield('content')


    </b-container>
</div>

@include('includes.foot')
@yield('script')
</body>
</html>