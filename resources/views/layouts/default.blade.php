<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.head')
</head>
<body>

<div id="app">
    <b-container>

        @include('includes.navbarbv')

        <b-breadcrumb items="items">
            <h5>@yield('title')</h5>
        </b-breadcrumb>

        @yield('content')


    </b-container>
</div>

@include('includes.foot')

</body>
</html>